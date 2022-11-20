<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Show;

use Illuminate\Http\Request;

trait AfterQueryAPI
{
    public function afterShowQueryAPI($record, Request $request, array $rows): void
    {
        //
    }
}
