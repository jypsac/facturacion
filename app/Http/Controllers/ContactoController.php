<?php

namespace App\Http\Controllers;

use App\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $contactos=Contacto::all();
        // return view('auxiliar.cliente.contacto.index',compact('contactos'));
    }

    public function index_id($id)
    {   
        $contactos=Contacto::where("clientes_id","=",$id)->get();
        return view('auxiliar.cliente.contacto.index',compact('contactos','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return "hola0dsadsadsad";
    // }

    public function crear($id)
    {
        return view('auxiliar.cliente.contacto.create',compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=$request->get('clientes_id');

        $contacto= new Contacto;
        $contacto->nombre=$request->get('nombre');
        $contacto->cargo=$request->get('cargo');
        $contacto->telefono=$request->get('telefono');
        $contacto->celular=$request->get('celular');
        $contacto->email=$request->get('email');
        $contacto->clientes_id=$request->get('clientes_id');
        $contacto->save();

        return redirect()->route('contacto.index_id',compact('id'));
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
    public function editar($id_contacto,$id_cliente)
    {
        $contacto=Contacto::where("clientes_id","=",$id)->first();
        return view('auxiliar.cliente.contacto.edit',compact('id'));
        
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
        $contacto=Contacto::findOrFail($id);
        $contacto->delete();

        return redirect()->route('cliente.index');
    }
}
