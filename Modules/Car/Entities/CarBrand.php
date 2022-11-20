<?php

namespace Modules\Car\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;


/**
 * @property integer $id
 * @property mixed $name
 * @property string $created_at
 * @property string $updated_at
 * @property CarModel[] $carModels
 */
class CarBrand extends Model
{
    use HasTranslations, HasRoles;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public $translatable = ['name'];
    /**
     * @var array
     */
    protected $fillable = ['name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carModels()
    {
        return $this->hasMany('Modules\Car\Entities\CarModel');
    }

    public function getApiRouteAttribute()
    {
        return route("api.car-brands.index");
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

    public static function getAppendFields()
    {
        return (new static)->appends;
    }

}
