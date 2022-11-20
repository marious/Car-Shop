<?php

namespace Modules\Base\Services\Concerns;

trait HasGroup
{
    public ?string $group = "main";

    /**
     * @param $group
     * @return $this|null
     */
    public function group($group): ?static
    {
        $this->group = $group;
        return $this;
    }
}
