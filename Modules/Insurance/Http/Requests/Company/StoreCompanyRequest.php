<?php

namespace Modules\Insurance\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Insurance\Entities\Company;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Company::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name.*' => ['required', 'string'],
            'terms_conditions' => ['required', 'string'],
            'bear_expenses' => 'nullable|string',

        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => __('Name Is Required'),
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();

//Add your code for manipulation with request data here

        return $sanitized;
    }

    /**
     * Return modified (sanitized data) as a php object
     * @return object
     */
    public function sanitizedObject(): object
    {
        $sanitized = $this->sanitizedArray();
        return json_decode(collect($sanitized));
    }
}
