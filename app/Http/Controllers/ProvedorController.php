<?php

namespace App\Http\Controllers;
use App\Provedor;
use Illuminate\Http\Request;

class ProvedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provedores=Provedor::all();
        return view('auxiliar.provedor.index',compact('provedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auxiliar.provedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provedor=new Provedor;
        $provedor->ruc=$request->get('ruc');
        $provedor->empresa=$request->get('empresa');
        $provedor->direccion=$request->get('direccion');
        $provedor->telefonos=$request->get('telefonos');
        $provedor->email=$request->get('email');
        $provedor->contacto_provedor=$request->get('contacto_provedor');
        $provedor->celular_provedor=$request->get('celular_provedor');
        $provedor->email_provedor=$request->get('email_provedor');
        $provedor->observacion=$request->get('observacion');
        $provedor->save();
        return redirect()->route('provedor.index');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provedor=Provedor::find($id);
        return view('auxiliar.provedor.create',compact('provedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provedor=Provedor::find($id);
        return view('auxiliar.provedor.edit',compact('provedor'));
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
        $provedor=Provedor::find($id);
        $provedor->ruc=$request->get('ruc');
        $provedor->empresa=$request->get('empresa');
        $provedor->direccion=$request->get('direccion');
        $provedor->telefonos=$request->get('telefonos');
        $provedor->email=$request->get('email');
        $provedor->contacto_provedor=$request->get('contacto_provedor');
        $provedor->celular_provedor=$request->get('celular_provedor');
        $provedor->email_provedor=$request->get('email_provedor');
        $provedor->observacion=$request->get('observacion');
        $provedor->save();
        return redirect()->route('provedor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provedor=Provedor::findOrFail($id);
        $provedor->delete();

        return redirect()->route('provedor.index');
    }
}
