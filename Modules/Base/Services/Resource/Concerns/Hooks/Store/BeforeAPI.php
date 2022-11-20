<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Store;

use Illuminate\Http\Request;

trait BeforeAPI
{
    public function beforeStoreAPI(Request $request): Request
    {
        return $request;
    }
}
