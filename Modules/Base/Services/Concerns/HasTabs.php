<?php

namespace Modules\Base\Services\Concerns;

trait HasTabs
{
    public ?array $tabs = [];

    /**
     * @param array $tabs
     * @return $this
     */
    public function tabs(array $tabs): static
    {
        $this->tabs = $tabs;
        return $this;
    }
}
