<?php

namespace Modules\CarShop\Http\Controllers\Admin;

use Modules\CarShop\Entities\Quotation;
use Modules\CarShop\Http\Controllers\ApiBaseController;

class ApprovedQuotationApiController extends ApiBaseController
{
    protected $model = Quotation::class;

    public function modifyIndex($query)
    {
        $isAdmin = auth()->user()->is_admin;
        $query = $query->where('is_approved', true)
            ->when(!$isAdmin, function ($query) {
                $query->where('car_shop_id', auth()->user()->car_shop_id);
            });
        return $query;
    }

}
