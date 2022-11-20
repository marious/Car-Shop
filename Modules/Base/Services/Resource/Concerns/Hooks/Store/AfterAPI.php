<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Store;

use Illuminate\Http\Request;

trait AfterAPI
{
    public function afterStoreAPI(Request $request, $record): void
    {
        //
    }
}
