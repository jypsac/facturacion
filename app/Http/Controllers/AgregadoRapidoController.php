<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
use App\Cliente;
use App\Contacto;
class AgregadoRapidoController extends Controller
{
//Productos     

//FUNCIONES PARA EJECUTAR CONSULTAS

    //FUNCION PARA CREAR CLIENTES Y CONTACTOS
    public function cliente_store(Request $request){
        $data = $request->all();

        $cliente= new Cliente;
        $cliente->nombre=$request->get('nombre');
        $cliente->direccion=$request->get('direccion');
        $cliente->email=$request->get('email');
        $cliente->telefono=$request->get('telefono');
        $cliente->celular=$request->get('celular');
        $cliente->empresa=$request->get('empresa');
        $cliente->documento_identificacion=$request->get('documento_identificacion');
        $cliente->numero_documento=$request->get('numero_documento');
        $cliente->save();

        $this->contactos_store($data);

        // return view('auxiliar.cliente.contacto.cliente_new');
        return back();
    }

    public function contactos_store($data){

        $contador=Cliente::count();

        $contacto=new Contacto;
        $contacto->nombre=$data['nombre_contacto'];
        $contacto->cargo=$data['cargo_contacto'];
        $contacto->telefono=$data['telefono_contacto'];
        $contacto->celular=$data['celular_contacto'];
        $contacto->email=$data['email_contacto'];
        $contacto->clientes_id=$contador;
        $contacto->save();
    }

    //FUNCION PARA CREAR MARCAS
    public function marcas_store(Request $request){

        $marca=new Marca;
        $marca->nombre=$request->get('nombre');
        $marca->codigo=$request->get('codigo');
        $marca->abreviatura=$request->get('abreviatura');
        $marca->nombre_empresa=$request->get('nombre_empresa');
        $marca->descripcion=$request->get('descripcion');
        $marca->save();

        return back();
    }

    //FUNCION PARA CREAR PERSONAL
    public function personal_store(){

    }
}
