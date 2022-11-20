<?php

namespace Modules\Init\Service\Generators;

use Symfony\Component\Console\Input\InputOption;

class UpdateRequest extends ClassGenerator
{

    protected $name = 'fb:generate:request:update';

    protected $description = 'Generate an Update request class';

    protected string $view = 'update-request';

    public function handle()
    {
        $force = $this->option('force');

        if (!empty($template = $this->option('template'))) {
            $this->view = 'templates.' . $template . '.update-request';
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
            'moduleName' => $this->moduleName,
            'modelBaseName' => $this->modelBaseName,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'modelVariableName' => $this->modelVariableName,
            'modelFullName' => $this->modelFullName,
            'tableName' => $this->tableName,
            'containsPublishedAtColumn' => in_array("published_at", array_column($this->readColumnsFromTable($this->tableName)->toArray(), 'name')),

            // validation in store/update
            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName),
            'translatable' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                return $column['type'] == "json";
            })->pluck('name'),
            'relatable' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                return in_array($column['name'], $this->relations["belongsTo"]->pluck('foreign_key')->toArray());
            })->keyBy('name'),
            'hasSoftDelete' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                    return $column['name'] == "deleted_at";
                })->count() > 0,
            'relations' => $this->relations,
        ])->render();
    }

    protected function getOptions()
    {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['belongs-to-many', 'btm', InputOption::VALUE_OPTIONAL, 'Specify belongs to many relations'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating request'],
        ];
    }

    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return 'Update' . $this->modelBaseName . 'Request';
    }


    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace . '\Http\Requests\\' . $this->modelWithNamespaceFromDefault;
    }


}
