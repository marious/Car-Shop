<?php

namespace Modules\CarShop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccidentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'accident_date' => 'required',
            'description' => 'required',
            'admin_note' => 'nullable',
            'compensation' => 'nullable|numeric',
            'payment_way' => 'nullable',
            'attachments.*' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ];
    }
}
