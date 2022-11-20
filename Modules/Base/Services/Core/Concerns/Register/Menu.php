<?php

namespace Modules\Base\Services\Core\Concerns\Register;

trait Menu
{
    private static ?array $menu = [];

    public static function registerMenu(\Modules\Base\Services\Components\Base\Menu $item): void
    {
        self::$menu[] = $item;
    }
}
