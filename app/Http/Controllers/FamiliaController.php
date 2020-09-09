<?php

namespace App\Http\Controllers;

use App\Familia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familias=Familia::all();
        return view('configuracion_general.familia.index',compact('familias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion_general.familia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $suma=Familia::all()->count();
        $suma ++;
        $cien=1000+$suma;
        $contador=substr($cien,1);
        $nombre=$request->get('descripcion');
        $nombre=strtoupper($nombre);

        $familia=new Familia;
        $familia->codigo=$contador;
        $familia->descripcion=$nombre;
        $familia->save();

        return redirect()->route('familia.index');
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
        $familia=Familia::find($id);
        return view('configuracion_general.familia.edit',compact('familia'));
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
        $familia=Familia::find($id);
        $familia->descripcion=$nombre;
        $familia->save();

        return redirect()->route('familia.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $familia=Familia::findOrFail($id);
        $familia->delete();

        return redirect()->route('familia.index');
    }
}
