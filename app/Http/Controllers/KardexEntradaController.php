<?php

namespace App\Http\Controllers;

use App\Kardex_entrada;
use Illuminate\Http\Request;

class KardexEntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kardex_entradas=Kardex_entrada::all();
        return view('inventario.kardex.entrada.index' ,compact('kardex_entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.kardex.entrada.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kardex_entrada::create(request()->all());

        return redirect()->route('kardex-entrada.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('inventario.kardex.entrada.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kardex_entrada=Kardex_entrada::find($id);
        return view('inventario.kardex.entrada.edit' ,compact('kardex_entrada'));
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
        $update=Kardex_entrada::find($id);
        $update->nombre=$request->get('nombre');
        $update->precio=$request->get('precio');
        $update->serie_producto=$request->get('serie_producto');
        $update->cantidad=$request->get('cantidad');
        $update->provedor=$request->get('provedor');
        $update->almacen=$request->get('almacen');
        $update->informacion=$request->get('informacion');
        $update->save();

        return redirect()->route('kardex-entrada.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy=Kardex_entrada::findOrFail($id);
        $destroy->delete();

        return redirect()->route('kardex-entrada.index');
    }
}
