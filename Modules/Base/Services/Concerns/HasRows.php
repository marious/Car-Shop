<?php

namespace Modules\Base\Services\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasRows
{

    /**
     * @var ?array
     * @example []
     */
    public ?array $rows = null;

    public function rows(array $rows): static
    {
        $this->rows = $rows;
        return $this;
    }
}
