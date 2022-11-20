<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Destroy;

use Illuminate\Http\Request;

trait Before
{
    public function beforeDestroy(Request $request, $record): Request
    {
        return $request;
    }
}
