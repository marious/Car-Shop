<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Bulk;

use Illuminate\Http\Request;

trait Before
{
    public function beforeBulk(Request $request): Request
    {
        return $request;
    }
}
