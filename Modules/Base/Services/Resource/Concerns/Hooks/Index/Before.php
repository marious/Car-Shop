<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;

trait Before
{
    public function beforeIndex(Request $request): Request
    {
        return $request;
    }
}
