<?php

namespace Modules\Base\Services\Concerns;

trait HasButton
{
    public ?array $buttons = null;

    /**
     * @param array | null $buttons
     * @return $this|null
     */
    public function buttons(array | null $buttons): ?static
    {
        $this->buttons = $buttons;
        return $this;
    }
}
