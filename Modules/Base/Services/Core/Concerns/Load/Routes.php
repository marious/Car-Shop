<?php

namespace Modules\Base\Services\Core\Concerns\Load;

trait Routes
{
    private static ?array $routes = [];

    public static function loadRoutes(): ?array
    {
        return self::$routes;
    }
}
