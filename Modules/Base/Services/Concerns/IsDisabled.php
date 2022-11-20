<?php

namespace Modules\Base\Services\Concerns;

trait IsDisabled {
    /**
     * @var ?bool
     */
    public ?bool $disabled = false;

    /**
     * @return $this
     */
    public function disabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;
        return $this;
    }
}
