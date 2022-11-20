<?php

namespace Modules\Base\Services\Resource\Concerns\Process;

use Illuminate\Http\Request;

trait Select
{
    public function processSelect(Request $request): Request
    {
        foreach ($this->rows() as $field) {
            if (($field->vue === 'ViltSelect.vue' || $field->vue === 'ViltHasOne.vue') && (!$field->multi) && $request[$field->name]) {
                $request[$field->name] = $request[$field->name][$field->trackById];
            }
        }

        return $request;
    }
}
