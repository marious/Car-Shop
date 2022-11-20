<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasActions;
use Modules\Base\Services\Concerns\HasBulk;
use Modules\Base\Services\Concerns\HasBulks;
use Modules\Base\Services\Concerns\HasFilters;
use Modules\Base\Services\Concerns\HasSearch;
use Modules\Base\Services\Core\Abstracts\HasMake;

class Table extends HasMake
{
    use HasFilters;
    use HasActions;
    use HasBulks;
    use HasBulk;
    use HasSearch;
}
