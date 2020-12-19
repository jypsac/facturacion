<?php

namespace App\Observers;

use App\TipoCambio;
use App\servicios;
use App\Moneda;
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
        // Tipo de cambio -------------------------------------------------------------------------------------
        $cambio=TipoCambio::latest('created_at')->first();

        //  Moneda --------------------------------------------------------------------------------------------
        $moneda_principal=Moneda::where('tipo','nacional')->first();
        $moneda_principal_id=$moneda_principal->id;

        $servicios=servicios::get();
        foreach ($servicios as $servicio) {
            $servicio_id=$servicio->id;
            $servicio=servicios::find($servicio_id);
            // obtencion de la moneda en el servicio
            $moneda_id=$servicio->moneda_id;
            // Generar Cambio para precio nacional y precio extranjero ----------------------------------------------
            if($moneda_principal_id==$moneda_id){
                $precio_nacional=$servicio->precio_nacional;
                $precio_extranjero=$precio_nacional*$cambio->paralelo;
                $servicio->precio_extranjero=round($precio_extranjero,2);
                $servicio->save();
            }else{
                $precio_extranjero=$servicio->precio_extranjero;
                $precio_nacional=$precio_extranjero/$cambio->paralelo;
                $servicio->precio_nacional=round($precio_nacional,2);
                $servicio->save();
            }
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
