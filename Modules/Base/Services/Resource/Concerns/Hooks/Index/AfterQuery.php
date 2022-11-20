<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;

trait AfterQuery
{
    public function afterIndexQuery($query, Request $request, array $rows): void
    {
        //
    }
}
