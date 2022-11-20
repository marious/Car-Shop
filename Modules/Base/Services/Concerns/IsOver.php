<?php

namespace Modules\Base\Services\Concerns;

trait IsOver
{
    /**
     * @var ?bool
     */
    public ?bool $over = false;

    /**
     * @return $this
     */
    public function over(bool $over = true): static
    {
        $this->over = $over;
        return $this;
    }
}
