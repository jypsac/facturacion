<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas=Marca::all();
        return view('maestro.catalogo.clasificacion.marca.index',compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maestro.catalogo.clasificacion.marca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasfile('imagen')){
            $imagen =$request->file('imagen');
            $nombre_imagen = time().$imagen->getClientOriginalName();
            $imagen =$request->file('imagen')->storeAs('marcas',$nombre_imagen);
        }else{
            $nombre_imagen="defecto.png";
        }

        $marca=new Marca;
        $marca->nombre=$request->get('nombre');
        $marca->codigo=$request->get('codigo');
        $marca->abreviatura=$request->get('abreviatura');
        $marca->nombre_empresa=$request->get('nombre_empresa');
        $marca->descripcion=$request->get('descripcion');
        $marca->imagen=$nombre_imagen;
        $marca->save();

        return redirect()->route('marca.index');
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
        $marca=Marca::find($id);
        return view('maestro.catalogo.clasificacion.marca.edit',compact('marca'));
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

        if($request->hasfile('imagen')){
            $imagen =$request->file('imagen');
            $nombre_imagen = time().$imagen->getClientOriginalName();
            $imagen =$request->file('imagen')->storeAs('marcas',$nombre_imagen);
        }else{
            $nombre_imagen="defecto.png";
        }

        $marca=Marca::find($id);
        $marca->nombre=$request->get('nombre');
        $marca->codigo=$request->get('codigo');
        $marca->abreviatura=$request->get('abreviatura');
        $marca->nombre_empresa=$request->get('nombre_empresa');
        $marca->descripcion=$request->get('descripcion');
        $marca->imagen=$nombre_imagen;
        $marca->save();

        return redirect()->route('marca.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca=Marca::findOrFail($id);
        $marca->delete();

        return redirect()->route('marca.index');
    }
}
