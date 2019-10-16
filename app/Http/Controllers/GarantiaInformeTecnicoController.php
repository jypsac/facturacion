<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaInformeTecnico;
use App\GarantiaGuiaEgreso;

class GarantiaInformeTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garantias_informe_tecnicos=GarantiaInformeTecnico::all();
        return view('transaccion.garantias.informe_tecnico.index',compact('garantias_informe_tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

        if($request->hasfile('image1')){
            $image =$request->file('image1');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        if($request->hasfile('image2')){
            $image =$request->file('image2');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        if($request->hasfile('image3')){
            $image =$request->file('image3');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        if($request->hasfile('image4')){
            $image =$request->file('image4');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        if($request->hasfile('image5')){
            $image =$request->file('image5');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        if($request->hasfile('image6')){
            $image =$request->file('image6');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        $user->image=$name;


        $garantia_informe_tecnico= new GarantiaInformeTecnico;
        $garantia_informe_tecnico->marca=$request->get('marca');
        $garantia_informe_tecnico->motivo=$request->get('motivo');
        $garantia_informe_tecnico->ing_asignado=$request->get('ing_asignado');
        $garantia_informe_tecnico->fecha=$request->get('fecha');
        $garantia_informe_tecnico->orden_servicio=$request->get('orden_servicio');
        $garantia_informe_tecnico->estado=1;
        $garantia_informe_tecnico->egresado=1;
        $garantia_informe_tecnico->informe_tecnico=1;
        $garantia_informe_tecnico->asunto=$request->get('asunto');
        $garantia_informe_tecnico->nombre_cliente=$request->get('nombre_cliente');
        $garantia_informe_tecnico->direccion=$request->get('direccion');
        $garantia_informe_tecnico->telefono=$request->get('telefono');
        $garantia_informe_tecnico->correo=$request->get('correo');
        $garantia_informe_tecnico->contacto=$request->get('contacto');
        $garantia_informe_tecnico->nombre_equipo=$request->get('nombre_equipo');
        $garantia_informe_tecnico->numero_serie=$request->get('numero_serie');
        $garantia_informe_tecnico->codigo_interno=$request->get('codigo_interno');
        $garantia_informe_tecnico->fecha_compra=$request->get('fecha_compra');
        $garantia_informe_tecnico->descripcion_problema=$request->get('descripcion_problema');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->informe=$request->get('informe');
        $garantia_informe_tecnico->save();

        return redirect()->route('garantia_informe_tecnico.index');
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
        $garantia_guia_egreso=GarantiaGuiaEgreso::find($id);
        return view('transaccion.garantias.informe_tecnico.edit',compact('garantia_guia_egreso'));
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

    public function guias()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::all();
        return view('transaccion.garantias.informe_tecnico.guias',compact('garantias_guias_egresos'));
    }
}
