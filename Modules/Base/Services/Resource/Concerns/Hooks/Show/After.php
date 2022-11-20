<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Show;

use Illuminate\Http\Request;

trait After
{
    public function afterShow(Request $request, $record): void
    {
        //
    }
}
