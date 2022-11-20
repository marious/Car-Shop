<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasActions;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasTabs;
use Modules\Base\Services\Core\Abstracts\HasMake;

class Form extends HasMake
{
    use HasActions;
    use HasTabs;
    use HasLabel;
}
