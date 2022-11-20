<?php

namespace Modules\Base\Services\Resource\Concerns\Render;

trait Row
{
    public ?array $rows = [];

    public function rows(): array
    {
        return $this->rows;
    }
}
