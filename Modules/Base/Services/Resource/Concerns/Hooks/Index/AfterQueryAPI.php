<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;

trait AfterQueryAPI
{
    public function afterIndexQueryAPI($query, Request $request, array $rows): void
    {
        //
    }
}
