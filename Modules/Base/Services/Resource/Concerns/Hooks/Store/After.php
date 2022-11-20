<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Store;

use Illuminate\Http\Request;

trait After
{
    public function afterStore(Request $request, $record): void
    {
        //
    }
}
