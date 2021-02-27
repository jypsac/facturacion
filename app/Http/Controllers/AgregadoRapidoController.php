<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
use App\Cliente;
use App\Contacto;
use Illuminate\Support\Facades\Redirect;
use App\Personal;

class AgregadoRapidoController extends Controller
{

//FUNCIONES PARA EJECUTAR CONSULTAS

//FUNCION PARA CREAR CLIENTES Y CONTACTOS
    public function cliente_store(Request $request){
        //return "1";
        $this->validate($request,[
            'numero_documento' => ['required','unique:clientes,numero_documento'],
        ],[
            'numero_documento.unique' => 'El Cliente ya ha sido registrado'
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

        $idCliente=$cliente->id;

        $this->contactos_store($data,$idCliente);

        // return view('auxiliar.cliente.contacto.cliente_new');
        return back();
    }

    public function contactos_store($data,$idCliente){

        // $contador=Cliente::count();
        $contacto=new Contacto;
        $contacto->primer_contacto=1;
        $contacto->nombre=$data['nombre_contacto'];
        $contacto->cargo=$data['cargo_contacto'];
        $contacto->telefono=$data['telefono_contacto'];
        $contacto->celular=$data['celular_contacto'];
        $contacto->email=$data['email_contacto'];
        $contacto->clientes_id=$idCliente;
        $contacto->save();
    }


//FUNCION PARA CREAR CLIENTE Y CONTACTO CON PARAMETROS POR DEFECTO
    public function cliente_cotizado(Request $request){
        $ruta_retorno=$request->get('ruta_retorno');
        $documento_identificacion=$request->get('numero_documento');
        $cliente_existe=Cliente::where('numero_documento',$documento_identificacion)->count();

        if ($cliente_existe==0) {
           $cliente= new Cliente;
           $cliente->nombre=$request->get('nombre');
           $cliente->direccion=$request->get('direccion');
           $cliente->email=$request->get('email');
           $cliente->telefono=$request->get('telefono');
           $cliente->celular=$request->get('celular');
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

           $contacto=new Contacto;
           $contacto->nombre=$request->get('nombre_contacto');
           $contacto->primer_contacto=1;
           $contacto->cargo=$request->get('cargo_contacto');
           $contacto->telefono=$request->get('telefono_contacto');
           $contacto->celular=$request->get('celular_contacto');
           $contacto->email=$request->get('email_contacto');
           $contacto->clientes_id=$cliente->id;
           $contacto->save();
           return redirect()->route($ruta_retorno.'.index');
       }else{
          return redirect()->route($ruta_retorno.'.index')->withErrors(['Cliente ya Agregado!']);
       }
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
    $personal->estado_trabajador_laboral = 'Activo';
    $personal->usuario_registrado = 0;
    $personal->estado = 0;
    $personal->save();
    return back();
}
public function send_whatsapp(Request $request){
    $url1 = $request->get('url');
        //$url2 = $request->get('mensaje');

    $numero = $request->get('numero');
    if($request->get('mensaje') == ""){
        $url2 = $request->get('name_sin_cambio');
    }else{
        $url2 = $request->get('mensaje');
    }
        //$numero_send =  strtr($numero, "    ", " ");
    $num1 = substr($numero, -3);
    $num2 = substr($numero, -6,3);
    $num3 = substr($numero, -11,3);
        //$mensajes_send = str_replace (" ","%20",$mensaje);
    $send = "https://api.whatsapp.com/send?phone=+51%20".$num3."%20".$num2."%20".$num1."&text=".$url1.$url2;
    return  Redirect::to($send);
        //return $mensaje;
}
}
