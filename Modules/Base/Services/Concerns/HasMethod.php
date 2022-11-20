<?php

namespace Modules\Base\Services\Concerns;

trait HasMethod
{
    /**
     * @var ?string
     * @example "name"
     */
    public ?string $method = null;

    /**
     * @param ?string $method
     * @return $this
     */
    public function method(?string $method): static
    {
        $this->method = $method;
        return $this;
    }
}
