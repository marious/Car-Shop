<?php

namespace Modules\CarShop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class CarModel extends Model
{
    use HasFactory,
        HasTranslations;

    protected $fillable = ['name', 'car_brand_id'];

    public $translatable = ['name'];


    protected static function newFactory()
    {
        return \Modules\CarShop\Database\factories\CarModelFactory::new();
    }

    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id');
    }

    public static function getAppendFields()
    {
        return (new static)->appends;
    }

}
