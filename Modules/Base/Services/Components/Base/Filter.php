<?php

namespace Modules\Base\Services\Components\Base;


use Modules\Base\Services\Concerns\HasAction;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasModel;
use Modules\Base\Services\Concerns\HasRows;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Core\Abstracts\HasMake;

class Filter extends HasMake
{
    use HasLabel;
    use HasType;
    use HasModel;
    use HasRows;
    use HasAction;
}
