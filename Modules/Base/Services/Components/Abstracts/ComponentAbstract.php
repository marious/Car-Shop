<?php

namespace Modules\Base\Services\Components\Abstracts;

use Modules\Base\Services\Components\Interfaces\ComponentInterface;

abstract class ComponentAbstract implements ComponentInterface
{
    public function __construct()
    {
        $this->setup();
    }

    public function get(): mixed
    {
        return [];
    }

    public function setup(): void {}
}
