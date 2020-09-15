<?php

namespace App\Http\Controllers;

use App\TipoCambio;
use App\Moneda;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoCambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $tipo_cambio=TipoCambio::all();
        return view('maestro.tipo_cambio.index',compact('tipo_cambio','moneda1','moneda2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maestro.tipo_cambio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*varaibles del Index*/
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $tipo_cambio=TipoCambio::all();
        /**/

        $consulta=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();/*si se hizo hoy el cambio*/
        if($consulta){
            $error= "no puede generar otro tipo de cambio , en el mismo dia";
            return view('maestro.tipo_cambio.index',compact('tipo_cambio','moneda1','moneda2','error'));
        }
        $moneda_principal=Moneda::where('principal',1)->first();

        if ($moneda_principal->id =='1')/*pregunta si esta en Soles(Nacional)*/ {
            $compra=$request->get('compra');
            $paralelo=$request->get('paralelo');
            if ($compra<$paralelo) {
               $error= 'el tipo de Cambio "Paralelo"('.$paralelo.') debe ser menor al tipo de Cambio "Compra("'.$compra.')';
               return view('maestro.tipo_cambio.index',compact('tipo_cambio','moneda1','moneda2','error'));
           }
       }
       elseif ($moneda_principal->id =='2')/*pregunta si esta en Dolares(Extranjero)*/  {
            $compra=$request->get('compra');
            $paralelo=$request->get('paralelo');
            if ($compra>$paralelo) {
            $error= 'el tipo de Cambio "Paralelo"('.$paralelo.') debe ser Mayor al tipo de Cambio "Compra("'.$compra.')';
            return view('maestro.tipo_cambio.index',compact('tipo_cambio','moneda1','moneda2','error'));
            }
    }
        $cambio=new TipoCambio;
        $cambio->compra=$request->get('compra');
        $cambio->venta=$request->get('venta');
        $cambio->paralelo=$request->get('paralelo');
        $cambio->fecha=Carbon::now()->format('Y-m-d');
        $cambio->save();

    return redirect()->route('tipo_cambio.index');

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
