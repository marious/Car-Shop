<?php

namespace Modules\Car\Entities;
/* Imports */

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Base\Services\Concerns\HasRoles;
use Spatie\Translatable\HasTranslations;

class CarModel extends Model
{
    use HasFactory, HasRoles, HasTranslations;

    protected $fillable = [
        'name',
        'car_brand_id',
    ];

    public $translatable = ['name'];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ["api_route", "can"];

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute()
    {
        return route("api.car-models.index");
    }

    public function getCanAttribute()
    {
        return [
            "view" => \Auth::check() && \Auth::user()->can("viewAny", $this),
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
     * Many to One Relationship to \Modules\Car\Entities\CarBrand::class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carBrand()
    {
        return $this->belongsTo(\Modules\Car\Entities\CarBrand::class, "car_brand_id", "id");
    }
}
