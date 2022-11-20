<?php

namespace Modules\Base\Services\Resource\Concerns\Core;


use Modules\Base\Services\Components\Base\Router;

trait Route
{
    public ?bool $page = false;

    public function routes()
    {
        return Router::make($this->table)->middleware(['auth:sanctum'])->controller(static::class)->custom($this->route())->page($this->page)->api($this->api)->get();
    }

    public function route(): array
    {
        $routes = [];
        foreach($this->components() as $component){
            if($component->classType === 'route'){
                $routes[] = $component;
            }
        }

        return $routes;
    }
}
