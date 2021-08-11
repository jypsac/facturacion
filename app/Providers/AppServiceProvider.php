<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Schema;
use App\TipoCambio;
use App\Stock_producto;
use App\kardex_entrada_registro;
use App\Observers\TipoCambioObserver;
use App\Observers\StockProductosObserver;
use App\Observers\KardexEntradaRegistroObserver;

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
        Stock_producto::observe(StockProductosObserver::class);
        // kardex_entrada_registro::observe(KardexEntradaRegistroObserver::class);
        // TipoCambio::observe(new TipoCambioObserver());
        // Schema::defaultStringLength(191);
    }
}
