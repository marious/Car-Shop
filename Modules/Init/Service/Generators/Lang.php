<?php

namespace Modules\Init\Service\Generators;

use Symfony\Component\Console\Input\InputOption;

class Lang extends FileAppender
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'fb:generate:lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Append admin translations into a admin lang file';

    /**
     * Path for view
     *
     * @var string
     */
    protected string $view = 'lang';

    /**
     * Lang has also export translation
     *
     * @return mixed
     */
    protected bool $export = false;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.lang';
        }

        if(empty($locale = $this->option('locale'))) {
            $locale = 'en';
        }

        if($this->option('with-export')){
            $this->export = true;
        }

        if(!empty($belongsToMany = $this->option('belongs-to-many'))) {
            $this->setBelongToManyRelation($belongsToMany);
        }


        if ($this->replaceIfNotPresent(resource_path('lang/'.$locale.'/admin.php'),  "// Do not delete me :) I'm used for auto-generation".PHP_EOL,$this->buildClass().PHP_EOL, "<?php".PHP_EOL.PHP_EOL."return [".PHP_EOL."    // Do not delete me :) I'm used for auto-generation".PHP_EOL."];")){
            $this->info('Appending translations finished');
        }
    }

    protected function buildClass(): string
    {
        return view('init::'.$this->view, [
            'modelLangFormat' => $this->modelLangFormat,
            'modelBaseName' => $this->modelBaseName,
            'modelPlural' => $this->modelPlural,
            'titleSingular' => $this->titleSingular,
            'titlePlural' => $this->titlePlural,
            'export' => $this->export,
            'containsPublishedAtColumn' => in_array("published_at", array_column($this->readColumnsFromTable($this->tableName)->toArray(), 'name')),

            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName)->map(function ($column) {
                $column['defaultTranslation'] = $this->valueWithoutId($column['name']);
                return $column;
            }),
            'relations' => $this->relations,
        ])->render();
    }

    protected function getOptions() {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a controller for the given model'],
            ['locale', 'c', InputOption::VALUE_OPTIONAL, 'Specify custom locale'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['belongs-to-many', 'btm', InputOption::VALUE_OPTIONAL, 'Specify belongs to many relations'],
            ['with-export', 'e', InputOption::VALUE_NONE, 'Generate an option to Export as Excel'],
        ];
    }


}