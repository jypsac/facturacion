<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Familia;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=Categoria::all();
        return view('configuracion_general.categoria.index',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('configuracion_general.categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // contador par codigo
        $suma=Categoria::all()->count();
        $suma ++;
        $cien=1000+$suma;
        $contador=substr($cien,1);
        $nombre=$request->get('descripcion');
        $nombre=strtoupper($nombre);

        $categoria=new Categoria;
        $categoria->codigo=$contador;
        $categoria->descripcion=$nombre;
        $categoria->save();

        return redirect()->route('categoria.index');
        // return $nombre;
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
        $nombre=$request->get('descripcion');
        $nombre=strtoupper($nombre);
        $categoria=Categoria::find($id);
        $categoria->descripcion=$nombre;
        $categoria->save();

        return redirect()->route('categoria.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
