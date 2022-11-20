<?php

namespace Modules\Base\Services\Concerns;

trait HasBulks
{
    public ?array $bulks = null;

    /**
     * @param array $bulks
     * @return $this|null
     */
    public function bulks(array $bulks): ?static
    {
        $this->bulks = $bulks;
        return $this;
    }
}
