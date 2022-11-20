<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Show;

use Illuminate\Http\Request;

trait AfterAPI
{
    public function afterShowAPI(Request $request, $record): void
    {
        //
    }
}
