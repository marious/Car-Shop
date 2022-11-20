<?php

namespace Modules\Base\Services\Resource\Concerns\Process;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait Validation
{
    public function loadValidation(Request $request, int $id = null): array
    {
        $create = [];
        $edit = [];
        foreach ($this->rows() as $item) {

            if ($item->validation) {

                $create[$item->name] = $item->validation;
                $edit[$item->name] = $item->validation;

                if (isset($item->validation['create'], $item->validation['update']) && is_array($item->validation)) {
                    $create[$item->name] = $item->validation['create'];
                    $edit[$item->name] = $item->validation['update'];
                }

                if ($item->unique) {
                    $create[$item->name] .= "|unique:" . $this->table . "," . $item->name;
                    if ($id) {
                        $edit[$item->name] .= "|unique:" . $this->table . "," . $item->name . "," . $id;
                    }
                }
            }
        }
        if ($id) {
            return $edit;
        }

        return $create;
    }

    public function validStore(Request $request): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
    {
        $rules = $this->loadValidation($request);
        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        return $validator;
    }

    public function validUpdate(Request $request, $id): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
    {
        $rules = $this->loadValidation($request, $id);
        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        return $validator;
    }
}
