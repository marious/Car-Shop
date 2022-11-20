<?php

namespace Modules\Base\Services\Concerns;

trait HasModal
{
    public ?string $modal = null;

    /**
     * @param string | null $modal
     * @return static
     */
    public function modal(?string $modal): static {
        $this->modal = $modal;
        return $this;
    }
}
