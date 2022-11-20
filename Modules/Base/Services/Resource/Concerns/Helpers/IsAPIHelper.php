<?php

namespace Modules\Base\Services\Resource\Concerns\Helpers;

use Illuminate\Http\Request;

trait IsAPIHelper
{
    /**
     * @var bool|null
     */
    public ?bool $api = false;

    /**
     * @param Request $request
     * @return bool
     */
    public function isAPI(Request $request): bool
    {
        $api = str_contains($request->route()->getPrefix(), 'api');
        return $api && $this->api;
    }
}
