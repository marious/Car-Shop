<?php

namespace Modules\Init\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Init\Supports\Filter;

class FilterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Filter::class;
    }
}