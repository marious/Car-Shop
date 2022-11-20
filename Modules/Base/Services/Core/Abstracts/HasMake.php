<?php

namespace Modules\Base\Services\Core\Abstracts;

use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Core\Interfaces\HelperHasMake;

class HasMake implements HelperHasMake
{
    use HasName;

    /**
     * @param ?string $name
     * @return static
     */
    public static function make(?string $name): static
    {
        return (new static)->name($name);
    }
}
