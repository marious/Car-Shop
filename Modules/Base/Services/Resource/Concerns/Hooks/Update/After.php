<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Update;

use Illuminate\Http\Request;

trait After
{
    public function afterUpdate(Request $request, $record): void
    {
        //
    }
}
