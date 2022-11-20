<?php

namespace Modules\Base\Services\Concerns;

trait IsUnique
{
    /**
     * @var ?bool
     */
    public ?bool $unique = false;

    /**
     * @return $this
     */
    public function unique(bool $unique = true): static
    {
        $this->unique = $unique;
        return $this;
    }
}
