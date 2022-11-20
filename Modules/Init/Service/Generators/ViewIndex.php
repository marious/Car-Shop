<?php

namespace Modules\Init\Service\Generators;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ViewIndex extends ViewGenerator
{
    protected $name = 'fb:generate:index';

    protected $description = 'Generate an index view template';

    protected string $view = 'index';

    protected bool $export = false;

    protected bool $withoutBulk = false;

    public function handle()
    {
        $force = $this->option('force');


        if($this->option('with-export')){
            $this->export = true;
        }

        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.index';
        }

        if($this->option('without-bulk')){
            $this->withoutBulk = true;
        }

        $viewPath = base_path('Modules/'.$this->moduleName.'/Resources/views'.'/Index.vue');


        if ($this->option('folder')) {
            $viewPath = base_path('Modules/'.$this->moduleName . '/Resources/views/' . $this->option('folder') .'/Index.vue');
        }


        if ($this->alreadyExists($viewPath) && !$force) {
            $this->error('File '.$viewPath.' already exists!');
        } else {
            if ($this->alreadyExists($viewPath) && $force) {
                $this->warn('File '.$viewPath.' already exists! File will be deleted.');
                $this->files->delete($viewPath);
            }

            $this->makeDirectory($viewPath);

            $this->files->put($viewPath, $this->buildView());

            $this->info('Generating '.$viewPath.' finished');
        }
    }

    protected function buildView(): string
    {
        return view('init::'.$this->view, [
            'modelBaseName' => $this->modelBaseName,
            'modelRouteAndViewName' => Str::plural($this->modelRouteAndViewName),
            'modelPlural' => $this->modelPlural,
            'modelViewsDirectory' => $this->modelViewsDirectory,
            'modelJSName' => $this->modelJSName,
            'modelVariableName' => $this->modelVariableName,
            'modelDotNotation' => $this->modelDotNotation,
            'modelLangFormat' => $this->modelLangFormat,
            'modelTitle' => $this->titleSingular,
            'modelTitlePlural' => $this->titlePlural,
            'resource' => $this->resource,
            'export' => $this->export,
            'containsPublishedAtColumn' => in_array("published_at", array_column($this->readColumnsFromTable($this->tableName)->toArray(), 'name')),
            'withoutBulk' => $this->withoutBulk,
            'columnsToQuery' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "created_at"  || $column['name'] == 'updated_at' || $column['name'] == "deleted_at"||Str::contains($column['name'],"_id"));
            })->pluck('name')->toArray(),
            'columns' => $this->readColumnsFromTable($this->tableName)->reject(function($column) {
                return ($column['type'] == 'text'
                    || in_array($column['name'], ["password", "remember_token", "slug", "created_at", "updated_at", "deleted_at"])
                    || ($column['type'] == 'json' && in_array($column['name'], ["perex", "text", "body"]))
                );
            })->map(function($col){

                $filters = collect([]);
                $col['switch'] = false;

                if ($col['type'] == 'date' || $col['type'] == 'time' || $col['type'] == 'datetime') {
                    $filters->push($col['type']);
                }

                if ($col['type'] == 'boolean' && ($col['name'] == 'enabled' || $col['name'] == 'activated' || $col['name'] == 'is_published')) {
                    $col['switch'] = true;
                }

                $col['filters'] = $filters->isNotEmpty() ? ' | '.implode(' | ', $filters->toArray()) : '';

                return $col;
            }),
//            'filters' => $this->readColumnsFromTable($tableName)->filter(function($column) {
//                return $column['type'] == 'boolean' || $column['type'] == 'date';
//            }),
        ])->render();
    }

    protected function getOptions() {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating index'],
            ['with-export', 'e', InputOption::VALUE_NONE, 'Generate an option to Export as Excel'],
            ['without-bulk', 'wb', InputOption::VALUE_NONE, 'Generate without bulk options'],
            ['folder', 'fo', InputOption::VALUE_OPTIONAL, 'Generate at sub Folder inside a module'],
        ];
    }
}
