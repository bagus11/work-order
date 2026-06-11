<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider

{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     config(['app.locale' => 'id']);
    //     Carbon::setLocale('id');
    //     date_default_timezone_set('Asia/Jakarta');
    //     URL::forceRootUrl(config('app.url'));
    // }

     public function boot(): void
    {
        config(['app.locale' => 'id']);

      \Carbon\Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        if (app()->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
    }
}
