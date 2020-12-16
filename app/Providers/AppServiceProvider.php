<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Schema;
use App\TipoCambio;
use App\Observers\TipoCambioObserver;

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
    public function boot()
    {
        TipoCambio::observe(TipoCambioObserver::class);
        // TipoCambio::observe(new TipoCambioObserver());
        // Schema::defaultStringLength(191);
    }
}
