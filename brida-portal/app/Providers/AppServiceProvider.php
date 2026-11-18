<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\NavbarMenu;
use Illuminate\Support\Facades\View;
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
        // Bagikan variabel global $portalSettings ke seluruh view Blade
        if (Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            View::share('portalSettings', $settings);
        } else {
            View::share('portalSettings', []);
        }

        // Bagikan daftar menu navbar dinamis beserta submenunya ke seluruh view
        if (Schema::hasTable('navbar_menus')) {
            $navbarMenus = NavbarMenu::with(['children' => function($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

            View::share('navbarMenus', $navbarMenus);
        } else {
            View::share('navbarMenus', collect());
        }
    }
}
