<?php

namespace App\Observers;

use App\TipoCambio;
use App\servicios;
class TipoCambioObserver
{
    /**
     * Handle the TipoCambio "created" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function created(TipoCambio $tipoCambio)
    {
        $m=servicios::find(1);
        $m->codigo_original="999";
        $m->save();
        // return $tipoCambio;
    }

    /**
     * Handle the TipoCambio "updated" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function updated(TipoCambio $tipoCambio)
    {
        return $tipoCambio;
    }

    /**
     * Handle the TipoCambio "deleted" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function deleted(TipoCambio $tipoCambio)
    {

    }

    /**
     * Handle the TipoCambio "restored" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function restored(TipoCambio $tipoCambio)
    {
        //
    }

    /**
     * Handle the TipoCambio "force deleted" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function forceDeleted(TipoCambio $tipoCambio)
    {
        //
    }
}
