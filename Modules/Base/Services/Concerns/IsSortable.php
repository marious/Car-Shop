<?php

namespace Modules\Base\Services\Concerns;

trait IsSortable
{
    /**
     * @var ?bool
     */
    public ?bool $sortable = true;

    /**
     * @return $this
     */
    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;
        return $this;
    }
}
