<?php


namespace Modules\Insurance\Pages;

use Modules\Base\Services\Components\Base\Render;
use Modules\Base\Services\Resource\Page;

class CustomCompanyCarModelPage extends Page
{
    public ?string $path = "customcompanycarmodel";
    public ?string $group = "Content";
    public ?string $icon = "bx bxs-circle";

    public function index(){
        return Render::make('CustomCompanyCarModel')->module('Insurance')->data([])->render();
    }
}
