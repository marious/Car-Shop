<?php

namespace Modules\Base\Services\Concerns;

trait IsSearchable
{
    /**
     * @var ?bool
     */
    public ?bool $searchable = false;

    /**
     * @return $this
     */
    public function searchable(bool $searchable = true): static
    {
        $this->searchable = $searchable;
        return $this;
    }
}
