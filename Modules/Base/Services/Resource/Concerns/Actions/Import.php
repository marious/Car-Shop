<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Imports\BaseImport;
use Modules\Base\Services\Components\Base\Alert;

trait Import
{
    public function import(Request $request)
    {
        $rules = [
            "excel" => "required|array",
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        if (!$validator->fails()) {
            $cols = $_COOKIE[$this->table . '-cols'];
            if ($cols) {
                $cols = json_decode($cols);
                Excel::import(new BaseImport($this->rows(), $this->model, $cols), $request->file('excel')[0]);

                return Alert::make(__('Import Success'))->fire();
            } else {
                return Alert::make(__('Something is error!'))->type('danger')->fire();
            }

        }
    }
}
