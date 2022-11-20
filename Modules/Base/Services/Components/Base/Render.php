<?php

namespace Modules\Base\Services\Components\Base;

use Inertia\Inertia;
use Modules\Base\Services\Concerns\HasData;
use Modules\Base\Services\Concerns\HasModule;
use Modules\Base\Services\Core\Abstracts\HasMake;

class Render extends HasMake
{
    use HasModule;
    use HasData;

    public function render(): \Inertia\Response
    {
        return Inertia::render('@' . $this->module . '::' . $this->name, $this->data ?: []);
    }
}
