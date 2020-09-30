<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Personal;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{

    // public function __construct(){
    //     $this->middleware('permission:configuracion_general-almacenes.index',['only' => ['index']]);
    //     $this->middleware('permission:configuracion_general-almacenes.create',['only' => ['create']]);
    //     $this->middleware('permission:configuracion_general-almacenes.store',['only' => ['store']]);
    //     $this->middleware('permission:configuracion_general-almacenes.show',['only' => ['show']]);
    //     $this->middleware('permission:configuracion_general-almacenes.edit',['only' => ['edit']]);
    //     $this->middleware('permission:configuracion_general-almacenes.update',['only' => ['update']]);
    //     $this->middleware('permission:configuracion_general-almacenes.destroy',['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes=Almacen::all();
        $personal=Personal::where('estado',1)->get();
        return view('configuracion_general.almacen.index',compact('almacenes','personal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $almacen=new Almacen;
        $almacen->nombre=$request->get('nombre');
        $almacen->abreviatura=$request->get('abreviatura');
        $almacen->responsable=$request->get('responsable');
        $almacen->direccion=$request->get('direccion');
        $almacen->descripcion=$request->get('descripcion');
        $almacen->cod_fac=$request->get('cod_fac');
        $almacen->cod_bol=$request->get('cod_bol');
        $almacen->cod_guia=$request->get('cod_guia');
        $almacen->codigo_sunat=$request->get('codigo_sunat');
        $almacen->estado='0';
        $almacen->cod_fac=$request->get('cod_fac');
        $almacen->cod_bol=$request->get('cod_bol');
        $almacen->cod_guia=$request->get('cod_guia');
        $almacen->save();

        return redirect()->route('almacen.index');
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
      $estado=$request->get('estado');
      if ($estado=='on') { $estado_numero='0'; }
      else{ $estado_numero='1';}

      $almacen=Almacen::find($id);
      $almacen->nombre=$request->get('nombre');
      $almacen->abreviatura=$request->get('abreviatura');
      $almacen->responsable=$request->get('responsable');
      $almacen->direccion=$request->get('direccion');
      $almacen->descripcion=$request->get('descripcion');
      $almacen->codigo_sunat=$request->get('codigo_sunat');
      $almacen->estado=$estado_numero;
      $almacen->cod_fac=$request->get('cod_fac');
      $almacen->cod_bol=$request->get('cod_bol');
      $almacen->cod_guia=$request->get('cod_guia');
      $almacen->save();

      return redirect()->route('almacen.index');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


    }
}
