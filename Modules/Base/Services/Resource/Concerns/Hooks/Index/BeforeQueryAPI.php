<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;

trait BeforeQueryAPI
{
    public function beforeIndexQueryAPI($query, Request $request,array $rows): void
    {
        //
    }
}
