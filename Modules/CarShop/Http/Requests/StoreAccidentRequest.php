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
            'accident_date' => 'required|before:tomorrow',
            'description' => 'required',
            'admin_note' => 'nullable',
            'compensation' => 'nullable|numeric',
            'payment_way' => 'nullable',
            'attachments.*' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'account_num' => 'required_if:payment_way,bank',
            'check_num' => 'required_if:payment_way,check',
        ];
    }

    public function messages()
    {
        return [
            'accident_date.before' => __('Date Must Not Exceed Today Date'),
        ];
    }
}
