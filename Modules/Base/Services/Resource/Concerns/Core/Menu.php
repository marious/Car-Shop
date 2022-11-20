<?php

namespace Modules\Base\Services\Resource\Concerns\Core;

use Illuminate\Support\Str;

trait Menu
{
    /**
     * @return array
     */
    public function menus(): array
    {
        $menus = [
            \Modules\Base\Services\Components\Base\Menu::make(Str::ucfirst($this->table))
                ->label($this->table . '.sidebar')
                ->icon($this->icon)
                ->route($this->table . '.index')
                ->group($this->group)
                ->can('view_any_' . $this->table)
                ->sort(1)
        ];
        return array_merge($menus, $this->menu());
    }

    /**
     * @return array
     */
    public function menu(): array
    {
        return [];
    }
}
