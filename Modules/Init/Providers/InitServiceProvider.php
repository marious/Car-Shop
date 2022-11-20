<?php

namespace Modules\Init\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Services\Core\Helpers\Lang;
use Modules\Init\Service\Generators\Commands\ViltFileBaseGenerator;
use Modules\Init\Service\Generators\Controller;
use Modules\Init\Service\Generators\DestroyRequest;
use Modules\Init\Service\Generators\IndexRequest;
use Modules\Init\Service\Generators\Lang as LangFileBase;
use Modules\Init\Service\Generators\Model;
use Modules\Init\Service\Generators\Permissions;
use Modules\Init\Service\Generators\Policy;
use Modules\Init\Service\Generators\Repository;
use Modules\Init\Service\Generators\Resource;
use Modules\Init\Service\Generators\StoreRequest;
use Modules\Init\Service\Generators\UpdateRequest;
use Modules\Init\Service\Generators\ViewForm;
use Modules\Init\Service\Generators\ViewIndex;
use Modules\Init\Traits\LoadAndPublishDataTrait;

class InitServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Init';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'init';


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
//        VILT::loadResources($this->moduleName);
//        VILT::registerTranslation(Lang::make('init.sidebar')->label(__('Init')));

        $this->commands([
            ViltFileBaseGenerator::class,
            Model::class,
            Permissions::class,
            Policy::class,
            Repository::class,
            StoreRequest::class,
            UpdateRequest::class,
            IndexRequest::class,
            DestroyRequest::class,
            ViewForm::class,
            ViewIndex::class,
            Controller::class,
            Resource::class,
            LangFileBase::class,
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setNameSpace('Init')
            ->loadHelpers();
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton('vilt-filebase-generator', function () {
            return new ViltFileBaseGenerator;
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
