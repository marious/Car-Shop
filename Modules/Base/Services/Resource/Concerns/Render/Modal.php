<?php

namespace Modules\Base\Services\Resource\Concerns\Render;

use Modules\Base\Services\Components\Base\Action;
use Modules\Base\Services\Components\Base\Modal as ModalComponent;
use Modules\Base\Services\Rows\Media;

trait Modal
{
    public function modals(): array
    {
        return [];
    }
}
