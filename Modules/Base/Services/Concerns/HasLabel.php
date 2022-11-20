<?php

namespace Modules\Base\Services\Concerns;

trait HasLabel {
    /**
     * @var ?string | array | null
     * @example __('Name')
     */
    public string | array | null $label = null;

    /**
     * @param string | array | null $label
     * @return $this
     */
    public function label(string | array | null $label): static
    {
        $this->label = $label;
        return $this;
    }
}
