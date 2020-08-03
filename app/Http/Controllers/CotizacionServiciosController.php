<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Cotizacion_Servicios;
use App\Forma_pago;
use App\Igv;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use Illuminate\Http\Request;

class CotizacionServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cotizaciones_servicios=Cotizacion_Servicios::all();
        return view('transaccion.venta.servicios.cotizacion.index',compact('cotizaciones_servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_factura()
    {
        $servicios=Servicios::where('estado_anular',0)->get();

        foreach ($servicios as $index => $servicio) {
            $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
            $array[]=$servicio->precio+$utilidad[$index];
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::all();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        return view('transaccion.venta.servicios.cotizacion.factura.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_factura(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_boleta()
    {
        $servicios=Servicios::where('estado_anular',0)->get();
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        foreach ($servicios as $index => $servicio) {
            $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
            $igv[]=$servicio->precio*$igv_total/100;
            $array[]=$servicio->precio+$utilidad[$index]+$igv[$index];
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::all();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        return view('transaccion.venta.servicios.cotizacion.boleta.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function store_boleta(Request $request)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
