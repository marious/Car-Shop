<?php

namespace Modules\Init\Service\Generators;

use Symfony\Component\Console\Input\InputOption;

class IndexRequest extends ClassGenerator
{

    protected $name = 'fb:generate:request:index';

    protected $description = 'Generate an Index request class';

    protected string $view = 'index-request';


    public function handle()
    {
        $force = $this->option('force');

        if (!empty($template = $this->option('template'))) {
            $this->view = 'templates.' . $template . '.index-request';
        }

        if ($this->generateClass($force)) {
            $this->info('Generating ' . $this->classFullName . ' finished');
        }
    }

    protected function buildClass(): string
    {

        return view('init::' . $this->view, [
            'moduleName' => $this->moduleName,
            'modelBaseName' => $this->modelBaseName,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'modelVariableName' => $this->modelVariableName,
            'modelFullName' => $this->modelFullName,
            'columnsToQuery' => $this->readColumnsFromTable($this->tableName)->filter(function ($column) {
                return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "created_at" || $column['name'] == "updated_at" || $column['name'] == "deleted_at");
            })->pluck('name')->toArray(),
        ])->render();
    }

    protected function getOptions()
    {
        return [
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating request'],
        ];
    }

    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return 'Index'.$this->modelBaseName;
    }


    protected function getDefaultNamespace(string $rootNamespace) :string
    {
        return $rootNamespace.'\Http\Requests\\'.$this->modelWithNamespaceFromDefault;
    }
}