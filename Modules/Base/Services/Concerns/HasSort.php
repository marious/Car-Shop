<?php

namespace Modules\Base\Services\Concerns;

trait HasSort
{
    public ?int $sort = 0;

    /**
     * @param int $sort
     * @return $this|null
     */
    public function sort(int $sort): ?static
    {
        $this->sort = $sort;
        return $this;
    }
}
