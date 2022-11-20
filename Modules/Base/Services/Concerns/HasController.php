<?php

namespace Modules\Base\Services\Concerns;

trait HasController
{
    /**
     * @var ?string
     * @example "name"
     */
    public ?string $controller = null;

    /**
     * @param ?string $controller
     * @return $this
     */
    public function controller(?string $controller): static
    {
        $this->controller = $controller;
        return $this;
    }
}
