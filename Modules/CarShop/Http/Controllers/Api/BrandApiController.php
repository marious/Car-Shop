<?php

namespace Modules\CarShop\Http\Controllers\Api;

use Modules\CarShop\Entities\CarBrand;
use Modules\CarShop\Http\Controllers\ApiBaseController;

class BrandApiController extends ApiBaseController
{
    protected $model = CarBrand::class;
}
