<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Export;

use Illuminate\Http\Request;

trait After
{
    public function afterExport(Request $request, $record): void
    {
        //
    }
}
