<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Import;

use Illuminate\Http\Request;

trait Before
{
    public function beforeImport(Request $request, $record): Request
    {
        return $request;
    }
}
