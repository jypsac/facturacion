<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Personal;
use App\Codigo_guia_almacen;
use App\Stock_producto;
use App\Stock_almacen;
use App\Producto;
use App\kardex_entrada_registro;
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
        $personal=Personal::where('estado',1)->where('estado','!=',1)->get();
        $cod_guia_almacen = Codigo_guia_almacen::all();
        return view('configuracion_general.almacen.index',compact('almacenes','personal','conteo_almacen','cod_guia_almacen'));
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

        // return "limite";
        $this->validate($request,[
            'nombre' => ['required'],
            'abreviatura' => ['required','unique:almacen'],
            'serie_factura' => ['required','unique:cod_guia_almacen'],
            'serie_boleta' => ['required','unique:cod_guia_almacen'],
            'serie_remision' => ['required','unique:cod_guia_almacen'],
            'responsable' => ['required'],
            'direccion' => ['required'],
            'descripcion' => ['required'],
            'cod_fac' => ['required','integer'],
            'cod_bol' => ['required','integer'],
            'cod_guia' => ['required','integer'],
            'cod_sunat' => ['required','unique:cod_guia_almacen'],
            'ubigeo' => ['required', 'max:6', 'min:6'],
        ]);

        $almacen=new Almacen;
        $almacen->nombre=$request->get('nombre');
        // $serie_fact_last = Almacen::orderBy('serie_factura','DESC')->latest()->first();
        // $almacen->serie_factura=$request->get('serie_factura');
        // $serie_bol_last = Almacen::orderBy('serie_boleta','DESC')->latest()->first();
        // $almacen->serie_boleta=$request->get('serie_boleta');
        // $serie_guia_last = Almacen::orderBy('serie_remision','DESC')->latest()->first();
        // $almacen->serie_remision=$request->get('serie_remision');;
        $almacen->abreviatura=$request->get('abreviatura');
        $almacen->responsable=$request->get('responsable');
        $almacen->direccion=$request->get('direccion');
        $almacen->cod_postal=$request->get('ubigeo');
        $almacen->descripcion=$request->get('descripcion');
        // $almacen->cod_fac=$request->get('cod_fac');
        // $almacen->cod_bol=$request->get('cod_bol');
        // $almacen->cod_guia=$request->get('cod_guia');
        // $almacen->codigo_sunat=$request->get('codigo_sunat');
        $almacen->estado='0';
        $almacen->principal='0';
        $almacen->save();
        //INSERCION EN LA NUEVA TABLA PARA CODIGOS
        $cod_guia_almacen= new Codigo_guia_almacen;
        $cod_guia_almacen->almacen_id = $almacen->id;
        $cod_guia_almacen->cod_sunat = $request->get('cod_sunat');
        //factura
        $cod_guia_almacen->serie_factura = $request->get('serie_factura');
        $cod_guia_almacen->cod_factura = $request->get('cod_fac');
        ///boleta
        $cod_guia_almacen->serie_boleta = $request->get('serie_boleta');
        $cod_guia_almacen->cod_boleta = $request->get('cod_bol');
        //remision
        $cod_guia_almacen->serie_remision = $request->get('serie_remision');
        $cod_guia_almacen->cod_remision = $request->get('cod_guia');
        //nota de credito
        $cod_guia_almacen->serie_nota_credito = $request->get('serie_credito');
        $cod_guia_almacen->cod_nota_credito = $request->get('cod_credito');
        //nota de debito
        $cod_guia_almacen->serie_nota_debito = $request->get('serie_debito');
        $cod_guia_almacen->cod_nota_debito = $request->get('cod_debito');
        $cod_guia_almacen->save();

        $productos= Producto::get();
        foreach($productos as $producto){
            $stock_almacen=new Stock_almacen;
            $stock_almacen->producto_id=$producto->id;
            $stock_almacen->almacen_id=$almacen->id;
            $stock_almacen->stock=0;
            $stock_almacen->save();
        }
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
            'nombre' => ['required','unique:almacen,nombre,'.$id],
            'abreviatura' => ['required','unique:almacen,abreviatura,'.$id],
            'responsable' => ['required'],
            'direccion' => ['required'],
            'descripcion' => ['required'],
            'cod_sunat' => ['required','unique:cod_guia_almacen,cod_sunat,'.$id],
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
        // $almacen=Almacen::where('id', $id)->first();
        $almacen=Almacen::find($id);
        $almacen->nombre=$request->get('nombre');
        $almacen->abreviatura=$request->get('abreviatura');
        $almacen->responsable=$request->get('responsable');
        $almacen->direccion=$request->get('direccion');

        $almacen->descripcion=$request->get('descripcion');
        $almacen->estado=$estado_numero;
        $almacen->save();
        //INSERCION EL LA TABLA DE CODGIGO
        $cod_guia_almacen = Codigo_guia_almacen::where('almacen_id',$id)->first();
        $cod_guia_almacen->cod_sunat=$request->get('cod_sunat');
        if(is_numeric($cod_guia_almacen->cod_factura) and is_numeric($nr_fac)){
            $cod_guia_almacen->cod_factura=$request->get('cod_fac');
        }
        if(is_numeric($cod_guia_almacen->cod_boleta) and is_numeric($nr_bol)){
            $cod_guia_almacen->cod_boleta=$request->get('cod_bol');
        }
        if(is_numeric($cod_guia_almacen->cod_remision) and is_numeric($nr_guia)){
            $cod_guia_almacen->cod_remision=$request->get('cod_guia');
        }
        $cod_guia_almacen->save();
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
