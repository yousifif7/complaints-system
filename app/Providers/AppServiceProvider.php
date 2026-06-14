<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if (Schema::hasTable('settings')) {
            View::share('appSettings', Setting::current());
        }

        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $view->with('htmlLang', $locale);
            $view->with('htmlDir', $locale === 'ar' ? 'rtl' : 'ltr');
        });
    }
}
