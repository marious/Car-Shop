<?php

namespace Modules\Insurance\Entities;
/* Imports */

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Modules\Car\Entities\CarModel;
use Spatie\Translatable\HasTranslations;

class CompanyCarModel extends Model
{
    use HasFactory;

    protected $table = 'company_car_model';

    protected $fillable = [
        'company_id',
        'car_model',
        'category',

    ];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ["api_route", "can"];

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute()
    {
//        return route("api.company-car-models.index");
    }

    public function getCanAttribute()
    {
        return [
            "view" => \Auth::check() && \Auth::user()->can("view", $this),
            "update" => \Auth::check() && \Auth::user()->can("update", $this),
            "delete" => \Auth::check() && \Auth::user()->can("delete", $this),
            "restore" => \Auth::check() && \Auth::user()->can("restore", $this),
            "forceDelete" => \Auth::check() && \Auth::user()->can("forceDelete", $this),
        ];
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /* ************************ RELATIONS ************************ */
    /**
     * Many to One Relationship to \Modules\Insurance\Entities\CarModel::class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class, "car_model", "id");
    }

    /**
     * Many to One Relationship to \Modules\Insurance\Entities\Company::class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(\Modules\Insurance\Entities\Company::class, "company_id", "id");
    }
}
