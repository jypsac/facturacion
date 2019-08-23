<?php

namespace App\Http\Controllers;

use App\Unidad_medida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidad_de_medida=Unidad_medida::all();
        return view('maestro.conf_general.unidad-de-medida.index',compact('unidad_de_medida'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maestro.conf_general.unidad-de-medida.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Unidad_medida::create(request()->only('simbolo','medida','unidad'));

        return redirect()->route('unidad-medida.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidad_de_medida=Unidad_medida::find($id);
        return view('maestro.conf_general.unidad-de-medida.edit',compact('unidad_de_medida'));
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
        $unidad_medida=Unidad_medida::find($id);
        $unidad_medida->simbolo=$request->get('simbolo');
        $unidad_medida->medida=$request->get('medida');
        $unidad_medida->unidad=$request->get('unidad');
        $unidad_medida->save();

        return redirect()->route('unidad-medida.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unidad_medida::Destroy($id);
        return redirect()->route('unidad-medida.index');
    }
}
