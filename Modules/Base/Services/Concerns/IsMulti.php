<?php

namespace Modules\Base\Services\Concerns;

trait IsMulti
{
    /**
     * @var ?bool
     */
    public ?bool $multi = false;

    /**
     * @return $this
     */
    public function multi(bool $multi = true): static
    {
        $this->multi = $multi;
        return $this;
    }
}
