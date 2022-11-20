<?php

namespace Modules\Base\Services\Core\Concerns\Register;


use Modules\Base\Services\Components\Base\Lang;

trait Translation
{
    /**
     * @param Lang $item
     * @return void
     */
    public static function registerTranslation(Lang $item): void
    {
        self::$translations[$item->name] = $item->label;
    }
}
