<?php

namespace Modules\Init\Service\Generators\Traits;

use Illuminate\Support\Str;
use Modules\Init\Service\Generators\Controller;
use Modules\Init\Service\Generators\Model;

trait Names
{
    public string $tableName;
    public string $moduleName;
    public string $modelBaseName;
    public string $modelFullName;
    public string $modelPlural;
    public string $modelVariableName;
    public string $modelRouteAndViewName;
    public string $modelNamespace;
    public string $modelWithNamespaceFromDefault;
    public string $modelViewsDirectory;
    public string $modelDotNotation;
    public string $modelJSName;
    public string $modelLangFormat;
    public string $resource;
    public string $exportBaseName;
    public string $titleSingular;
    public string $titlePlural;
    public string $controllerWithNamespaceFromDefault;

    protected function initCommonNames(
        $moduleName,
        $tableName,
        $modelName = null,
        $controllerName = null,
        $modelWithFullNamespace = null
    ) {
        $this->tableName = $tableName;
        $this->moduleName = $moduleName;

        if ($this instanceof Model) {
            $modelGenerator = $this;
        } else {
            $modelGenerator = app(Model::class);
            $modelGenerator->setLaravel($this->laravel);
        }

        if (is_null($modelName)) {
            $modelName = $modelGenerator->generateClassNameFromTable($this->moduleName, $this->tableName);
        }

        $this->modelFullName = $modelGenerator->qualifyClass($this->moduleName, $modelName);

        $this->modelBaseName = class_basename($modelName);
        $this->modelPlural = Str::plural(class_basename($modelName));
        $this->modelVariableName = lcfirst(Str::singular(class_basename($this->modelBaseName)));
        $this->modelRouteAndViewName = Str::plural(Str::lower(Str::kebab($this->modelBaseName)));
        $this->modelNamespace = Str::replaceLast("\\" . $this->modelBaseName, '', $this->modelFullName);
        if (!Str::startsWith($this->modelFullName,
            $startsWith = trim($modelGenerator->rootNamespace($this->moduleName), '\\') . '\Entities\\')) {
            $this->modelWithNamespaceFromDefault = $this->modelBaseName;
        } else {
            $this->modelWithNamespaceFromDefault = Str::replaceFirst($startsWith, '', $this->modelFullName);
        }

        $this->modelViewsDirectory = Str::plural(Str::lower(Str::kebab(implode('/',
            collect(explode('\\', $this->modelWithNamespaceFromDefault))->map(function ($part) {
                return lcfirst($part);
            })->toArray()))));

        $parts = collect(explode('\\', $this->modelWithNamespaceFromDefault));
        $parts->pop();
        $parts->push($this->modelPlural);
        $this->resource = Str::lower(Str::kebab(implode('', $parts->toArray())));

        $this->modelDotNotation = str_replace('/', '.', $this->modelViewsDirectory);
        $this->modelJSName = Str::plural(str_replace('/', '-', $this->modelViewsDirectory));
        $this->modelLangFormat = str_replace('/', '_', $this->modelViewsDirectory);

        if ($this instanceof Controller) {
            $controllerGenerator = $this;
        } else {
            $controllerGenerator = app(Controller::class);
            $controllerGenerator->setLaravel($this->laravel);
        }

        if (is_null($controllerName)) {
            $controllerName = $controllerGenerator->generateClassNameFromTable($this->moduleName, $this->tableName);
        }


        $controllerFullName = $controllerGenerator->qualifyClass($this->moduleName, 'Http\\Controllers\\' .
            $controllerName);


        if (!Str::startsWith($controllerFullName,
                $startsWith = trim($controllerGenerator->rootNamespace($this->moduleName), '\\') . '\Http\\Controllers\\')
            && !Str::startsWith($controllerFullName,
                $startsWith = trim($controllerGenerator->rootNamespace($this->moduleName), '\\') . '\Http\\Controllers\\Api\\'
            )) {
            $this->controllerWithNamespaceFromDefault = $controllerFullName;
        } else {
            $this->controllerWithNamespaceFromDefault = $controllerFullName;
        }

        if (!empty($modelWithFullNamespace)) {
            $this->modelFullName = $modelWithFullNamespace;
        }
        $this->exportBaseName = Str::studly($tableName) . 'Export';

        $this->titleSingular = Str::singular(str_replace(['_'], ' ', Str::title($this->tableName)));
        $this->titlePlural = str_replace(['_'], ' ', Str::title($this->tableName));
    }

    public function valueWithoutId($string)
    {
        if (Str::endsWith(Str::lower($string), '_id')) {
            $string = Str::substr($string, 0, -3);
        }

        return Str::ucfirst(str_replace('_', ' ', $string));
    }

}
