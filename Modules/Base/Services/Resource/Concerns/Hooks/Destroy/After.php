<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Destroy;

use Illuminate\Http\Request;

trait After
{
    public function afterDestroy(Request $request, $id): void
    {
        //
    }
}
