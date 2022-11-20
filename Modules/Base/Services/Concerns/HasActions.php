<?php

namespace Modules\Base\Services\Concerns;

trait HasActions
{
    public ?array $actions = [];

    /**
     * @param array $actions
     * @return $this
     */
    public function actions(array $actions): static
    {
        $this->actions = $actions;
        return $this;
    }
}
