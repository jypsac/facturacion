<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Forma_pago;
use App\Igv;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use Illuminate\Http\Request;

class BoletaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        return view('transaccion.venta.servicios.boleta.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
