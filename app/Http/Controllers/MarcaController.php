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
        return view('configuracion_general.marca.index',compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion_general.marca.create');
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
        $suma=Marca::all()->count();
        $suma ++;
        $cien=100000+$suma;
        $contador=substr($cien,1);

        $marca=new Marca;
        $marca->nombre=strtoupper($request->get('nombre'));
        $marca->codigo=$contador;
        $marca->abreviatura=strtoupper($request->get('abreviatura'));
        $marca->nombre_empresa=strtoupper($request->get('nombre_empresa'));
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
        return view('configuracion_general.marca.edit',compact('marca'));
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
            $nombre_imagen=$request->get('imagenes');
        }

        $marca=Marca::find($id);
        $marca->nombre=strtoupper($request->get('nombre'));
        $marca->abreviatura=strtoupper($request->get('abreviatura'));
        $marca->nombre_empresa=strtoupper($request->get('nombre_empresa'));
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
