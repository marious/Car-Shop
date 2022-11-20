<?php
namespace Modules\Init\Service\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ViltFileBaseGenerator extends Command
{
    protected $name = "fb:generate";
    protected $description ="Scaffold a whole CRUD module";
    protected $files;

    public function handle(Filesystem $files)
    {
        $this->files = $files;

        $moduleNameArgument = $this->argument('module-name');
        $tableNameArgument = $this->argument('table-name');
        $modelOption = $this->option('model-name');
        $controllerOption = $this->option('controller-name');
        $repositoryOption = $this->option('repository-name');
        $policyOption = $this->option('policy-name');
        $exportOption = $this->option('with-export');
        $withoutBulkOptions = $this->option('without-bulk');
        $force = $this->option('force');
        $template = $this->option('template');
        $folderArgument = $this->option('folder');


        $this->call('fb:generate:model', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            'class-name' => $modelOption,
            '--force' => $force,
            '--template' => $template,
        ]);

        $this->call('fb:generate:request:index', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--template' => $template,
        ]);

        $this->call('fb:generate:request:store', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--template' => $template,
        ]);

        $this->call('fb:generate:request:update', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--template' => $template,
        ]);

        $this->call('fb:generate:request:destroy', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--force' => $force,
        ]);

        $this->call('fb:generate:repository', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            'class-name' => $repositoryOption,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--with-export' => $exportOption,
            '--without-bulk' => $withoutBulkOptions,
            '--template' => $template,
        ]);

        $this->call('fb:generate:resource', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            'class-name' => $repositoryOption,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--with-export' => $exportOption,
            '--without-bulk' => $withoutBulkOptions,
            '--template' => $template,
        ]);

//        $this->call('fb:generate:api:controller', [
//            'module-name' => $moduleNameArgument,
//            'table-name' => $tableNameArgument,
//            'class-name' => $controllerOption,
//            '--model-name' => $modelOption,
//            '--force' => $force,
//            '--with-export' => $exportOption,
//            '--without-bulk' => $withoutBulkOptions,
//            '--template' => $template,
//        ]);

        $this->call('fb:generate:controller', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            'class-name' => $controllerOption,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--with-export' => $exportOption,
            '--without-bulk' => $withoutBulkOptions,
            '--template' => $template,
        ]);

        $this->call('fb:generate:index', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--folder' => $folderArgument,
            '--force' => $force,
            '--with-export' => $exportOption,
            '--without-bulk' => $withoutBulkOptions,
            '--template' => $template,
        ]);



        $this->call('fb:generate:policy', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--with-export' => false,
            '--without-bulk' => false,
            '--template' => $template,
        ]);

//        if ($this->shouldGeneratePermissionsMigration()) {
            $this->call('fb:generate:permissions', [
                'module-name' => $moduleNameArgument,
                'table-name' => $tableNameArgument,
                '--model-name' => $modelOption,
                '--force' => $force,
                '--without-bulk' => $withoutBulkOptions,
            ]);

            if ($this->option('no-interaction') || $this->confirm('Do you want to attach generated permissions to the default role now?', true)) {
                $this->call('migrate');
            }
//        }


        $this->call('fb:generate:form', [
            'module-name' => $moduleNameArgument,
            'table-name' => $tableNameArgument,
            '--folder' => $folderArgument,
            '--model-name' => $modelOption,
            '--force' => $force,
            '--template' => $template,
        ]);

        $this->info('Generating whole admin CRUD module finished');

    }

    protected function getArguments() {
        return [
            ['module-name', InputArgument::REQUIRED, 'Name of the existing Module'],
            ['table-name', InputArgument::REQUIRED, 'Name of the existing table'],
        ];
    }


    protected function getOptions() {
        return [
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom model name'],
            ['class-name', 'cl', InputOption::VALUE_OPTIONAL, 'Specify custom Class name'],
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Specify custom model name'],
            ['controller-name', 'c', InputOption::VALUE_OPTIONAL, 'Specify custom controller name'],
            ['repository-name', 'r', InputOption::VALUE_OPTIONAL, 'Specify custom repository class name'],
            ['policy-name', 'p', InputOption::VALUE_OPTIONAL, 'Specify custom Policy class name'],
            ['seed', 's', InputOption::VALUE_NONE, 'Seeds the table with fake data'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating admin'],
            ['with-export', 'e', InputOption::VALUE_NONE, 'Generate an option to Export as Excel'],
            ['without-bulk', 'wb', InputOption::VALUE_NONE, 'Generate without bulk options'],
            ['folder', 'fo', InputOption::VALUE_OPTIONAL, 'Generate at sub Folder inside a module'],
        ];
    }


}
