<?php

namespace Modules\Base\Services\Resource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Base\Services\Resource\Interfaces\MustHasRows;
use Modules\Settings\Settings\SitesSettings;
use Spatie\LaravelSettings\Settings;
use Modules\Base\Services\Resource\Concerns\Helpers;
use Modules\Base\Services\Resource\Concerns\Render;
use Modules\Base\Services\Resource\Concerns\Core;
use Modules\Base\Services\Resource\Concerns\Handlers;
use Modules\Base\Services\Resource\Concerns\Process;

class Page implements MustHasRows
{
    use Helpers\GenerateNameHelper;
    use Helpers\IsAPIHelper;

    /*
     * Load Renders
     */
    use Render\Row;
    use Render\Action;
    use Render\Modal;
    use Render\Table;
    use Render\Form;

    /*
     * Load Handlers
     */
    use Handlers\Roles;
    use Handlers\Translation;

    /*
     * Load Core
     */
    use Core\Menu;
    use Core\Route;

    public  function __construct()
    {
        $this->table = $this->path;
    }
}
