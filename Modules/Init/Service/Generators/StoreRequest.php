<?php

namespace Modules\Init\Service\Generators;

use Symfony\Component\Console\Input\InputOption;

class StoreRequest extends ClassGenerator
{

    protected $name = 'fb:generate:request:store';

    protected $description = 'Generate a Store request class';

    protected string $view = 'store-request';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $force = $this->option('force');

        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.store-request';
        }

        if(!empty($belongsToMany = $this->option('belongs-to-many'))) {
            $this->setBelongToManyRelation($belongsToMany);
        }

        if ($this->generateClass($force)){
            $this->info('Generating '.$this->classFullName.' finished');
        }
    }

    protected function buildClass(): string
    {
        $this->setBelongsToRelations();
        return view('init::'.$this->view, [
            'modelBaseName' => $this->modelBaseName,
            'moduleName'    => $this->moduleName,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'tableName' => $this->tableName,
            'modelFullName'                 => $this->modelFullName,

            // validation in store/update
            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName),
            'translatable' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return $column['type'] == "json";
            })->pluck('name'),
            'relatable' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return in_array($column['name'],$this->relations["belongsTo"]->pluck('foreign_key')->toArray());
            })->keyBy('name'),
            'relations' => $this->relations,
        ])->render();
    }

    protected function getOptions() {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['belongs-to-many', 'btm', InputOption::VALUE_OPTIONAL, 'Specify belongs to many relations'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating request'],
        ];
    }

    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return 'Store'.$this->modelBaseName . 'Request';
    }

    protected function getDefaultNamespace(string $rootNamespace) : string
    {
        return $rootNamespace.'\Http\Requests\\'.$this->modelWithNamespaceFromDefault;
    }
}