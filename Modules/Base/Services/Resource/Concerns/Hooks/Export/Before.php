<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Export;

use Illuminate\Http\Request;

trait Before
{
    public function beforeExport(Request $request, $record): Request
    {
        return $request;
    }
}
