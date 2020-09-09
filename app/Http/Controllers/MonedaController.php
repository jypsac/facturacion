<?php

namespace App\Http\Controllers;

use App\Moneda;
use App\Pais;
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

        return view('configuracion_general.moneda.index',[
            'moneda' => Moneda::all()
        ]);
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
        $moneda=Moneda::find($id);
        $moneda->nombre=$request->get('nombre');
        $moneda->simbolo=$request->get('simbolo');
        $moneda->codigo=$request->get('codigo');
        $moneda->pais=$request->get('pais');
        $moneda->descripcion=$request->get('descripcion');
        $moneda->save();
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
