<?php

namespace Modules\Base\Services\Components\Base;

use Modules\Base\Services\Concerns\HasButton;
use Modules\Base\Services\Concerns\HasClassType;
use Modules\Base\Services\Concerns\HasIcon;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasRows;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Core\Abstracts\HasMake;


class Modal extends HasMake
{
    use HasLabel;
    use HasType;
    use HasIcon;
    use HasButton;
    use HasClassType;
    use HasRows;
}
