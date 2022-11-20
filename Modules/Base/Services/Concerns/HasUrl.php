<?php

namespace Modules\Base\Services\Concerns;

trait HasUrl
{
    public ?string $url = null;

    /**
     * @param ?string $url
     * @return static
     */
    public function url(?string $url): static // ?static
    {
        $this->url = $url;
        return $this;
    }
}
