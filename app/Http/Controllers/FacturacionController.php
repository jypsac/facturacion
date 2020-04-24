<?php

namespace App\Http\Controllers;

use App\Facturacion;
use App\Empresa;
use App\Ventas_registro;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $facturacion=Facturacion::all();
        
        return view('transaccion.venta.facturacion.index', compact('facturacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('transaccion.venta.facturacion.create');
        
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
         $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
       return view('transaccion.venta.facturacion.show', compact('facturacion','empresa'));
    }
    
    public function show_boleta(Request $request,$id)
    {
      
       return view('transaccion.venta.facturacion.boleta');
    }

    public function create_boleta()
    {
      
       return view('transaccion.venta.facturacion.create_boleta');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facturacion=Facturacion::find($id);
         return view('transaccion.venta.facturacion.edit', compact('facturacion'));
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
            $venta_registro=Ventas_registro::where('id_facturacion',$id)->first();
            $id_venta_r=$venta_registro->id;

            $venta=Ventas_registro::where('id',$id_venta_r)->first();
            $venta->estado_fac=1;
            $venta->save();

            $fac=Facturacion::where('id',$id)->first();
            $fac->estado=1;
            $fac->save();

            return redirect()->route('facturacion.index');
    }
}
