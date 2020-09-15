<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Banco;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mi_empresa=Empresa::first();
        $banco=Banco::all();
        return view('configuracion_general.empresa.index',compact('mi_empresa','banco'));
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
        return 'hola';
        $empresa=Empresa::find($id);
        $empresa->nombre=$request->get('nombre');
        $empresa->razon_social=$request->get('razon_social');
        $empresa->ruc=$request->get('ruc');
        $empresa->telefono=$request->get('telefono');
        $empresa->movil=$request->get('movil');
        $empresa->correo=$request->get('correo');
        $empresa->pais=$request->get('pais');
        $empresa->region_provincia=$request->get('region_provincia');
        $empresa->ciudad=$request->get('ciudad');
        $empresa->calle=$request->get('calle');
        $empresa->codigo_postal=$request->get('codigo_postal');
        $empresa->rubro=$request->get('rubro');
        $empresa->moneda_principal=$request->get('moneda_principal');
        $empresa->descripcion=$request->get('descripcion');
        $empresa->pagina_web=$request->get('pagina_web');
        $empresa->foto=$request->get('foto');
        $empresa->save();

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
