<?php

namespace Modules\Insurance\Entities;
/* Imports */

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class CompanyPrice extends Model
{
    use HasTranslations;
    use HasFactory;

    protected $table = 'company_price';

    protected $fillable = [
        'param_from',
        'param_to',
        'rate',
        'company_id',
        'price_id',

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
        return route("api.company-prices.index");
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
     * Many to One Relationship to \Modules\Insurance\Entities\Company::class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(\Modules\Insurance\Entities\Company::class, "company_id", "id");
    }

    /**
     * Many to One Relationship to \Modules\Insurance\Entities\Price::class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function price()
    {
        return $this->belongsTo(\Modules\Insurance\Entities\Price::class, "price_id", "id");
    }
}
