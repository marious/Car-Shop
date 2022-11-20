<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Helpers\Traits\Configure;
use Modules\Base\Services\Concerns\HasController;
use Modules\Base\Services\Concerns\HasMedia;
use Modules\Base\Services\Concerns\HasMethod;
use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Concerns\HasPath;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Core\Abstracts\HasMake;


class AddRoute extends HasMake
{
    use HasType;
    use HasMethod;
    use HasPath;
    use HasController;
}
