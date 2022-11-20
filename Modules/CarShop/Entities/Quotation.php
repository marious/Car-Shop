<?php
namespace Modules\CarShop\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Insurance\Entities\Company;
use Modules\Insurance\Entities\Fee;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Examyou\RestAPI\ApiModel;


class Quotation extends ApiModel implements HasMedia
{
    protected $table = 'quotation_requests';

    use InteractsWithMedia;


    protected $fillable = [
        'year', 'brand_id', 'model_id', 'price', 'company_id',
        'customer_name', 'birth_date', 'car_num', 'chasses_num',
        'motor_num', 'policy_term', 'policy_num', 'policy_year',
        'user_id', 'is_approved', 'rate', 'premium', 'total_premium', 'commission',
        'sum_insured', 'approved_at', 'is_accident', 'car_shop_id',
    ];

    protected $hidden = ['pivot', 'updated_at'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'quotation_fees')->withPivot(['amount']);
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }
}
