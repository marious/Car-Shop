<?php

namespace Modules\Base\Services\Concerns;

trait HasAction
{
    public ?string $action = null;

    /**
     * @param ?string $action
     * @return static
     */
    public function action(?string $action): static {
        $this->action = $action;
        return $this;
    }
}
