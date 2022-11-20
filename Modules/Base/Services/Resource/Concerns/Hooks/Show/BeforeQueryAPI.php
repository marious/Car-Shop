<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Show;

use Illuminate\Http\Request;

trait BeforeQueryAPI
{
    public function beforeShowQueryAPI($query, Request $request,array $rows): void
    {
        //
    }
}
