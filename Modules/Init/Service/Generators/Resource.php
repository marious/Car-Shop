<?php

namespace Modules\Init\Service\Generators;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Resource extends ClassGenerator
{

    protected $name = 'fb:generate:resource';

    protected $description = 'Generate a resource class';

    protected string $view = 'resource';

    public function handle()
    {
        $force = $this->option('force');

        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.resource';
        }

        if(!empty($belongsToMany = $this->option('belongs-to-many'))) {
            $this->setBelongToManyRelation($belongsToMany);
        }

        if ($this->generateClass($force)){
            $this->info('Generating '.$this->modelBaseName .' finished');
        }

        /*Generate a Factory Skeleton for the model*/

  //      $this->info('Generating '.$this->modelBaseName."Resource".' finished');
    }

    protected function buildClass(): string
    {
        $this->setBelongsToRelations();


        return view('init::' . $this->view, [
            'resourceBaseName' => $this->classBaseName,
            'resourceNamespace' => $this->classNamespace,
            'modelBaseName' => $this->modelBaseName,
            'modelFullName' => $this->modelFullName,
            'modelPlural' => $this->modelPlural,
            'modelTitle' => $this->titleSingular,
            'modelVariableName' => $this->modelVariableName,
            'modelVariableNamePlural' => Str::plural($this->modelVariableName),
            'modelRouteAndViewName' => $this->modelRouteAndViewName,
            'modelViewsDirectory' => $this->modelViewsDirectory,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'resource' => $this->resource,
            // index
            'columnsToQuery' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return !($column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "deleted_at"||Str::contains($column['name'],"_id"));
            })->pluck('name')->toArray(),
            'columnsToSearchIn' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return ($column['type'] == 'json' || $column['type'] == 'text' || $column['type'] == 'string' || $column['name'] == "id") && !($column['name'] == "password" || $column['name'] == "remember_token");
            })->pluck('name')->toArray(),
            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName),
            'relations' => $this->relations,
            'hasSoftDelete' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                    return $column['name'] == "deleted_at";
                })->count() > 0,
        ])->render();
    }


    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return  Str::studly(Str::singular($tableName) . 'Resource');
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

    protected function getDefaultNameSpace(string $rootNamespace): string
    {
        return $rootNamespace . '\Http\Resources\Inertia';
    }
}
