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
        $servicios=servicios::get();
        foreach ($servicios as $servicio) {
            $servicio_id=$servicio->id;
            $precio_nacional=$servicio->precio_nacional;
            $precio_extranjero=$precio_nacional/$tipoCambio->paralelo;

            $servicio=servicios::find($servicio_id);
            $servicio->precio_extranjero=round($precio_extranjero,2);
            $servicio->save();
        }
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
