<?php

namespace Modules\Base\Services\Concerns;

trait HasReactiveBy
{
    /**
     * @var ?string
     * @example 'name'
     */
    public ?string $reactiveBy = null;

    /**
     * @param string $reactiveBy
     * @return $this
     */
    public function reactiveBy(string $reactiveBy): static
    {
        $this->reactiveBy = $reactiveBy;
        return $this;
    }
}
