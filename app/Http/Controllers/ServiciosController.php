<?php

namespace App\Http\Controllers;
use App\Familia;
use App\Marca;
use App\Moneda;
use App\Servicios;
use App\TipoCambio;
use App\Tipo_afectacion;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios=Servicios::all();
        return view('producto_servicios.servicios.index',compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas=Marca::all();
        $familias=Familia::all();
        $monedas=Moneda::all();
        $afectacion=Tipo_afectacion::all();
        return view('producto_servicios.servicios.create',compact('monedas','marcas','familias','afectacion'));
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
        // return $request;
        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/servicios/');
            $image1->move($destinationPath,$name);
        }else{
            $name="defecto.png";
        }
        $conteo=Servicios::all()->count();
        $suma=$conteo +1;
        $servicio_nr=str_pad($suma, 8, "0", STR_PAD_LEFT);
        $codigo_servicio="SERV-".$servicio_nr;

        // Tipo de cambio -------------------------------------------------------------------------------------
        $cambio=TipoCambio::latest('created_at')->first();

        //  Moneda --------------------------------------------------------------------------------------------
        $moneda_principal=Moneda::where('tipo','nacional')->first();
        $moneda_principal_id=$moneda_principal->id;
        $moneda_id=$request->get('moneda');

        // Generar Cambio para precio nacional y precio extranjero ----------------------------------------------
        if($moneda_principal_id==$moneda_id){
            $precio_nacional=$request->get('precio');
            $precio_extranjero=$precio_nacional/$cambio->paralelo;
        }else{
            $precio_extranjero=$request->get('precio');
            $precio_nacional=$precio_extranjero*$cambio->paralelo;
        }
        $codigo_original=$request->get('codigo_original');

        $servicios=new Servicios;
        $servicios->codigo_servicio=$codigo_servicio;

        if (isset($codigo_original)) {
        $servicios->codigo_original=$request->get('codigo_original');}
        else{
        $servicios->codigo_original=$codigo_servicio; }

        $servicios->moneda_id=$moneda_id;
        $servicios->marca_id=$request->get('marca_id');
        $servicios->familia_id=$request->get('familia_id');
        $servicios->nombre=$request->get('nombre');
        $servicios->categoria=$request->get('categoria');
        $servicios->precio_nacional=round($precio_nacional,2);
        $servicios->precio_extranjero=round($precio_extranjero,2);
        $servicios->descripcion=$request->get('descripcion');
        $servicios->descuento=$request->get('descuento');
        $servicios->utilidad=$request->get('utilidad');
        $servicios->foto=$name;
        $servicios->estado_anular='0';
        $servicios->estado_activo='0';
        $servicios->tipo_afectacion_id=$request->get('afectacion');
        $servicios->save();
        return redirect()->route('servicios.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicios=Servicios::find($id);
        $monedas=Moneda::all();
        $moneda_nacional=Moneda::where('tipo','nacional')->first();
        $moneda_extranjera=Moneda::where('tipo','extranjera')->first();
        return view('producto_servicios.servicios.show',compact('servicios','monedas','moneda_nacional','moneda_extranjera'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $marcas=Marca::all();
       $familias=Familia::all();
       $moneda_principal=Moneda::where('tipo','nacional')->first();
        $afectacion=Tipo_afectacion::all();
       $moneda_principal_id=$moneda_principal->id;
        // $moneda_id=$request->get('moneda');

       $monedas=Moneda::all();
       $servicios=Servicios::find($id);
       return view('producto_servicios.servicios.edit',compact('servicios','monedas','moneda_principal_id','marcas','familias','afectacion'));
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
        $boton=$request->get('actualizar');
        if ($boton=='anular') {
           $servicio= Servicios::find($id);
           $servicio->estado_anular='1';
           $servicio->save();
           return redirect()->route('servicios.index');
       }
       elseif ($boton=='edit_servicio') {
        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/servicios/');
            $image1->move($destinationPath,$name);
        }else{
            $name=$request->get('foto_original');
        }

        // Tipo de cambio -------------------------------------------------------------------------------------
        $cambio=TipoCambio::latest('created_at')->first();

        //  Moneda --------------------------------------------------------------------------------------------
        $moneda_principal=Moneda::where('tipo','nacional')->first();
        $moneda_principal_id=$moneda_principal->id;
        $moneda_id=$request->get('moneda');

        // Generar Cambio para precio nacional y precio extranjero ----------------------------------------------
        if($moneda_principal_id==$moneda_id){
            $precio_nacional=$request->get('precio');
            $precio_extranjero=$precio_nacional/$cambio->paralelo;
        }else{
            $precio_extranjero=$request->get('precio');
            $precio_nacional=$precio_extranjero*$cambio->paralelo;
        }

        $servicio= Servicios::find($id);
        $servicio->moneda_id=$moneda_id;
        $servicio->nombre=$request->get('nombre');
        $servicio->descripcion=$request->get('descripcion');
        $servicio->descuento=$request->get('descuento');
        $servicio->utilidad=$request->get('utilidad');
        $servicio->precio_nacional=round($precio_nacional,2);
        $servicio->precio_extranjero=round($precio_extranjero,2);
        $servicio->foto=$name;
        $servicio->tipo_afectacion_id=$request->get('afectacion');
        $servicio->save();
        return redirect()->route('servicios.show', $id);
    }
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
