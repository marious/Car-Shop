<?php

namespace Modules\Base\Services\Concerns;

trait HasName
{
    /**
     * @var ?string
     * @example "name"
     */
    public ?string $name = null;

    /**
     * @param ?string $name
     * @return $this
     */
    public function name(?string $name): static
    {
        $this->name = $name;
        return $this;
    }
}
