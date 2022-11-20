<?php

namespace Modules\Base\Services\Concerns;

trait IsRequired
{
    /**
     * @var ?bool
     */
    public ?bool $required = false;

    public function required(bool $required = true): static
    {
        $this->required = $required;
        return $this;
    }
}
