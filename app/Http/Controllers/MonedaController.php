<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Moneda;
use App\Pais;
use App\TipoCambio;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moneda=Moneda::all();
        $cantidad_monedas=count($moneda);
        $paises=Pais::all();
        return view('configuracion_general.moneda.index',compact('moneda','paises','cantidad_monedas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises=Pais::all();
        return view('configuracion_general.moneda.create',compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $moneda=new Moneda;
        $moneda->nombre=$request->get('nombre');
        $moneda->simbolo=$request->get('simbolo');
        $moneda->codigo=$request->get('codigo');
        $moneda->pais=$request->get('pais');
        $moneda->descripcion=$request->get('descripcion');
        $moneda->save();
        return redirect()->route('moneda.index');
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
        $moneda = Moneda::find($id);
        $paises=Pais::all();
        return view('configuracion_general.moneda.edit' ,compact('moneda','paises'));
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
       $btn_principal=$request->get('principal');
       if ($btn_principal=='on') {
        $principal='1';
        $buscar_principa=Moneda::where('principal',1)->first();
        $id_principal=$buscar_principa->id;

        $moneda=Moneda::find($id_principal);
        $moneda->principal=0;
        $moneda->save();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $tipo_cambio_delete=TipoCambio::findOrFail($tipo_cambio->id);
        $tipo_cambio_delete->delete();
    }
    else{ $principal='0';}

    $moneda=Moneda::find($id);
    // $moneda->nombre=$request->get('nombre');
    // $moneda->simbolo=$request->get('simbolo');
    // $moneda->codigo=strtoupper($request->get('codigo'));
    $moneda->principal=$principal;
    // $moneda->pais=$request->get('pais');
    $moneda->save();

    /*Buscador de moneda Principal*/
    $principal_mone=Moneda::where('principal',1)->first();
    $id_prin_mone=$principal_mone->id;
    $ids_empresa=1;/*id empresa*/

    $empresa=Empresa::find($ids_empresa); /*Cambio de moneda de empresa*/
    $empresa->moneda_principal=$id_prin_mone;
    $empresa->save();
    return redirect()->route('moneda.index');
}

public function principal($id)
{
    return redirect()->route('moneda.index');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $moneda=Moneda::findOrFail($id);
        $moneda->delete();

        return redirect()->route('moneda.index');
    }
}
