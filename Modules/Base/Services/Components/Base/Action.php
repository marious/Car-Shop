<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasAction;
use Modules\Base\Services\Concerns\HasClassType;
use Modules\Base\Services\Concerns\HasIcon;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasModal;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Concerns\HasUrl;
use Modules\Base\Services\Concerns\IsCan;
use Modules\Base\Services\Core\Abstracts\HasMake;


class Action extends HasMake
{
    use HasLabel;
    use HasType;
    use HasIcon;
    use HasAction;
    use HasModal;
    use HasUrl;
    use HasClassType;
    use IsCan;
}
