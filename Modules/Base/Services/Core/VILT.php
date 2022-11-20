<?php

namespace Modules\Base\Services\Core;

use Modules\Base\Services\Core\Concerns\Getters;
use Modules\Base\Services\Core\Concerns\Load;
use Modules\Base\Services\Core\Concerns\Register;

class VILT
{
    /*
     * Register Data
     */
    use Register\Menu;
    use Register\Translation;
    use Register\Share;
    use Register\Resource;
    use Register\Page;

    /*
     * Load Data
     */
    use Load\Menu;
    use Load\Translation;
    use Load\Share;
    use Load\Routes;
    use Load\Resource;
    use Load\Page;

    /*
     * Getters Traits
     */
    use Getters\Core;
    use Getters\Pages;
    use Getters\Resources;
}
