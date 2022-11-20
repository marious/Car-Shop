<?php

namespace Modules\Base\Services\Concerns;

trait HasModel
{
    /**
     * @var ?string
     * @example User::class
     */
    public ?string $model = null;

    public function model(string $model): static
    {
        $this->model = $model;
        return $this;
    }
}
