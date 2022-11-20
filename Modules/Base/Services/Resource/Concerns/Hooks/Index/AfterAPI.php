<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Index;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait AfterAPI
{
    public function afterIndexAPI(LengthAwarePaginator $data,Request $request): void
    {
        //
    }
}
