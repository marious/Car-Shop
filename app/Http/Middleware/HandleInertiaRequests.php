<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Modules\Base\Services\Components\Base\Menu;
use Modules\Base\Services\Core\VILT;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {

        VILT::registerMenu(Menu::make('Dashboard')
            ->can('view_car_brands')
            ->icon('bx bxs-circle')
            ->label(__('Dashboard'))
            ->icon('bx bx-tachometer')
            ->route('dashboard')->sort(1));


        VILT::registerMenu(Menu::make('car_brand')
            ->can('view_car_brands')
            ->icon('bx bx-car')
            ->label(__('Car Brand'))
            ->group(__('Car Management'))
            ->route('car-brands.index')
            ->sort(3));

        VILT::registerMenu(Menu::make('car_model')
            ->can('view_car_models')
            ->icon('bx bx-car')
            ->label(__('Car Model'))
            ->group(__('Car Management'))
            ->route('car-models.index')->sort(2));


        VILT::registerMenu(Menu::make('car_shops')
            ->can('view_car_shops')
            ->icon('bx bxs-circle')
            ->label(__('Car Shops'))
            ->group(__('Car Management'))
            ->route('car-shops.index')->sort(3));


        VILT::registerMenu(Menu::make('companies')
            ->can('view_companies')
            ->icon('bx bxs-shopping-bag')
            ->label(__('Companies'))
            ->group(__('Car Management'))
            ->route('companies.index')->sort(4));

        VILT::registerMenu(Menu::make('translations')
            ->can('view_car_shops')
            ->icon('bx bxs-quote-alt-left')
            ->label(__(__('Translations')))
            ->group(__('Settings'))
            ->route('translation.index')->sort(22));



        VILT::registerMenu(Menu::make('company_fee')
            ->can('view_company_fee')
            ->icon('bx bx-money')
            ->label(__('Company Fee'))
            ->group(__('Car Management'))
            ->route('company-fees.index')->sort(7));

        VILT::registerMenu(Menu::make('company_car_model')
            ->can('view_company_car_model')
            ->icon('bx bx-car')
            ->label(__('Company Car Models'))
            ->group(__('Car Management'))
            ->route('company-car-models.index')->sort(6));

        VILT::registerMenu(Menu::make('company_price')
            ->can('view_company_price')
            ->icon('bx bx-money')
            ->label(__('Company Price'))
            ->group(__('Car Management'))
            ->route('company-prices.index')->sort(8));


        VILT::registerMenu(Menu::make('order')
            ->can('view_order')
            ->icon('bx bx-money')
            ->label(__('Order'))
            ->group(__('Order'))
            ->route('order.index')
            ->sort(10));

        VILT::registerMenu(Menu::make('quotations')
            ->can('view_order')
            ->icon('bx bx-money')
            ->label(__('Quotations'))
            ->group(__('Quotations'))
            ->route('quotations.index')
            ->sort(10));

        VILT::registerMenu(Menu::make('approved_quotations')
            ->can('view_order')
            ->icon('bx bx-money')
            ->label(__('Approved Quotations'))
            ->group(__('Quotations'))
            ->route('quotations.approved')
            ->sort(9));

        VILT::registerMenu(Menu::make('report')
            ->can('add_system_user')
            ->icon('bx bx-menu')
            ->label(__('Car Shop Report'))
            ->group(__('Report'))
            ->route('report.index')
            ->sort(200)
        );

        VILT::registerMenu(Menu::make('system_users')
            ->can('add_system_user')
            ->icon('bx bx-user')
            ->label(__('System Users'))
            ->route('system-users.index')
            ->group(__('Settings'))
            ->sort(20)
        );


        return array_merge(parent::share($request), [
            'data' => VILT::get(),
            'flash' => function () use ($request) {
                return [
                    'alert' => $request->session()->get('alert'),
                ];
            }
        ]);
    }
}
