<?php
namespace Modules\CarShop\Http\Controllers\Api;

use Modules\CarShop\Http\Controllers\ApiBaseController;
use Modules\Insurance\Entities\Company;

class CompanyApiController extends ApiBaseController
{
    protected $model = Company::class;
}
