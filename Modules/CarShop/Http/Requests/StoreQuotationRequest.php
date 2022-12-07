<?php

namespace Modules\CarShop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CarShop\Rules\ValidAgeRule;

class StoreQuotationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'year' => 'required|min:4',
            'price' => 'required|numeric',
            'brand_id' => 'required',
            'model_id' => 'required',
            'company_id' => 'required',
            'customer_name' => 'required|min:5',
            'birth_date' => ['required', new ValidAgeRule()],
            'car_num' => 'required',
            'chasses_num' => 'required',
            'motor_num' => 'required',
            'attachments.*' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ];
    }
}
