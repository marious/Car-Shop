<?php

namespace Modules\Base\Services\Components;

use Modules\Base\Services\Components\Abstracts\ComponentAbstract;
use Modules\Base\Services\Components\Base\Widget;
use Modules\Base\Services\Concerns\HasButton;
use Modules\Base\Services\Concerns\HasIcon;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Concerns\HasRows;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Concerns\HasValue;

class Widgets extends ComponentAbstract
{
    use HasName;
    use HasLabel;
    use HasType;
    use HasIcon;
    use HasButton;
    use HasValue;

    public function get(): mixed
    {
        return Widget::make($this->name)
            ->label($this->label)
            ->type($this->type)
            ->icon($this->icon)
            ->buttons($this->buttons)
            ->value($this->value);
    }
}
