<?php

namespace App\Http\Controllers;

use App;
use App\CreateMail;
use App\Mailbox;
use Illuminate\Http\Request;
class CreateMailController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $mailbox =Mailbox::all();
       return view('mailbox.index',compact('mailbox'));
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('mailbox.create');
 }
  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
    $id_usuario=auth()->user()->id;
    $correo_busqueda=CreateMail::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    $mail = new Mailbox;
    $mail->id_usuario =auth()->user()->id;
    $mail->destinatario =$correo;
    $mail->remitente =$request->get('remitente') ;
    $mail->asunto =$request->get('asunto') ;
    $mail->mensaje =$request->get('mensaje') ;
    $mail->archivo =$request->get('archivo') ;
    $mail->pdf =$request->get('pdf') ;
    $mail->fecha_hora =$request->get('fecha_hora') ;
    $mail-> save();

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente') ;
        $titulo = $request->get('asunto');
        $mensaje = $request->get('mensaje');

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivo');
        if($request->hasfile('archivo')){
            foreach ($newfile as $file) {
                $nombre =  $file->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($file));

                $news[] = storage_path().'/app/public/'.$nombre;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
                foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        }else{
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');

        }
        if($mailer->send($message)){
            return redirect()->route('email.index');
        }
        return "Something went wrong :(";
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $mail=Mailbox::find($id);
        return view('mailbox.show',compact('mail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
