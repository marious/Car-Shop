<?php

namespace Modules\Base\Services\Resource\Concerns\Hooks\Show;

use Illuminate\Http\Request;

trait Before
{
    public function beforeShow(Request $request, $record)
    {
        return $record;
    }
}
