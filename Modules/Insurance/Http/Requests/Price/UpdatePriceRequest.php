<?php

namespace Modules\Insurance\Http\Requests\Price;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePriceRequest extends FormRequest
{
/**
* Determine if the user is authorized to make this request.
*
* @return bool
*/
public function authorize(): bool
{
return $this->user()->can('update', $this->price);
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
public function sanitizedObject(): object {
$sanitized = $this->sanitizedArray();
return json_decode(collect($sanitized));
}
}
