<?php

namespace Modules\Base\Services\Resource;


use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Exports\BaseExport;
use Modules\Base\Helpers\Resources\Controller;
use Modules\Base\Imports\BaseImport;
use Modules\Base\Services\Resource\Concerns\Pages;
use Modules\Base\Services\Resource\Concerns\Actions;
use Modules\Base\Services\Resource\Concerns\Handlers;
use Modules\Base\Services\Resource\Concerns\Filters;
use Modules\Base\Services\Resource\Concerns\Helpers;
use Modules\Base\Services\Resource\Concerns\Render;
use Modules\Base\Services\Resource\Concerns\Process;
use Modules\Base\Services\Resource\Concerns\Core;
use Modules\Base\Services\Resource\Concerns\Hooks;
use Modules\Base\Services\Resource\Interfaces\MustHasRows;
use Modules\Translations\Imports\TranslationsImport;

class Resource implements MustHasRows
{
    /*
     * Load Helpers
     */
    use Helpers\GenerateNameHelper;
    use Helpers\IsAPIHelper;

    /*
     * Load Handlers
     */
    use Handlers\Roles;
    use Handlers\Query;
    use Handlers\Translation;
    use Handlers\Filter;
    use Handlers\Response;

    /*
     * Load Renders
     */
    use Render\Row;
    use Render\Action;
    use Render\Modal;
    use Render\Table;
    use Render\Form;

    /*
     * Load Core
     */
    use Core\Menu;
    use Core\Route;

    /*
     * Load Filters
     */
    use Filters\Query;
    use Filters\Media;
    use Filters\Select;
    use Filters\Translation;
    use Filters\Relation;

    /*
     * Load Pages
     */
    use Pages\Index;
    use Pages\View;
    use Pages\Create;
    use Pages\Edit;
    use Pages\Import;

    /*
     * Load Actions
     */
    use Actions\Store;
    use Actions\Show;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\Bulk;
    use Actions\Import;
    use Actions\Export;

    /*
     * Load Process
     */
    use Process\Validation;
    use Process\Media;
    use Process\Select;
    use Process\Translation;

    /*
     * Load Hooks
     */
    use Hooks\Index\Before;
    use Hooks\Index\BeforeQuery;
    use Hooks\Index\BeforeQueryAPI;
    use Hooks\Index\AfterQuery;
    use Hooks\Index\AfterQueryAPI;
    use Hooks\Index\BeforeAPI;
    use Hooks\Index\After;
    use Hooks\Index\AfterAPI;
    use Hooks\Store\Before;
    use Hooks\Store\BeforeAPI;
    use Hooks\Store\After;
    use Hooks\Store\AfterAPI;
    use Hooks\Show\Before;
    use Hooks\Show\BeforeQuery;
    use Hooks\Show\BeforeQueryAPI;
    use Hooks\Show\AfterQuery;
    use Hooks\Show\AfterQueryAPI;
    use Hooks\Show\BeforeAPI;
    use Hooks\Show\After;
    use Hooks\Show\AfterAPI;
    use Hooks\Update\Before;
    use Hooks\Update\BeforeAPI;
    use Hooks\Update\After;
    use Hooks\Update\AfterAPI;
    use Hooks\Destroy\After;
    use Hooks\Destroy\Before;
    use Hooks\Bulk\Before;
    use Hooks\Bulk\After;
    use Hooks\Export\Before;
    use Hooks\Export\After;
    use Hooks\Import\Before;
    use Hooks\Import\After;

    public function __construct()
    {
        if(!empty($this->model)){
            $this->table = app($this->model)->getTable();
        }

        if (empty($this->view)) {
            $this->view = "Resource";
        }
    }
}
