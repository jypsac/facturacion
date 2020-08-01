<?php

namespace App\Http\Controllers;
use App\Servicios;
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
        return view('maestro.catalogo.servicios.index',compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maestro.catalogo.servicios.create');
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
        $this->validate($request,[
            'codigo_original' => ['required','unique:servicios,codigo_original'],
        ]
    );
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
        $codigo_servicio='SERV-0000'.$suma;
        $servicios=new Servicios;
        $servicios->codigo_servicio=$codigo_servicio;
        $servicios->codigo_original=$request->get('codigo_original');
        $servicios->nombre=$request->get('nombre');
        $servicios->categoria=$request->get('categoria');
        $servicios->precio=$request->get('precio');
        $servicios->descripcion=$request->get('descripcion');
        $servicios->descuento=$request->get('descuento');
        $servicios->utilidad=$request->get('utilidad');
        $servicios->foto=$name;
        $servicios->estado_anular='0';
        $servicios->estado_activo='0';
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
        return view('maestro.catalogo.servicios.show',compact('servicios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicios=Servicios::find($id);
        return view('maestro.catalogo.servicios.edit',compact('servicios'));
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
            $name=$request->get('foto');
        }
        $servicio= Servicios::find($id);
        $servicio->nombre=$request->get('nombre');
        $servicio->descripcion=$request->get('descripcion');
        $servicio->descuento=$request->get('descuento');
        $servicio->utilidad=$request->get('utilidad');
        $servicio->precio=$request->get('precio');
        $servicio->foto=$name;
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
