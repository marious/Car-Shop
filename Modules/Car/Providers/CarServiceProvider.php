<?php

namespace Modules\Car\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Services\Components\Base\Menu;
use Modules\Base\Services\Components\Base\Lang;
use Modules\Base\Services\Core\VILT;
use Modules\Car\Entities\CarBrand;

class CarServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Car';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'car';

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
     //   VILT::loadResources($this->moduleName);
      //  VILT::loadPages($this->moduleName);
//        VILT::registerTranslation(Lang::make('car.sidebar')->label(__('Car')));
//        VILT::registerTranslation(Lang::make('car_brands.sidebar')->label(__('Car Brands')));
//        VILT::registerTranslation(Lang::make('car_models.sidebar')->label(__('Car Models')));
//        VILT::registerTranslation(Lang::make('prices.sidebar')->label(__('Prices')));
//        VILT::registerTranslation(Lang::make('fees.sidebar')->label(__('Fees')));
//        VILT::registerTranslation(Lang::make('companies.sidebar')->label(__('Companies')));
//        VILT::registerTranslation(Lang::make('company_price.sidebar')->label(__('Company Price')));
//        VILT::registerTranslation(Lang::make('company_fee.sidebar')->label(__('Company Fee')));
//        VILT::registerTranslation(Lang::make('company_car_model.sidebar')->label(__('Car Model')));
//        VILT::registerTranslation(Lang::make('car_shops.sidebar')->label(__('Car Shops')));
//        VILT::registerTranslation(Lang::make('order.sidebar')->label(__('Order')));


//        VILT::registerMenu(Menu::make('Dashboard')
//            ->can('view_car_brands')
//            ->icon('bx bxs-circle')
//            ->label('Dashboard')
//            ->icon('bx bx-tachometer')
//            ->route('dashboard')->sort(1));
//
//        VILT::registerMenu(Menu::make('car_brand')
//            ->can('view_car_brands')
//            ->icon('bx bx-car')
//            ->label(__('Car Brand'))
//            ->group('Car Management')
//            ->route('car-brands.index')->sort(1));
//
//        VILT::registerMenu(Menu::make('car_model')
//            ->can('view_car_models')
//            ->icon('bx bx-car')
//            ->label('Car Model')
//            ->group('Car Management')
//            ->route('car-models.index')->sort(2));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
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
