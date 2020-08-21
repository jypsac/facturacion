<?php

namespace App\Http\Controllers;

use App;
use App\Cliente;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use App\GarantiaGuiaIngreso;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class EmailBandejaEnviosController extends Controller
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
        $clientes=Cliente::all();
        $mailbox =EmailBandejaEnvios::all();
        $mailbox_file =EmailBandejaEnviosArchivos::all();
        return view('mailbox.index',compact('mailbox','user','clientes','mailbox_file'));

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
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente')  ;
        $titulo = $request->get('asunto');
        $mensaje = $request->get('mensaje');
        $bakcup=    $correo_busqueda->email_backup ;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivo');
        if($request->hasfile('archivo')){
            foreach ($newfile as $file) {
                $nombre =  $file->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($file));

                $news[] = storage_path().'/app/public/'.$nombre;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
                foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        }else{
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');

        }
        if($mailer->send($message)){
            $mensaje =$request->get('mensaje') ;
            $texto= strip_tags($mensaje);
            $mail = new EmailBandejaEnvios;
            $mail->id_usuario =auth()->user()->id;
            $mail->destinatario =$correo;
            $mail->remitente =$request->get('remitente') ;
            $mail->asunto =$request->get('asunto') ;
            $mail->mensaje =$request->get('mensaje') ;
            $mail->mensaje_sin_html =$texto ;
            $mail->fecha_hora =$request->get('fecha_hora') ;
            $mail-> save();

            return redirect()->route('email.index');
      }
      return "Something went wrong :(";

  }

  function save(Request $request){

    $tipo = $request->get('tipo');
    $id =$request->get('id');
    $redic=$request->get('redict');
    $clientes=$request->get('cliente');
     if($tipo = 'App\GarantiaGuiaIngreso'){
        $rutapdf= 'transaccion.garantias.guia_ingreso.show_pdf';
    }

      $mi_empresa=Empresa::first();
      $garantia_guia_ingreso = $tipo::find($id);
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
      $archivo="guia_ingreso".$id.".pdf";
      $pdf=PDF::loadView($rutapdf,compact($redic,'mi_empresa'));
      $content=$pdf->download();
      Storage::disk($redic)->put($archivo,$content);

      return view('mailbox.create',compact('archivo','clientes','redic'));
    }

    public function send(Request $request){

    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente')  ;
        $titulo = $request->get('asunto');
        $mensaje = $request->get('mensaje');
        $bakcup=    $correo_busqueda->email_backup ;

        $file = $request->archivo;
        $pdf=$request->get('pdf');
        $carpet =$request->get('redict');
        $pdfile = storage_path().'/app/public/'.$carpet.'/'.$pdf;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivo');
        if($request->hasfile('archivo')){
          foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            \Storage::disk('mailbox')->put($nombre,  \File::get($file));

            $news[] = storage_path().'/app/public/'.$nombre;
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));
            foreach ($news as $attachment) {
              $message->attach(\Swift_Attachment::fromPath($attachment));
            }
          }
        }else{
          $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');
          $message->attach(\Swift_Attachment::fromPath($pdfile));

        }
        if($mailer->send($message)){
          $mensaje =$request->get('mensaje') ;
            $texto= strip_tags($mensaje);
          $mail = new EmailBandejaEnvios;
          $mail->id_usuario =auth()->user()->id;
          $mail->destinatario =$correo;
          $mail->remitente =$request->get('remitente') ;
          $mail->asunto =$request->get('asunto') ;
          $mail->mensaje =$request->get('mensaje') ;
          $mail->mensaje_sin_html =$texto ;
          $mail->archivo =$request->get('archivo') ;
          $mail->pdf = $pdfile;
          $mail->fecha_hora =$request->get('fecha_hora') ;
          $mail-> save();

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

        $mail=EmailBandejaEnvios::find($id);
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

