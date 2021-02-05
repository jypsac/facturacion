<?php

namespace App\Http\Controllers;
use App\Cliente;
use App\Contacto;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes=Cliente::all();
        $contactos=Contacto::all();
        return view('auxiliar.cliente.index',compact('clientes','contactos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes=Cliente::all();
        return view('auxiliar.cliente.create',compact('clientes'));
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
            'nombre' => ['required','unique:clientes,nombre'],
            'numero_documento' => ['required','unique:clientes,numero_documento'],
        ],[
            'nombre.unique' => 'El Cliente ya ha sido registrado',
            'nombre.numero_documento' => 'El numero de documentacion ya ha sido registrado',
        ]);

        $data = $request->all();

        $cliente= new Cliente;
        $cliente->nombre=$request->get('nombre');
        $cliente->direccion=$request->get('direccion');
        $cliente->email=$request->get('email');
        $cliente->telefono=$request->get('telefono');
        $cliente->celular=$request->get('celular');
        // $cliente->empresa=$request->get('empresa');
        $cliente->documento_identificacion=$request->get('documento_identificacion');
        $cliente->numero_documento=$request->get('numero_documento');

        $cliente->ciudad=$request->get('ciudad');
        $cliente->departamento=$request->get('departamento');
        $cliente->pais=$request->get('pais');
        $cliente->tipo_cliente=$request->get('tipo_cliente');
        $cliente->aniversario=$request->get('aniversario');
        $cliente->cod_postal=$request->get('cod_postal');
        $cliente->fecha_registro=$request->get('fecha_registro');

        $cliente->save();

        $this->storecontact($data);

        // return view('auxiliar.cliente.contacto.cliente_new');
        return redirect()->route('cliente.index');
    }

    public function storecontact($data)
    {
        $contador=Cliente::count();

        // $contacto=new Contacto;
        // $contacto->nombre=$request->get('nombre_contacto');
        // $contacto->cargo=$request->get('cargo_contacto');
        // $contacto->telefono=$request->get('telefono_contacto');
        // $contacto->celular=$request->get('celular_contacto');
        // $contacto->email=$request->get('email_contacto');
        // $contacto->clientes_id=$contador;
        // $contacto->save();

        // return back();

        $contacto=new Contacto;
        $contacto->nombre=$data['nombre_contacto'];
        $contacto->primer_contacto=1;
        $contacto->cargo=$data['cargo_contacto'];
        $contacto->telefono=$data['telefono_contacto'];
        $contacto->celular=$data['celular_contacto'];
        $contacto->email=$data['email_contacto'];
        $contacto->clientes_id=$contador;
        $contacto->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        $cliente_show=Cliente::find($id);
        $contacto_show=Contacto::where('clientes_id','=',$id)->orderBy('primer_contacto','DESC')->get();
        return view('auxiliar.cliente.show',compact('cliente_show','contacto_show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente=Cliente::find($id);
        return view('auxiliar.cliente.edit',compact('cliente'));
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
        $cliente= Cliente::find($id);
        $cliente->nombre=$request->get('nombre');
        $cliente->direccion=$request->get('direccion');
        $cliente->email=$request->get('email');
        $cliente->telefono=$request->get('telefono');
        $cliente->celular=$request->get('celular');
        $cliente->empresa=$request->get('empresa');
        $cliente->documento_identificacion=$request->get('documento_identificacion');
        $cliente->numero_documento=$request->get('numero_documento');
        $cliente->save();
        return redirect()->route('cliente.show',$cliente->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente=Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('cliente.index');
    }

    // public function consulta(Request $request){
    //     $nombre=$request->get('nombre');
    //     $validar= Cliente::where("nombre","=",$nombre)->get();

    //     if ($nombre == $validar){
    //         $si=true;
    //     }else{
    //         $si=false;
    //     }
    //     return $si;
    // }
}
