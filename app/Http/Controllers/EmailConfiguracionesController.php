<?php

namespace App\Http\Controllers;

use App;
use App\EmailConfiguraciones;
use App\Permiso;
use App\User;
use Illuminate\Http\Request;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;

class EmailConfiguracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_usuario=auth()->user()->id;
        $user=User::where('id',$id_usuario)->first();
        $config_email=EmailConfiguraciones::where('id_usuario',$id_usuario)->get();
        return view('mailbox.configuracion.index',compact('config_email','user'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'email' => ['required','email','unique:email_configuraciones,email'],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);

        $correo = $request->get('email');
        // firna para outlook
        if($request->hasfile('firma')){
            $image1 =$request->file('firma');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firmas/');
            $image1->move($destinationPath,$name);
        }else{
            $name="";
        }

        $ancho=$request->get('ancho_firma');
        $alto =$request->get('alto_firma');

        if( $ancho == "" || $alto  == ""){
            $ancho = '150';
            $alto = '100';

        }

        if($request->hasfile('firma_digital')){
            $image2 =$request->file('firma_digital');
            $firma_d=time().$image2->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firma_digital/');
            $image2->move($destinationPath,$firma_d);
        }else{
            $firma_d="";
        }

        $id_usuario=auth()->user()->id;
        $configmail = new EmailConfiguraciones;
        $configmail->id_usuario =auth()->user()->id;
        $configmail->email =$correo ;
        $configmail->password = $request->get('password') ;
        $configmail->email_backup = 'desarrollo@jypsac.com';
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->firma = $name;
        $configmail->ancho_firma= $ancho;
        $configmail->alto_firma= $alto;
        $configmail->encryption= $request->get('encryp') ;
        $configmail->firma_digital = $firma_d;
        $configmail-> save();

        $user=User::find($id_usuario);
        $user->email_creado='1';
        $user->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmailConfiguraciones  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailConfiguraciones  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    public function email_backup()
    {
        $config = EmailConfiguraciones::get('email_backup')->first();
        return view('mailbox.edit',compact('config'));
    }
    public function backup_save(Request $request){
        $newvar = $request->get('backup');
        $mails = EmailConfiguraciones::get();
        foreach ($mails as $mail) {
            $mail_id = $mail->id;
            $mail_upd =EmailConfiguraciones::find($mail_id);
            $mail_upd->email_backup= $newvar;
            $mail_upd->save();
        }
        return back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmailConfiguraciones  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'email' => ['required','email','unique:email_configuraciones,email,'.$id],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);


        $correo = $request->get('email');
         if($request->hasfile('firma')){
            $image1 =$request->file('firma');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firmas/');
            $image1->move($destinationPath,$name);
        }else{
            $name=$request->get('firma_nombre') ;
        }
        $ancho=$request->get('ancho_firma');
        $alto =$request->get('alto_firma');

        if($request->hasfile('firma_digital')){
            $image2 =$request->file('firma_digital');
            $firma_digital =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firmas_digitales/');
            $image2->move($destinationPath,$firma_digital);
        }else{
            $firma_digital=$request->file('firma_digital');;
        }

        // }
        $configmail=EmailConfiguraciones::find($id);
        $configmail->email = $correo ;
        $configmail->password = $request->get('password') ;
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->encryption= $request->get('encryp') ;
        $configmail->firma = $name;
        $configmail->ancho_firma= $ancho;
        $configmail->alto_firma= $alto;
        $configmail->firma_digital = $firma_digital;
        $configmail->save();
        return redirect()->route('configuracion_email.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailConfiguraciones  $EmailConfiguraciones
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //
    }
}
