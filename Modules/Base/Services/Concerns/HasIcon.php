<?php

namespace Modules\Base\Services\Concerns;

trait HasIcon
{
    public ?string $icon = "bx bx-circle";

    /**
     * @param string $icon
     * @return static
     */
    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }
}
