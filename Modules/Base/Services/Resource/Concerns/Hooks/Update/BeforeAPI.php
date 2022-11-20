<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Update;

use Illuminate\Http\Request;

trait BeforeAPI
{
    public function beforeUpdateAPI(Request $request, $record): Request
    {
        return $request;
    }
}
