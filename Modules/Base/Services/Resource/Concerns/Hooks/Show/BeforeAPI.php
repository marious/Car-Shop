<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Show;

use Illuminate\Http\Request;

trait BeforeAPI
{
    public function beforeShowAPI(Request $request, $record)
    {
        return $record;
    }
}
