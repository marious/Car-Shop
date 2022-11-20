<?php

namespace Modules\Base\Services\Components\Base;

use Illuminate\Support\Facades\Route;
use Modules\Base\Services\Concerns\HasController;
use Modules\Base\Services\Core\Abstracts\HasMake;

class Router extends HasMake
{
    use HasController;
    private ?string $table = null;
    private ?array $middleware = ["web"];
    private ?array $custom = null;
    private ?bool $api = false;
    private ?bool $settings = false;
    private ?bool $page = false;


    public function get()
    {
        return [
            "table" => $this->name,
            "controller" => $this->controller,
            "middleware" => $this->middleware,
            "custom" => $this->custom,
            "api" => $this->api,
            "page" => $this->page,
            "settings" => $this->settings
        ];
    }


    public function page($page): ?static
    {
        $this->page = $page;
        return $this;
    }

    public function api($api): ?static
    {
        $this->api = $api;
        return $this;
    }

    public function middleware($middleware): ?static
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function custom($custom): ?static
    {
        $this->custom = $custom;
        return $this;
    }

    public function settings($settings): ?static
    {
        $this->settings = $settings;
        return $this;
    }
}
