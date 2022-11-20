<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Update;

use Illuminate\Http\Request;

trait AfterAPI
{
    public function afterUpdateAPI(Request $request, $record): void
    {
        //
    }
}
