<?php

namespace App\Providers;

use App\Menu as AppMenu;

use App\Models\LoginLog;
use App\Models\Menu;
use App\Observers\LoginLogObserver;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        view()->composer('includes.navbar', function ($view) {
            $view->with('menus', AppMenu::menus());
        });

        view()->composer('includes.footer', function ($view) {
            $view->with([
                'url' => '/',
                'menus' => AppMenu::menus()
            ]);
        });

        LoginLog::observe(LoginLogObserver::class);

    }
}
