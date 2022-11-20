<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Store;

use Illuminate\Http\Request;

trait Before
{
    public function beforeStore(Request $request): Request
    {
        return $request;
    }
}
