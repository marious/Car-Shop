<?php

namespace Modules\CarShop\Entities;
/* Imports */

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class CarShop extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'location',
        'commission',

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
        return route("api.car-shops.index");
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


    public static function getAppendFields()
    {
        return (new static)->appends;
    }
}
