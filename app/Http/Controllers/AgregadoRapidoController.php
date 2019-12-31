<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
use App\Cliente;
use App\Contacto;

class AgregadoRapidoController extends Controller
{

//FUNCIONES PARA EJECUTAR CONSULTAS

    //FUNCION PARA CREAR CLIENTES Y CONTACTOS
    public function cliente_store(Request $request){

        $this->validate($request,[
            'nombre' => ['required','unique:clientes,nombre'],
            'numero_documento' => ['required','unique:clientes,numero_documento'],
            'email' => ['required','email','unique:clientes,email'],
        ],[
            'nombre.unique' => 'El Cliente ya ha sido registrado'
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
    public function personal_store(Request $request){
        $personal=new Personal;
        $personal->nombres=$request->get('nombres');
        $personal->apellidos=$request->get('apellidos');
        $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
        $personal->celular=$request->get('celular');
        $personal->telefono=$request->get('telefono');
        $personal->email=$request->get('email');
        $personal->genero=$request->get('genero');
        $personal->documento_identificacion=$request->get('documento_identificacion');
        $personal->numero_documento=$request->get('numero_documento');
        $personal->nacionalidad=$request->get('nacionalidad');
        $personal->estado_civil=$request->get('estado_civil');
        $personal->nivel_educativo=$request->get('nivel_educativo');
        $personal->profesion=$request->get('profesion');
        $personal->direccion=$request->get('direccion');
        $personal->save();
        return back();
    }

}
