<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;

trait BeforeAPI
{
    public function beforeIndexAPI(Request $request): Request
    {
        return $request;
    }
}
