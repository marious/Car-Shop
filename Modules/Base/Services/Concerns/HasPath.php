<?php

namespace Modules\Base\Services\Concerns;

trait HasPath
{
    /**
     * @var ?string
     * @example "name"
     */
    public ?string $path = null;

    /**
     * @param ?string $path
     * @return $this
     */
    public function path(?string $path): static
    {
        $this->path = $path;
        return $this;
    }
}
