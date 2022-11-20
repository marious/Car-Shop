<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasName;

class Component
{
    use HasName;
    public ?bool $action = false;
    public ?bool $modal = false;
    public ?bool $route = false;
    public ?bool $widget = false;

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name): static
    {
        return (new static)->name($name);
    }

    public function get(string $type): mixed
    {
        $className= app($this->name);
        $classData = $className->get();
        $classData->classType = $type;
        return $classData;
    }

    public function action(?bool $action=true): mixed
    {
        $this->action = $action;
        return $this->get('action');
    }

    public function modal(?bool $modal=true): mixed
    {
        $this->modal = $modal;
        return $this->get('modal');
    }

    public function widget(?bool $widget=true): mixed
    {
        $this->widget = $widget;
        return $this->get('widget');
    }

    public function route(?bool $route=true): mixed
    {
        $this->route = $route;
        return $this->get('route');
    }
}
