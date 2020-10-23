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
        $conteo_almacen=Almacen::where('estado',0)->count();
        $personal=Personal::where('estado',1)->get();
        return view('configuracion_general.almacen.index',compact('almacenes','personal','conteo_almacen'));
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

        $this->validate($request,[
            'nombre' => ['required'],
            'abreviatura' => ['required'],
            'responsable' => ['required'],
            'direccion' => ['required'],
            'descripcion' => ['required'],
            'cod_fac' => ['required','integer'],
            'cod_bol' => ['required','integer'],
            'cod_guia' => ['required','integer'],
            'codigo_sunat' => ['required'],
        ]);

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
        $this->validate($request,[
            'nombre' => ['required'],
            'abreviatura' => ['required'],
            'responsable' => ['required'],
            'direccion' => ['required'],
            'descripcion' => ['required'],
        ]);

        $estado=$request->get('estado');
        if($estado=='on'){
            $estado_numero='0';
        }
        else{
            $estado_numero='1';
        }

        // OBTENCION DE CAMPOS
        $nr_fac=$request->get('cod_fac');
        $nr_bol=$request->get('cod_bol');
        $nr_guia=$request->get('cod_guia');

        $almacen=Almacen::where('id', $id)->first();
        $almacen=Almacen::find($id);
        $almacen->nombre=$request->get('nombre');
        $almacen->abreviatura=$request->get('abreviatura');
        $almacen->responsable=$request->get('responsable');
        $almacen->direccion=$request->get('direccion');
        $almacen->descripcion=$request->get('descripcion');
        $almacen->estado=$estado_numero;
        if(is_numeric($almacen->cod_fac) and is_numeric($nr_fac)){
            $almacen->cod_fac=$request->get('cod_fac');
        }
        // VALIDACION EXTRA SI RECIVE UN TEXTO DENTRO DEL IF,PARA ENVIARLO COMO ALERTA
        // else{
        //     return  redirect()->route('almacen.index')->with('campo', 'Los campos numericos de factura no pueden ser modificados');
        // }
        if(is_numeric($almacen->cod_bol) and is_numeric($nr_bol)){
            $almacen->cod_bol=$request->get('cod_bol');
        }
        // else{
        //     return  redirect()->route('almacen.index')->with('campo', 'Los campos numericos de boleta no pueden ser modificados');
        // }
        if(is_numeric($almacen->cod_guia) and is_numeric($nr_guia)){
            $almacen->cod_guia=$request->get('cod_guia');
        }
        // else{
        //     return  redirect()->route('almacen.index')->with('campo', 'Los campos numericos de guia no pueden ser modificados');
        // }
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
