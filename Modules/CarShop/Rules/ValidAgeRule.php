<?php

namespace Modules\CarShop\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;

class ValidAgeRule implements Rule
{
    protected $defaultAge;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param = 18)
    {
        $this->defaultAge = $param;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new DateTime)->diff(new DateTime($value))->y >= $this->defaultAge;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Date.';
    }
}
