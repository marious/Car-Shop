<?php

namespace Modules\Base\Services\Core\Interfaces;

interface HelperHasMake
{
    public static function make(string $name): self;
}
