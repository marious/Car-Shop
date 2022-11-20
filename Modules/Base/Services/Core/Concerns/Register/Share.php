<?php

namespace Modules\Base\Services\Core\Concerns\Register;

trait Share
{
    /**
     * @param \Modules\Base\Services\Components\Base\Share $item
     * @return void
     */
    public static function registerShareData(\Modules\Base\Services\Components\Base\Share $item): void
    {
        self::$share[$item->name] = $item->data;
    }
}
