<?php

namespace Modules\Insurance\Entities;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Price extends Model
{
use HasTranslations;
use HasFactory;

    protected $fillable = [
            'name',
    
    ];

    public $translatable = ['name'];



protected $dates = [
                'created_at',
            'updated_at',
    ];

protected $appends = ["api_route", "can"];

/* ************************ ACCESSOR ************************* */

public function getApiRouteAttribute() {
return route("api.prices.index");
}
public function getCanAttribute() {
return [
"view" => \Auth::check() && \Auth::user()->can("view", $this),
"update" => \Auth::check() && \Auth::user()->can("update", $this),
"delete" => \Auth::check() && \Auth::user()->can("delete", $this),
"restore" => \Auth::check() && \Auth::user()->can("restore", $this),
"forceDelete" => \Auth::check() && \Auth::user()->can("forceDelete", $this),
];
}

protected function serializeDate(DateTimeInterface $date) {
return $date->format('Y-m-d H:i:s');
}

    /* ************************ RELATIONS ************************ */
        }
