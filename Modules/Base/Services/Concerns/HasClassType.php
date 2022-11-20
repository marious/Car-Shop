<?php

namespace Modules\Base\Services\Concerns;

trait HasClassType
{
    /**
     * @var ?string
     * @example 12
     */
    public ?string $classType = null;

    public function classType($classType): static
    {
        $this->classType = $classType;
        return $this;
    }
}
