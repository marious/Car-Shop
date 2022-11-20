<?php

namespace Modules\Base\Services\Concerns;

trait HasKey
{
    public ?string $key = "dashboard";

    public function key(string $key): self
    {
        $this->key = $key;
        return $this;
    }
}
