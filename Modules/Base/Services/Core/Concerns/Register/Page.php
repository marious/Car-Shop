<?php

namespace Modules\Base\Services\Core\Concerns\Register;

trait Page
{
    public static function registerPage($item): void
    {
        $menu = app($item)->menus();

        foreach ($menu as $key => $m) {
            self::registerMenu($m, $key);
        }

        self::$routes[] = app($item)->routes();
    }
}
