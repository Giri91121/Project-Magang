<?php

namespace App\Providers;

use App\Models\Setting;
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
    }
}
