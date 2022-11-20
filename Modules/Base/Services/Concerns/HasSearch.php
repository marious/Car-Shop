<?php

namespace Modules\Base\Services\Concerns;

trait HasSearch
{
    public ?bool $search = true;

    /**
     * @param bool $search
     * @return $this|null
     */
    public function search(bool $search = true): ?static
    {
        $this->search = $search;
        return $this;
    }
}
