<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Config;
use App\Permiso;
use App\Personal;
use App\User;
use Auth;
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
        $almacen=Almacen::where('estado',0)->get();
        return view('configuracion_general.usuario.index',compact('usuarios','almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista()
    {
        $almacen=Almacen::where('estado','0')->get();
        $personales=Personal::where('usuario_registrado',0)->where('estado',1)->get();
        return view('configuracion_general.usuario.lista',compact('personales','almacen'));
    }


    // public function create()
    // {

    // }

    public function crear($id)
    {
        $personal=Personal::find($id);
        return view('configuracion_general.usuario.create',compact('personal'));
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
            $usuario_hora=User::where('id',$id)->first();

            $nombre_personal=Personal::where('id',$id)->first();
            $codigo_mensaje=$numero_validacion;
            $codigo_1 = substr($codigo_mensaje, 0, 3);
            $codigo_2 = substr($codigo_mensaje, 3, 3);
            $codigo_3 = substr($codigo_mensaje, 6, 3);
            $codigo_unidos=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */
            $cuerpo_mensaje=$codigo_unidos.' es tu código de Validación para confirmar el usuario al sistema. Esta clave es confidencial,<br> no la compartas con nadie. Solo ingrésala en el Sistema para continuar con tu confirmacion.<br><br>
            Titular: '.$nombre_personal->nombres.'<br>
            Fecha y hora:  '.$usuario_hora->updated_at.'<br><br>
            Si no has realizado esta operación o tienes cualquier duda respecto al Código de Validación,<br> puedes comunicarte con nuestro correo de soporte desarrollo@jypsac.com. ';
            /* envio*/
            /* Confi*/
            $smtpAddress = 'mail.grupojypsac.com';
            $port = '465';
            $encryption = 'SSL';
            $yourEmail = 'informes@grupojypsac.com';
            $yourPassword = 'vP8JzoYs5Inu';
            $sendto = $email;
            $titulo = 'Sistema-Codigo Confirmacion';
            $mensaje = $cuerpo_mensaje;
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
            return view('configuracion_general.usuario.lista',compact('personales','errores','almacen'));
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
        return view('configuracion_general.usuario.edit',compact('usuario'));
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

        $numero_validacion=rand(600000000, 900000000) ;
        $nombre_personal=Personal::where('id',$id)->first();
        $usuario_id=User::where('id',$id)->first();
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
        if (isset($password_new)) { $password=bcrypt($password_new); }
        else{ $password=$usuario_id->password;}

        if (password_verify($contrasena_confirmar, $contrasena_adm)){
            if ($correo_new!=$usuario_id->email ) {
                $this->validate($request,[
                    'correo' => ['required','email','unique:users,email'],
                ],[
                    'correo.unique' => 'El Correo "'.$correo_new.'" ya esta Registrado, Use otro correo para registrar este usuario.',
                ]);

                $data = $request->all();
                $user=User::find($id);
                $user->email=$correo_new;
                $user->estado_validacion='0';
                $user->estado='0';
                $user->numero_validacion=$numero_validacion;
                $user->password=$password;
                $user->save();
                $codigo_mensaje=$numero_validacion;
                $codigo_1 = substr($codigo_mensaje, 0, 3);
                $codigo_2 = substr($codigo_mensaje, 3, 3);
                $codigo_3 = substr($codigo_mensaje, 6, 3);
                $codigo_unidos=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */
                $cuerpo_mensaje=$codigo_unidos.' es tu código de Validación para confirmar el usuario al sistema. Esta clave es confidencial,<br> no la compartas con nadie. Solo ingrésala en el Sistema para continuar con tu confirmacion.<br><br>
                Usuario: '.$nombre_personal->nombres.'<br>
                Fecha y hora: '.$usuario_id->updated_at.'<br><br>
                Si no has realizado esta operación o tienes cualquier duda respecto al Código de Validación,<br> puedes comunicarte con nuestro correo de soporte desarrollo@jypsac.com. ';

                $smtpAddress = 'mail.grupojypsac.com';
                $port = '465';
                $encryption = 'SSL';
                $yourEmail = 'informes@grupojypsac.com';
                $yourPassword = 'vP8JzoYs5Inu';
                $sendto = $correo_new;
                $titulo = 'Sistema-Codigo Confirmacion';
                $mensaje = $cuerpo_mensaje;
            // $bakcup=    $correo_busqueda->email_backup ;
                /*Fin Confi*/
                $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
                $mailer =new \Swift_Mailer($transport);
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto])->setBody($mensaje, 'text/html');
                if($mailer->send($message)){
                    return redirect()->route('usuario.index');
                }
                else{
                    return "Something went wrong :(";
                }
                /*fin envio*/
                return redirect()->route('usuario.index');
            }
            else{
                $user=User::find($id);
                $user->almacen_id=$almacen_id;
                $user->estado=$estado_numero;
                $user->password=$password;
                $user->save();
                return redirect()->route('usuario.index');
            }
        }
        else {
            $errores='Contraseña delAdministrador Erronea - Ningun Cambio Realizado';
            return view('configuracion_general.usuario.index',compact('usuarios','errores','almacen'));
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
        /*Configuracion Correo*/
        $smtpAddress = 'mail.grupojypsac.com';
        $port = '465';
        $encryption = 'SSL';
        $yourEmail = 'informes@grupojypsac.com';
        $yourPassword = 'vP8JzoYs5Inu';
        /*Fin confing correo*/

        /*Codigo recibido del index*/
        $cod_1=$request->get('cod_1');
        $cod_2=$request->get('cod_2');
        $cod_3=$request->get('cod_3');
        $codigo_validacion=$cod_1.$cod_2.$cod_3;


        $user=User::where('id',$id)->first();/*id del usuario*/
        $id_personal=$user->personal_id;
        $nombre_personal=Personal::where('id',$id_personal)->first();/*nombre id del personal agregado al usuario*/

        $codigo_usuario=$user->numero_validacion;
        $codigo1 = substr($codigo_usuario, 0, 3);
        $codigo2 = substr($codigo_usuario, 3, 3);
        $codigo3 = substr($codigo_usuario, 6, 3);
        $codigo_unido=$codigo1.'-'.$codigo2.'-'.$codigo3;/*Codigo unido */

        $accion=$request->get('accion');
        $correo_envio=$request->get('correo');


        if ($accion=='Reenviar Codigo') {
            /* envio*/
            /* Confi*/
            $numero_validacions=rand(600000000, 900000000) ;
            $user=User::find($id);
            $user->email=$request->get('correo');
            $user->numero_validacion=$numero_validacions;
            $user->save();
            $usuario_hora=User::where('id',$id)->first();

            $codigo_mensaje=$numero_validacions;
            $codigo_1 = substr($codigo_mensaje, 0, 3);
            $codigo_2 = substr($codigo_mensaje, 3, 3);
            $codigo_3 = substr($codigo_mensaje, 6, 3);
            $codigo_unidos=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */
            $cuerpo_mensaje=$codigo_unidos.' es tu código de Validación para confirmar el usuario al sistema. Esta clave es confidencial,<br> no la compartas con nadie. Solo ingrésala en el Sistema para continuar con tu confirmacion.<br><br>
            Usuario: '.$nombre_personal->nombres.'<br>
            Fecha y hora: '.$usuario_hora->updated_at.'<br><br>
            Si no has realizado esta operación o tienes cualquier duda respecto al Código de Validación,<br> puedes comunicarte con nuestro correo de soporte desarrollo@jypsac.com. ';

            // $smtpAddress = 'mail.grupojypsac.com';
            // $port = '465';
            // $encryption = 'SMTP';
            // $yourEmail = 'informes@grupojypsac.com';
            // $yourPassword = '=+WQyq73%cC"';
            $sendto = $correo_envio;
            $titulo = 'Sistema-Codigo Confirmacion';
            $mensaje = $cuerpo_mensaje;
            // $bakcup=    $correo_busqueda->email_backup ;
            /*Fin Confi*/
            $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
            $mailer =new \Swift_Mailer($transport);
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto])->setBody($mensaje, 'text/html');
            if($mailer->send($message)){
                return redirect()->route('usuario.index');
            }
            else{
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
            else{
               $usuarios=User::all();
               $almacen=Almacen::where('estado',0)->get();
               $errores='Los Códigos son Incorrectos, si no tiene aún los códigos, Presione Reenviar.';
               return view('configuracion_general.usuario.index',compact('usuarios','errores','almacen'));
           }

       }
       elseif ($accion=='Cambiar Correo') {
        if ($user->email==$correo_envio) {
            $numero_validacion=rand(600000000, 900000000) ;
            $user=User::find($id);
            $user->email=$request->get('correo');
            $user->numero_validacion=$numero_validacion;
            $user->save();
            return redirect()->route('usuario.index');
        }
        else{
            $this->validate($request,[
                'correo' => ['required','email','unique:users,email'],
            ],[
                'correo.unique' => 'El Correo "'.$correo_envio.'" ya esta Registrado, Use otro correo para registrar este usuario.',
            ]);

            $data = $request->all();
            $numero_validacion=rand(600000000, 900000000) ;
            $user=User::find($id);
            $user->email=$request->get('correo');
            $user->numero_validacion=$numero_validacion;
            $user->save();

            $codigo_mensaje=$numero_validacion;
            $codigo_1 = substr($codigo_mensaje, 0, 3);
            $codigo_2 = substr($codigo_mensaje, 3, 3);
            $codigo_3 = substr($codigo_mensaje, 6, 3);
            $codigo_unidos=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */
            $usuario_hora=User::where('id',$id)->first();
            $cuerpo_mensaje=$codigo_unidos.' es tu código de Validación para confirmar el usuario al sistema. Esta clave es confidencial,<br> no la compartas con nadie. Solo ingrésala en el Sistema para continuar con tu confirmacion.<br><br>
            Usuario: '.$nombre_personal->nombres.'<br>
            Fecha y hora: '.$usuario_hora->updated_at.'<br><br>
            Si no has realizado esta operación o tienes cualquier duda respecto al Código de Validación,<br> puedes comunicarte con nuestro correo de soporte desarrollo@jypsac.com. ';


            // $smtpAddress = 'mail.grupojypsac.com';
            // $port = '465';
            // $encryption = 'SMTP';
            // $yourEmail = 'informes@grupojypsac.com';
            // $yourPassword = '=+WQyq73%cC"';
            $sendto = $correo_envio;
            $titulo = 'Sistema-Codigo Confirmacion';
            $mensaje = $cuerpo_mensaje;
            // $bakcup=    $correo_busqueda->email_backup ;
            /*Fin Confi*/
            $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
            $mailer =new \Swift_Mailer($transport);
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto])->setBody($mensaje, 'text/html');
            if($mailer->send($message)){
                return redirect()->route('usuario.index');
            }
            else{
                return "Something went wrong :(";
            }
            /*fin envio*/
            return redirect()->route('usuario.index');
        }

    }

}

public function activar($id)
{
}

public function permiso($id){

    $usuario=User::find($id);
    $user= User::where('id',$id)->pluck('id')->first();
    $permisos=Permiso::all();

    $hola = $user->hasPermissionTo('inicio');
    return view('configuracion_general.usuario.permisos.lista',compact('usuario','permisos','user'));

    // return $hola;
}

public function asignar_permiso(Request $request,$id){
        //asignamiento de permisos
    $permisos = $request->get('permisos');
    $user = User::find($id);
    $user->givePermissionTo($permisos);
    $user->save();

    return  back();
}
public function delegar_permiso(Request $request,$id){
        //asignamiento de permisos
    $permisos = $request->get('permisos');
    $user = User::find($id);
    $user->revokePermissionTo($permisos);
    $user->save();

    return  back();
}
}
