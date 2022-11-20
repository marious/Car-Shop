<?php

namespace Modules\Base\Services\Concerns;

trait HasBulk
{
    public ?bool $bulk = true;

    /**
     * @param bool $bulk
     * @return $this|null
     */
    public function bulk(bool $bulk = true): ?static
    {
        $this->bulk = $bulk;
        return $this;
    }
}
