<?php

namespace Modules\Base\Services\Concerns;

trait HasFilters
{
    public ?array $filters = null;

    /**
     * @param array $filters
     * @return $this|null
     */
    public function filters(array $filters): ?static
    {
        $this->filters = $filters;
        return $this;
    }
}
