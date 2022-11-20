<?php

namespace Modules\Base\Services\Concerns;

trait HasValue
{
    /**
     * @var ?string
     * @example 12
     */
    public ?string $value = null;

    public function value($value): static
    {
        $this->value = $value;
        return $this;
    }
}
