<?php

namespace Modules\Base\Services\Concerns;

trait HasData
{
    public ?array $data = null;

    /**
     * @param array | null $data
     * @return $this|null
     */
    public function data(array | null $data): ?static
    {
        $this->data = $data;
        return $this;
    }
}
