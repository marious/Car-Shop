<?php

namespace Modules\CarShop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CarShop\Rules\ValidPolicyNum;

class QuotationLicenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'policyNum' => ['required', new ValidPolicyNum],
            'year' => 'required',
            'companyId' => 'numeric',
        ];
    }
}
