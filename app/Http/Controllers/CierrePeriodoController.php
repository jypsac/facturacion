<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CierrePeriodo;
use App\Moneda;
use App\Empresa;
use Barryvdh\DomPDF\Facade as PDF;
use App\CierrePeriodoRegistro;

class CierrePeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cierre_periodo=CierrePeriodo::all();
        return view('inventario.cierre_periodo.index',compact('cierre_periodo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $empresa = Empresa::first();
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $cierre_periodo=CierrePeriodo::where('id',$id)->first();
        $cierre_periodo_registro=CierrePeriodoRegistro::where('cierre_periodo_id',$id)->get();
        return view('inventario.cierre_periodo.show',compact('cierre_periodo','moneda1','moneda2','cierre_periodo_registro','empresa'));
    }
    public function pdf($id){
        $moneda_principal=Moneda::where('principal',1)->first();
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $cierre_periodo=CierrePeriodo::where('id',$id)->first();
        $cierre_periodo_re = CierrePeriodoRegistro::where('cierre_periodo_id',$id)->get();
        $empresa = Empresa::first();
        $fecha_m = $cierre_periodo->mes;
        $fecha_y = $cierre_periodo->año;

        $name_pdf='Cierre_Periodo_'.$fecha_m.'_'.$fecha_y.'.pdf';

        $pdf=PDF::loadView('inventario.cierre_periodo.pdf',compact('cierre_periodo','moneda_principal','moneda1','moneda2','cierre_periodo_re','empresa'));
        return $pdf->download($name_pdf);
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
