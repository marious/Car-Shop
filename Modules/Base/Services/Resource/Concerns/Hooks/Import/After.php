<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Import;

use Illuminate\Http\Request;

trait After
{
    public function afterImport(Request $request, $record): void
    {
        //
    }
}
