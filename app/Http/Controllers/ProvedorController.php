<?php

namespace App\Http\Controllers;
use App\Provedor;
use Illuminate\Http\Request;

class ProvedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provedores=Provedor::all();
        return view('auxiliar.provedor.index',compact('provedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auxiliar.provedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provedor=new Provedor;
        $provedor->ruc=$request->get('ruc');
        $provedor->empresa=$request->get('empresa');
        $provedor->direccion=$request->get('direccion');
        $provedor->telefonos=$request->get('telefonos');
        $provedor->email=$request->get('email');
        $provedor->contacto_provedor=$request->get('contacto_provedor');
        $provedor->celular_provedor=$request->get('celular_provedor');
        $provedor->email_provedor=$request->get('email_provedor');
        $provedor->observacion=$request->get('observacion');
        $provedor->save();
        return redirect()->route('provedor.show',$provedor->id );


    }

     public function store_kardex(Request $request)
    {
        $provedor=new Provedor;
        $provedor->ruc=$request->get('ruc');
        $provedor->empresa=$request->get('empresa');
        $provedor->direccion=$request->get('direccion');
        $provedor->telefonos=$request->get('telefonos');
        $provedor->email=$request->get('email');
        $provedor->contacto_provedor=$request->get('contacto_provedor');
        $provedor->celular_provedor=$request->get('celular_provedor');
        $provedor->email_provedor=$request->get('email_provedor');
        $provedor->observacion=$request->get('observacion');
        $provedor->save();
        return redirect()->route('kardex-entrada.create');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provedor=Provedor::find($id);
        return view('auxiliar.provedor.show',compact('provedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provedor=Provedor::find($id);
        return view('auxiliar.provedor.edit',compact('provedor'));
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
        $provedor=Provedor::find($id);
        $provedor->ruc=$request->get('ruc');
        $provedor->empresa=$request->get('empresa');
        $provedor->direccion=$request->get('direccion');
        $provedor->telefonos=$request->get('telefonos');
        $provedor->email=$request->get('email');
        $provedor->contacto_provedor=$request->get('contacto_provedor');
        $provedor->celular_provedor=$request->get('celular_provedor');
        $provedor->email_provedor=$request->get('email_provedor');
        $provedor->observacion=$request->get('observacion');
        $provedor->save();
        return redirect()->route('provedor.show', $provedor->id);
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provedor=Provedor::findOrFail($id);
        $provedor->delete();

        return redirect()->route('provedor.index');
    }

    function ruc(Request $request){

        $ruc=$request->get('ruc');
        $data = file_get_contents("https://api.sunat.cloud/ruc/".$ruc);
        $info = json_decode($data, true);

        if($data==='[]' || $info['fecha_inscripcion']==='--'){
            $datos = array(0 => 'nada');
            echo json_encode($datos);
        }else{
        $datos = array(
            0 => $info['ruc'],
            1 => $info['razon_social'],
            2 => date("d/m/Y", strtotime($info['fecha_actividad'])),
            3 => $info['contribuyente_condicion'],
            4 => $info['contribuyente_tipo'],
            5 => $info['contribuyente_estado'],
            6 => date("d/m/Y", strtotime($info['fecha_inscripcion'])),
            7 => $info['domicilio_fiscal'],
            8 => date("d/m/Y", strtotime($info['emision_electronica'])),
            9 => $info['ruc']."@correo.com"
        );
            echo json_encode($datos);
        }

    }
}
