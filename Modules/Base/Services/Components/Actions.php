<?php

namespace Modules\Base\Services\Components;


use Modules\Base\Services\Components\Abstracts\ComponentAbstract;
use Modules\Base\Services\Components\Base\Action;
use Modules\Base\Services\Concerns\HasAction;
use Modules\Base\Services\Concerns\HasIcon;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasModal;
use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Concerns\HasUrl;
use Modules\Base\Services\Concerns\IsCan;

class Actions extends ComponentAbstract
{
    use HasName;
    use HasLabel;
    use HasType;
    use HasIcon;
    use HasAction;
    use HasModal;
    use HasUrl;
    use IsCan;

    public function get(): mixed
    {
        return Action::make($this->name)
            ->label($this->label)
            ->type($this->type)
            ->icon($this->icon)
            ->action($this->action)
            ->modal($this->modal)
            ->url($this->url)
            ->can($this->can);
    }
}
