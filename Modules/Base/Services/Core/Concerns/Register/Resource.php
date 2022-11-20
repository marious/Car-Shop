<?php

namespace Modules\Base\Services\Core\Concerns\Register;

trait Resource
{
    /**
     * @param $item
     * @return void
     */
    public static function registerResource($item): void
    {
        $menu = app($item)->menus();

        foreach ($menu as $m) {
            self::registerMenu($m);
        }

        self::$routes[] = app($item)->routes();
    }
}
