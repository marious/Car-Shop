<?php

namespace Modules\CarShop\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Modules\CarShop\Entities\Quotation;

class ValidPolicyNum implements DataAwareRule, InvokableRule
{

    protected $data = [];

    public function setData($data)
    {
        $this->data = $data;
    }

    public function __invoke($attribute, $value, $fail)
    {
        $isExistBefore = Quotation::where([
            'policy_num' => $this->data['policyNum'],
            'policy_year' => Carbon::parse($this->data['year'])->setTimezone('Africa/Cairo')->format('Y'),
            'company_id' => $this->data['companyId'],
        ])->count();


        if ($isExistBefore) {
            $fail('Policy Number Is invalid.');
        }
    }
}
