<?php

namespace Modules\Base\Services\Resource\Concerns\Render;

use Modules\Base\Services\Components\Base\Table as TableComponent;

trait Table
{
    public ?string $tableType = "table";

    public function table(): TableComponent
    {
        return TableComponent::make($this->tableType);
    }
}
