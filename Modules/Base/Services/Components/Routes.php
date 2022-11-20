<?php

namespace Modules\Base\Services\Components;

use Modules\Base\Services\Components\Abstracts\ComponentAbstract;
use Modules\Base\Services\Components\Base\AddRoute;
use Modules\Base\Services\Concerns\HasController;
use Modules\Base\Services\Concerns\HasMethod;
use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Concerns\HasPath;
use Modules\Base\Services\Concerns\HasType;

class Routes extends ComponentAbstract
{
    use HasName;
    use HasType;
    use HasPath;
    use HasMethod;
    use HasController;

    public function get(): mixed
    {
        return AddRoute::make($this->name)
            ->controller($this->controller)
            ->type($this->type)
            ->path($this->path)
            ->method($this->method);
    }
}
