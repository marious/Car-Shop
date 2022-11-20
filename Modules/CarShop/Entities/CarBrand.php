<?php

namespace Modules\CarShop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class CarBrand extends Model
{
    use HasFactory,
        HasTranslations;

    protected $fillable = ['name'];

    public $translatable = ['name'];

    protected static function newFactory()
    {
        return \Modules\CarShop\Database\factories\CarBrandFactory::new();
    }

    public static function getAppendFields()
    {
        return (new static)->appends;
    }
}
