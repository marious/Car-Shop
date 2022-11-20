<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasGroup;
use Modules\Base\Services\Concerns\HasIcon;
use Modules\Base\Services\Concerns\HasKey;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasRoute;
use Modules\Base\Services\Concerns\HasSort;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Concerns\HasUrl;
use Modules\Base\Services\Concerns\IsCan;
use Modules\Base\Services\Core\Abstracts\HasMake;


class Menu extends HasMake
{
    use HasLabel;
    use HasIcon;
    use HasRoute;
    use HasUrl;
    use HasGroup;
    use HasType;
    use HasSort;
    use HasKey;
    use IsCan;
}
