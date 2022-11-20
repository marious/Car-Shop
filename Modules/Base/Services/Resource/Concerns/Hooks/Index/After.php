<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait After
{
    public function afterIndex(LengthAwarePaginator $data,Request $request): void
    {
        //
    }
}
