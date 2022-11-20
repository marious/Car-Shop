<?php

namespace Modules\Base\Services\Rows;

use Modules\Base\Services\Rows\Abstracts\Base;

class Media extends Base
{
    public string $vue = 'ViltMedia.vue';

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name): self
    {
        return (new self)->name($name);
    }
}
