<?php

namespace Modules\Base\Services\Concerns;

trait HasValidation
{
    /**
     * @var array | string | null
     * @example ["required", "email", "max:200"]
     */
    public array | string | null $validation = null;

    /**
     * @param array | string | null $validation
     * @return $this
     */
    public function validation(array | string | null $validation): static
    {
        $this->validation = $validation;
        return $this;
    }
}
