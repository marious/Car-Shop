<?php

namespace Modules\Init\Service\Generators;

use Illuminate\Support\Str;
use Modules\Init\Service\Generators\Traits\FileManipulation;
use Symfony\Component\Console\Input\InputOption;

class Controller extends ClassGenerator
{
    use FileManipulation;

    protected $name = 'fb:generate:controller';

    protected $description = 'Generate a web controller class';

    protected string $view = 'controller';

    protected bool $export = false;

    protected bool $withoutBulk = false;

    protected string $modelTitle;

    public function handle()
    {
        $force = $this->option('force');

        if ($this->option('with-export')) {
            $this->export = true;
        }

        if ($this->option('without-bulk')) {
            $this->withoutBulk = true;
        }

        if (!empty($template = $this->option('template'))) {
            $this->view = 'templates.' . $template . '.controller';
        }

        if (!empty($belongsToMany = $this->option('belongs-to-many'))) {
            $this->setBelongToManyRelation($belongsToMany);
        }

        if ($this->generateClass($force)) {

            $this->info('Generating ' . $this->classFullName . ' finished');

        }

    }


    protected function buildClass(): string
    {



        $this->setBelongsToRelations();
        return view('init::' . $this->view, [
            'folder' => $this->option('folder') ?: null,
            'moduleName' => $this->moduleName,
            'controllerBaseName' => $this->classBaseName,
            'controllerNamespace' => $this->classNamespace,
            'repoBaseName' => $this->getRepositoryBaseName(),
            "repoFullName" => $this->getRepoNamespace($this->rootNamespace($this->moduleName)).'\\'
                .$this->getRepositoryBaseName(),
            'modelBaseName' => $this->modelBaseName,
            'modelFullName' => $this->modelFullName,
            'modelPlural' => $this->modelPlural,
            'modelTitle' => $this->titleSingular,
            'modelVariableName' => $this->modelVariableName,
            'modelRouteAndViewName' => $this->modelRouteAndViewName,
            'modelViewsDirectory' => $this->modelViewsDirectory,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'export' => $this->export,
            'withoutBulk' => $this->withoutBulk,
            'exportBaseName' => $this->exportBaseName,
            'resource' => $this->resource,
            'containsPublishedAtColumn' => in_array("published_at", array_column($this->readColumnsFromTable($this->tableName)->toArray(), 'name')),
            // index
            'columnsToQuery' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "deleted_at" || Str::contains($column['name'], "_id"));
            })->pluck('name')->toArray(),
            'columnsToSearchIn' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                return ($column['type'] == 'json' || $column['type'] == 'text' || $column['type'] == 'string' || $column['name'] == "id") && !($column['name'] == "password" || $column['name'] == "remember_token");
            })->pluck('name')->toArray(),
            //            'filters' => $this->readColumnsFromTable($tableName)->filter(function($column) {
            //                return $column['type'] == 'boolean' || $column['type'] == 'date';
            //            }),
            // validation in store/update
            'hasTranslatable' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                    return $column['type'] == "json";
                })->count() > 0,
            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName),
            'relations' => $this->relations,
            'hasSoftDelete' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                    return $column['name'] == "deleted_at";
                })->count() > 0,
        ])->render();
    }

    protected function getOptions()
    {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['belongs-to-many', 'btm', InputOption::VALUE_OPTIONAL, 'Specify belongs to many relations'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating controller'],
            ['model-with-full-namespace', 'fnm', InputOption::VALUE_OPTIONAL, 'Specify model with full namespace'],
            ['with-export', 'e', InputOption::VALUE_NONE, 'Generate an option to Export as Excel'],
            ['without-bulk', 'wb', InputOption::VALUE_NONE, 'Generate without bulk options'],
            ['folder', 'fo', InputOption::VALUE_OPTIONAL, 'The Folder for front'],
        ];
    }

    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return  Str::studly(Str::singular($tableName) . 'Controller');
    }

    protected function getDefaultNamespace(string $rootNamespace) :string
    {
        return $rootNamespace.'\Http\Controllers\Admin';
    }

    protected function getRepoNamespace($rootNamespace): string
    {
        return $rootNamespace.'Repositories';
    }
    protected function getRepositoryBaseName(): string
    {
        return Str::studly(Str::singular($this->tableName)).'Repository';
    }
}
