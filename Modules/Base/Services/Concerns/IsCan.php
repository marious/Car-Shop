<?php

namespace Modules\Base\Services\Concerns;

trait IsCan
{
    public bool | string | null $can = true;

    /**
     * @param bool | string | null $can
     * @return ?static
     */
    public function can(bool | string | null $can = true): ?static
    {
        $this->can = $can;
        return $this;
    }
}
