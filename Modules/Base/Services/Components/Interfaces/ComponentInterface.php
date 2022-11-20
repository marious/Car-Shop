<?php

namespace Modules\Base\Services\Components\Interfaces;

interface ComponentInterface
{
    public function setup(): void;
    public function get(): mixed;
}
