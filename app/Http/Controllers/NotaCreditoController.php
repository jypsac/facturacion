<?php

namespace App\Http\Controllers;

use App\Facturacion;
use App\Facturacion_registro;
use App\Empresa;
use App\Igv;
use App\Banco;
use App\Nota_Credito;
use App\Nota_Credito_registro;

use Illuminate\Http\Request;

class NotaCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notas_creditos=Facturacion::where('f_electronica',1)->where('estado',1)->get();
        return view('transaccion.venta.nota_credito.index',compact('notas_creditos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //cambiar de 0 a 1 en f_electronica
        $facturas=Facturacion::where('f_electronica',1)->where('estado',0)->get();
        return view('transaccion.venta.nota_credito.lista_facturacion',compact('facturas'));
    }

    public function create_nota_credito(Request $request){

        $facturacion=Facturacion::find($request->factura_id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$request->factura_id)->get();
        
        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        return view('transaccion.venta.nota_credito.create',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
