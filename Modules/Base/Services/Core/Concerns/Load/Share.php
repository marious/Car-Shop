<?php

namespace Modules\Base\Services\Core\Concerns\Load;

trait Share
{
    private static ?array $share = [];

    public static function loadShareData(): ?array
    {
        return self::$share;
    }
}
