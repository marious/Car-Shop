<?php

namespace Modules\Base\Services\Rows\Interfaces;

interface Component
{
    /**
     * @return static
     */
    public static function make(string $name): self;
}
