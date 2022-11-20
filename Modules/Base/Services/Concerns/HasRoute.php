<?php

namespace Modules\Base\Services\Concerns;

trait HasRoute
{
    public ?string $route = null;

    /**
     * @param $route
     * @return $this|null
     */
    public function route($route): ?static
    {
        $this->route = $route;
        return $this;
    }
}
