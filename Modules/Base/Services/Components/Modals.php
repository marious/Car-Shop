<?php

namespace Modules\Base\Services\Components;


use Modules\Base\Services\Components\Abstracts\ComponentAbstract;
use Modules\Base\Services\Components\Base\Modal;
use Modules\Base\Services\Concerns\HasButton;
use Modules\Base\Services\Concerns\HasIcon;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Concerns\HasRows;
use Modules\Base\Services\Concerns\HasType;

class Modals extends ComponentAbstract {

    use HasName;
    use HasLabel;
    use HasType;
    use HasIcon;
    use HasButton;
    use HasRows;

    public function get(): mixed
    {
        return Modal::make($this->name)
            ->label($this->label)
            ->type($this->type)
            ->icon($this->icon)
            ->buttons($this->buttons)
            ->rows($this->rows);
    }
}
