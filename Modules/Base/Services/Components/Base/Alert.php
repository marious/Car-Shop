<?php
namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Core\Abstracts\HasMake;


class Alert extends HasMake
{
    use HasType;

    /**
     * @return \Illuminate\Http\RedirectResponse
     * Return a fire message to the session for flash message alert
     */
    public function fire(): \Illuminate\Http\RedirectResponse
    {
        session([
            "message" => [
                "message" => $this->name,
                "type" => $this->type
            ]
        ]);
        return back();
    }
}
