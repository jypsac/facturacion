<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Config;
use App\Permiso;
use App\Personal;
use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=User::all();
        $almacen=Almacen::all();
        return view('maestro.usuario.index',compact('usuarios','almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista()
    {
        $almacen=Almacen::all();
        $personales=Personal::where('usuario_registrado',0)->get();
        return view('maestro.usuario.lista',compact('personales','almacen'));
    }


    // public function create()
    // {

    // }

    public function crear($id)
    {
        $personal=Personal::find($id);
        return view('maestro.usuario.create',compact('personal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //Al no poder recibir 2 parametros,obliga a la creacion de otro controlador
    }

    public function creacion(Request $request,$id)
    {
        $this->validate($request,[
            'correo' => ['required','email','unique:users,email'],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);

        $data = $request->all();
        // recibiendo Datos
        $usuarios=User::all();
        $name=$request->get('name');
        $email=$request->get('correo');
        $almacen_id=$request->get('almacen_id');
        $password=$request->get('password');
        $password_2=$request->get('password_2');
        $numero_validacion=rand(600000000, 900000000) ;

        if ($password_2==$password) {
            /*Apariencia de su interfaz*/
            $apariencia=new Config();
            $apariencia->fondo_perfil='paisaje_noche.jpg';
            $apariencia->borde_foto="3px" ;
            $apariencia->color_borde_foto='#ffffff';
            $apariencia->foto_icono="defecto.png" ;
            $apariencia->foto_perfil= "0" ;
            $apariencia->letra="none" ;
            $apariencia->tamano_letra=" " ;
            $apariencia->color_sombra_nombre="#000000 " ;
            $apariencia->color_nombre= "#ffffff " ;
            $apariencia->tamano_letra_perfil= "12px " ;
            $apariencia->save();

            /*Creacion del Nuevo Usuario*/
            $user=new User();
            $user->personal_id=$id;
            $user->confi_id=$apariencia->id;
            $user->name=$name;
            $user->email=$email;
            $user->password=bcrypt($password);
            $user->almacen_id=$almacen_id;
            $user->numero_validacion=$numero_validacion;
            $user->estado_validacion=0;
            $user->estado=0;
            $user->email_creado=0;
            $user->save();

            $user=Personal::find($id);
            $user->usuario_registrado=1;
            $user->save();

            /* envio*/
            /* Confi*/
            $smtpAddress = 'mail.jypsac.com'; // = $request->smtp
            $port = '25';
            $encryption = '';
            $yourEmail = 'desarrollo@jypsac.com';
            $yourPassword = '=+WQyq73%cC"';
            $sendto = $email;
            $titulo = 'Usuario:Codigo Confirmacion';
            $mensaje = $numero_validacion;
            // $bakcup=    $correo_busqueda->email_backup ;
            /*Fin Confi*/
            $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
            $mailer =new \Swift_Mailer($transport);
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto])->setBody($mensaje, 'text/html');
            if($mailer->send($message)){
                return redirect()->route('usuario.index');
            }else{
                return "Something went wrong :(";
            }
            /*fin envio*/
            return redirect()->route('usuario.index');
        }
        else{
            $almacen=Almacen::all();
            $errores='Las Contraseñas No Coinciden, Intentelo nuevamente';
            $personales=Personal::where('usuario_registrado',0)->get();
            return view('maestro.usuario.lista',compact('personales','errores','almacen'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //no xD
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario=User::find($id);
        return view('maestro.usuario.edit',compact('usuario'));
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

        $usuarios=User::all();
        $almacen=Almacen::all();
        $contrasena_confirmar=$request->get('contrasena_confirmar');
        $correo_new=$request->get('correo');
        $password_new=$request->get('password_new');
        $contrasena_adm=$request->get('contrasena_adm');
        $almacen_id=$request->get('almacen_id');
        $estado=$request->get('estado');
        if ($estado=='on') { $estado_numero='1'; }
        else{ $estado_numero='0';}

        if (password_verify($contrasena_confirmar, $contrasena_adm)){
            if (isset($password_new)) {
                $user=User::find($id);
                $user->email=$correo_new;
                $user->almacen_id=$almacen_id;
                $user->estado=$estado_numero;
                $user->password=bcrypt($password_new);
                $user->save();
                return redirect()->route('usuario.index');
            }
            else{
                $user=User::find($id);
                $user->email=$correo_new;
                $user->almacen_id=$almacen_id;
                $user->estado=$estado_numero;
                $user->save();
                return redirect()->route('usuario.index');
            }
        }
        else {
            $error='Contraseña delAdministrador Erronea - Ningun Cambio Realizado';
            return view('maestro.usuario.index',compact('usuarios','error','almacen'));
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function  envio_codigo(Request $request, $id)
    {
        $cod_1=$request->get('cod_1');
        $cod_2=$request->get('cod_2');
        $cod_3=$request->get('cod_3');
        $user=User::where('id',$id)->first();
        $codigo_usuario=$user->numero_validacion;
        $accion=$request->get('accion');
        $correo_envio=$request->get('correo');
        $codigo_validacion=$cod_1.$cod_2.$cod_3;

        if ($accion=='Reenviar Codigo') {
            /* envio*/
            /* Confi*/
        $smtpAddress = 'mail.jypsac.com'; // = $request->smtp
        $port = '25';
        $encryption = '';
        $yourEmail = 'desarrollo@jypsac.com';
        $yourPassword = '=+WQyq73%cC"';
        $sendto = $correo_envio;
        $titulo = 'Sistema-Codigo Confirmacion';
        $mensaje = 'mensaje de confirm';
        // $bakcup=    $correo_busqueda->email_backup ;
        /*Fin Confi*/
        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);
        $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto])->setBody($mensaje, 'text/html');
        if($mailer->send($message)){
            return redirect()->route('usuario.index');
        }else{
            return "Something went wrong :(";
        }
        /*fin envio*/

    }
    elseif ($accion=='Validar') {
     if ($codigo_validacion==$codigo_usuario) {
       $user=User::find($id);
       $user->estado_validacion='1';
       $user->estado='1';
       $user->save();
       return redirect()->route('usuario.index');
   }
}

}

public function activar($id)
{
}

public function permiso($id){

    $usuario=User::find($id);
    $permisos=Permiso::all();
    return view('maestro.usuario.permisos.lista',compact('usuario','permiso'));
}

public function asignar_permiso(){
        //asignamiento de permisos
}
}
