<?php

namespace Modules\Base\Services\Concerns;

trait IsPreview
{
    /**
     * @var ?bool
     */
    public ?bool $preview = false;

    /**
     * @return $this
     */
    public function preview(bool $preview = true): static
    {
        $this->preview = $preview;
        return $this;
    }
}
