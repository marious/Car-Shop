<?php

namespace Modules\Base\Services\Resource\Concerns\Render;

use Modules\Base\Services\Components\Base\Form as FormComponent;

trait Form
{
    public ?string $formType = "modal";

    public function form(): FormComponent
    {
        return FormComponent::make($this->formType);
    }
}
