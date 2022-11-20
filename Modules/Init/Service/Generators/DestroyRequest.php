<?php

namespace Modules\Init\Service\Generators;

use Symfony\Component\Console\Input\InputOption;

class DestroyRequest extends ClassGenerator
{

    protected $name = 'fb:generate:request:destroy';

    protected $description = 'Generate a Destroy request class';

    public function handle()
    {
        $force = $this->option('force');

        if ($this->generateClass($force)) {
            $this->info('Generating ' . $this->classFullName . ' finished');
        }
    }

    protected function buildClass(): string
    {

        return view('init::destroy-request', [
            'moduleName' => $this->moduleName,
            'modelBaseName' => $this->modelBaseName,
            'modelFullName' => $this->modelFullName,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'modelVariableName' => $this->modelVariableName,
        ])->render();
    }


    protected function getOptions()
    {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating request'],
        ];
    }

    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return 'Destroy' . $this->modelBaseName . 'Request';
    }


    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace . '\Http\Requests\\' . $this->modelWithNamespaceFromDefault;
    }
}