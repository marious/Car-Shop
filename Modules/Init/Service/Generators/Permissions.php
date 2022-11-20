<?php

namespace Modules\Init\Service\Generators;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Permissions extends ClassGenerator
{

    protected $name = 'fb:generate:permissions';

    protected $description = 'Generate permissions migration';

    protected bool $withoutBulk = false;

    public function handle()
    {
        $force = $this->option('force');

        if ($this->option('without-bulk')) {
            $this->withoutBulk = true;
        }

        if ($this->generateClass($force)) {
            $this->info('Generating permissions for ' . $this->modelBaseName . ' finished');
        }
    }

    protected function generateClass($force = false): bool
    {
        $fileName = 'fill_permissions_for_' . str_replace("-", "_", $this->modelRouteAndViewName) . '.php';
        $path = base_path('Modules/' . $this->moduleName . '/Database/Migrations/' . date('Y_m_d_His', time()) . '_' .
    $fileName);

        if ($oldPath = $this->alreadyExists($fileName)) {
            $path = $oldPath;
            if ($force) {
                $this->warn('File ' . $path . ' already exists! File will be deleted.');
                $this->files->delete($path);
            } else {
                $this->error('File ' . $path . ' already exists!');
                return false;
            }
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass());
        return true;
    }

    /**
     * Determine if the file already exists.
     *
     * @param $path
     * @return bool
     */
    protected function alreadyExists($path): bool
    {
        foreach ($this->files->files(base_path('Modules/'.$this->moduleName . '/Database/Migrations')) as $file) {
            if (str_contains($file->getFilename(), $path)) {
                return $file->getPathname();
            }
        }
        return false;
    }

    protected function buildClass(): string
    {
        return view('init::permissions', [
            'modelBaseName' => $this->modelBaseName,
            'modelPlural' => $this->modelPlural,
            'titlePlural' => $this->titlePlural,
            'titleSingular' => $this->titleSingular,
            'modelPermissionName' => $this->modelRouteAndViewName,
            'modelDotNotation' => $this->modelDotNotation,
            'className' => $this->generateClassNameFromTable($this->moduleName, $this->tableName),
            'withoutBulk' => $this->withoutBulk,
        ])->render();
    }

    protected function getOptions()
    {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating request'],
            ['without-bulk', 'wb', InputOption::VALUE_NONE, 'Generate without bulk options'],
        ];
    }

    public function generateClassNameFromTable($module, $tableName): mixed
    {
        return 'FillPermissionsFor' . Str::plural($this->modelBaseName);
    }


}