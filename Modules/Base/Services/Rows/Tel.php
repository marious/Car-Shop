<?php

namespace Modules\Base\Services\Rows;

use Modules\Base\Services\Rows\Abstracts\Base;

class Tel extends Base
{
    public string $vue = 'ViltTel.vue';

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name): self
    {
        return (new self)->name($name);
    }
}
