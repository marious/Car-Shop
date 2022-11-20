<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasColor;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasRoles;
use Modules\Base\Services\Concerns\HasValidation;
use Modules\Base\Services\Core\Abstracts\HasMake;

class Tab extends HasMake
{
    use HasLabel;
    use HasColor;
    use HasRoles;
    use HasValidation;
}
