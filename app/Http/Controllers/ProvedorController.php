<?php

namespace App\Http\Controllers;
use App\Cliente;
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
        $btn=$request->get('btn');

        $data = file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/".$ruc."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlc2Fycm9sbG9Aanlwc2FjLmNvbSJ9.1Pt1A4PEFAGmFySlfVeFKZKuVCC-u_ZEW-KYQq-P57k");
        $info = json_decode($data, true);

        $clientes=Cliente::where('numero_documento',array($info['ruc']))->first();
        if (isset($clientes)) {
            $ruc_view=$clientes->numero_documento.'- existente';
         }
        else{
        $ruc_view=array($info['ruc']);
        }

    if($data==='[]' || $info['fechaInscripcion']==='--'){
        $datos = array(0 => 'nada');
        echo json_encode($datos);
    }else{
        $datos = array(
            // 0 => $info['ruc'],
            0 => $ruc_view,
            1 => $info['razonSocial'],
            2 => $info['direccion'],
            3 => $info['departamento'].' - '.$info['provincia'].' - '.$info['distrito'],
            4 => date("d/m/Y", strtotime($info['fechaInscripcion'])),
            5 => $info['departamento']
        );
        return json_encode($datos);
    }

}
}
