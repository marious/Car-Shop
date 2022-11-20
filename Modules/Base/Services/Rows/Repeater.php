<?php

namespace Modules\Base\Services\Rows;


use Modules\Base\Services\Rows\Abstracts\Base;

class Repeater extends Base
{
    public string $vue = "ViltRepeater.vue";

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name): self
    {
        return (new self)->name($name);
    }
}
