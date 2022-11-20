<?php

namespace Modules\Base\Services\Concerns;

trait HasModule
{
    public ?string $module = null;

    /**
     * @param string $module
     * @return $this|null
     */
    public function module(string $module): ?static
    {
        $this->module = $module;
        return $this;
    }
}
