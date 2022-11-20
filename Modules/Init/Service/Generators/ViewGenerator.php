<?php

namespace Modules\Init\Service\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Init\Service\Generators\Traits\Columns;
use Modules\Init\Service\Generators\Traits\Helpers;
use Modules\Init\Service\Generators\Traits\Names;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ViewGenerator extends Command
{
    use Helpers, Columns, Names;

    protected Filesystem $files;

    protected $relations = [];

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function getArguments()
    {
        return [
            ['module-name', InputArgument::REQUIRED, 'Name of the existing module'],
            ['table-name', InputArgument::REQUIRED, 'Name of the existing table'],
        ];
    }

    /**
     * Append content to file only if if the content is not present in the file
     *
     * @param $path
     * @param $content
     * @return bool
     */
    protected function appendIfNotAlreadyAppended($path, $content): bool
    {
        if (!$this->files->exists($path)) {
            $this->makeDirectory($path);
            $this->files->put($path, $content);
        } else if (!$this->alreadyAppended($path, $content)) {
            $this->files->append($path, $content);
        } else {
            return false;
        }

        return true;
    }

    /**
     * Execute the console command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initCommonNames($this->argument('module-name'), $this->argument('table-name'), $this->option('model-name'));

        return parent::execute($input, $output);
    }
}