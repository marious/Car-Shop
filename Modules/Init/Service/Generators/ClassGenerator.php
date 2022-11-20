<?php

namespace Modules\Init\Service\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Modules\Init\Service\Generators\Traits\Columns;
use Modules\Init\Service\Generators\Traits\Helpers;
use Modules\Init\Service\Generators\Traits\Names;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ClassGenerator extends Command
{
    use Helpers, Columns, Names;

    public string $classBaseName;
    public string $classFullName;
    public string $classNamespace;

    protected Filesystem $files;

    protected $relations = [];

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }


    /**
     * Generate default class name (for case if not passed as argument) from table name
     *
     * @param $tableName
     * @return mixed
     */
    abstract public function generateClassNameFromTable($module, $tableName): mixed;

    /**
     * Build the class with the given name.
     *
     * @return string
     */
    abstract protected function buildClass(): string;




    public function getPathFromClassName($name)
    {
        $path = str_replace('\\', '/', $name).".php";
        return preg_replace('|^Modules/|', 'Modules/', $path);
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    public function rootNamespace(string $moduleName): string
    {
        return "Modules\\$moduleName\\";
    }

    public function getNamespace(string $name): string
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param string $name
     * @return string
     */
    public function qualifyClass(string $moduleName, string $name): string
    {
        $name = str_replace('/', '\\', $name);

        $rootNamespace = $this->rootNamespace($moduleName);

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        return $this->qualifyClass($moduleName,
            $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );

    }



    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace;
    }

    protected function getArguments(): array
    {
        return [
            ['module-name', InputArgument::REQUIRED, 'Name of the existing module'],
            ['table-name', InputArgument::REQUIRED, 'Name of the existing table'],
            ['class-name', InputArgument::OPTIONAL, 'Name of the generated class'],
        ];
    }

    protected function generateClass($force = false): bool
    {
        $path = base_path($this->getPathFromClassName($this->classFullName));
        if ($this->alreadyExists($path)) {
            if($force) {
                $this->warn('File '.$path.' already exists! File will be deleted.');
                $this->files->delete($path);
            } else {
                //TODO: Backup the class then generate a new one... for recovery purposes.
                $this->error('File '.$path.' already exists!');
                return false;
            }
        }


        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass());
        return true;
    }

    /**
     * Execute the console command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this instanceof Model) {
            $this->initCommonNames($this->argument('module-name'), $this->argument('table-name'), $this->argument('class-name'), null,
                $this->option('model-with-full-namespace'));
        } else {
            $this->initCommonNames($this->argument('module-name'), $this->argument('table-name'), $this->option('model-name'), null,
                $this->option('model-with-full-namespace'));
        }

        $this->initClassNames($this->argument('class-name'));

        return parent::execute($input, $output);
    }

    protected function initClassNames($module, $className = null) {
        if (empty($className)) {
            $className = $this->generateClassNameFromTable($module, $this->tableName);
        }

        $this->classFullName = $this->qualifyClass($this->argument('module-name'), $className);
        $this->classBaseName = class_basename($this->classFullName);
        $this->classNamespace = Str::replaceLast("\\".$this->classBaseName, '', $this->classFullName);
    }

}