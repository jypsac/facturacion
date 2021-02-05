<?php

namespace App\Http\Controllers;

use App;
use App\Boleta_registro;
use App\Boleta;
use App\Cliente;
use App\Cotizacion;
use App\Contacto;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use App\Banco;
use App\Moneda;
use App\Facturacion;
use App\facturacion_registro;
use App\Cotizacion_Servicios;
use App\Cotizacion_factura_registro;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_Servicios_factura_registro;
use App\Cotizacion_Servicios_boleta_registro;
use App\kardex_entrada_registro;
use App\Guia_remision;
use App\g_remision_registro;
use App\Igv;
use App\GarantiaInformeTecnicoArchivos;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DB;
use App\Servicios;
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
      $mailbox =EmailBandejaEnvios::where('estado','0')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $mailbox_file =EmailBandejaEnviosArchivos::all();
      $config_email=EmailConfiguraciones::where('id_usuario',$id_usuario)->get();
      return view('mailbox.index',compact('mailbox','user','clientes','mailbox_file','config_email'));

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
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);

    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $firma=$correo_busqueda->firma;
    $mensaje_html = $request->get('mensaje');


    if($firma == null){
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
   .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
    table{
      width:100%;
    }
      </style>'.$mensaje_html.'</body>';
    }else{
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
   .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
    table{
      width:100%;
    }
      </style>'.$mensaje_html.'</body><br/><br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="150px" height="100px" /></footer>';
    }


    // return $mensaje_con_firma;
    $correo=$correo_busqueda->email;

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        $estado = '0';
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente')  ;
        $titulo = $request->get('asunto');
        $mensaje = $mensaje_con_firma;
        $bakcup=    $correo_busqueda->email_backup ;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivos');
        if($request->hasfile('archivos')){
          foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            $especif = $carbon_sp.$nombre;
            \Storage::disk('mailbox')->put( $especif ,  \File::get($file));

            $news[] = public_path().'/archivos/'.$especif;
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
          $mail->mensaje =$mensaje_con_firma;
          $mail->mensaje_sin_html =$texto ;
          $mail->estado = '0';
          $mail->fecha_hora =Carbon::now() ;
          $mail-> save();

          $newfile2 = $request->file('archivos');
          if($request->hasfile('archivos')){
            foreach ($newfile2 as $file2) {
              $guardar_email_archivo=new EmailBandejaEnviosArchivos;
              $guardar_email_archivo->id_bandeja_envios=$mail->id;
              $guardar_email_archivo->archivo= $file2->getClientOriginalName();
              $guardar_email_archivo->fecha_hora = $carbon_sp;
              $guardar_email_archivo->save();
            }
          }
          return redirect()->route('email.index');
        }
        return "Something went wrong :(";

      }

   function save(Request $request){
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);
    $tipo = $request->get('tipo');
    $id =$request->get('id');
    $redic=$request->get('redict');
    $clientes=$request->get('cliente');

   if($tipo == 'App\Cotizacion')
   {
    $rutapdf = 'transaccion.venta.cotizacion.pdf';
    $name = 'Cotizacion_Producto_';
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    /*registros boleta y factura*/
    if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif($regla=='boleta'){
        $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/
    foreach($cotizacion_registro as $cotizacion_registros){
        $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
        $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
        if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
    }
    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;
    $regla=$cotizacion->tipo;
    $cotizacion_factura = ' ';
     // return $cotizacion;
    $archivo=$name.$regla.$id.".pdf";
    $pdf=PDF::loadView($rutapdf,compact($redic,'cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count'));
    $content = $pdf->download();
    $especif = $carbon_sp.$archivo;
    Storage::disk('mailbox')->put($especif,$content);
    $date = $carbon_sp;

    return view('mailbox.create',compact('archivo','clientes','redic','date'));
   }
   else if ($tipo=='App\Cotizacion_Servicios')
   {
      $rutapdf = 'transaccion.venta.servicios.cotizacion.print';
      $name = 'Cotizacion_Servicio_';

      $banco=Banco::where('estado','0')->get();
      $banco_count=Banco::where('estado','0')->count();
      $moneda=Moneda::where('principal',1)->first();
      $cotizacion=Cotizacion_Servicios::find($id);
      $regla=$cotizacion->tipo;
      $sub_total=0;
      $igv=Igv::first();
      $empresa=Empresa::first();
      $sum=0;
      $i=1;
      $regla=$cotizacion->tipo;
      /*registros boleta y factura*/
          if($cotizacion->tipo=="factura"){
              //FACTURA
              $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
              foreach ($cotizacion_registro as $cotizacion_registros) {
                 $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
              }

          }else{
              //BOLETA
              $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
              foreach ($cotizacion_registro as $cotizacion_registros) {
                  $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
              }

          }
          $archivo=$name.$regla.$id.'.pdf';
          $regla=$cotizacion->tipo;

          $pdf=PDF::loadView('transaccion.venta.servicios.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','banco_count'));
           $content = $pdf->download();
           // $especif = $carbon_sp.$nombre;
      // \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
          $especif = $carbon_sp.$archivo;
          Storage::disk('mailbox')->put($especif,$content);
          $date = $carbon_sp;
          return view('mailbox.create',compact('archivo','clientes','redic','date'));
      }


   else if($tipo=='App\Guia_remision'){

      $banco_count=Banco::where('estado','0')->count();
      $guia_remision=Guia_remision::find($id);
      $guia_registro=g_remision_registro::where('guia_remision_id',$guia_remision->id)->get();
      $banco=Banco::where('estado','0')->get();
      $empresa=Empresa::first();
      $name = 'Guia_Remision';
      $archivo=$name.$id.".pdf";
      $pdf=PDF::loadView('transaccion.venta.guia_remision.pdf',compact('guia_remision','guia_registro','banco','empresa','banco_count'));
      $content = $pdf->download();
      $date = $carbon_sp;
      $especif = $carbon_sp.$archivo;
      Storage::disk('mailbox')->put($especif,$content);

      return view('mailbox.create',compact('archivo','clientes','redic','date'));
   }
   elseif ($tipo == 'App\Facturacion') {
        $name = 'Factura';
        $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $i = 1;

        $archivo=$name.'_'.$id.".pdf";
        $pdf=PDF::loadView('transaccion.venta.facturacion.pdf', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
        $content = $pdf->download();
        $date = $carbon_sp;
        $especif = $carbon_sp.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date'));
   }
   elseif ($tipo == 'App\Boleta') {
        $name = 'Boleta';
        $name = $request->get('name');
        // $regla=$cotizacion->tipo;
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::all();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();
        $sub_total=0;
        $boleta=Boleta::find($id);
        $i = 1;

        $archivo=$name.'_'.$id.".pdf";
        $pdf=PDF::loadView('transaccion.venta.boleta.pdf', compact('boleta','empresa','banco','boleta_registro','igv','sub_total','banco_count','i'));
        $content = $pdf->download();
        $date = $carbon_sp;
        $especif = $carbon_sp.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date'));
   }
   else
   {
        $mi_empresa=Empresa::first();
        if($tipo == 'App\GarantiaGuiaIngreso'){
          $rutapdf= 'transaccion.garantias.guia_ingreso.show_pdf';
          $garantia_guia_ingreso = $tipo::find($id);
          $name = 'Guia_Ingreso_';
        }
        elseif($tipo == 'App\GarantiaGuiaEgreso'){
          $rutapdf= 'transaccion.garantias.guia_egreso.show_pdf';
          $garantias_guias_egreso = $tipo::find($id);
          $name = 'Guia_Egreso_';
        }elseif($tipo == 'App\GarantiaInformeTecnico'){
          $rutapdf= 'transaccion.garantias.informe_tecnico.show_pdf';
          $garantias_informe_tecnico = $tipo::find($id);
          $name = 'Informe_Tecnico_';
          $contacto = Contacto::all();
          $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$garantias_informe_tecnico)->get();
          $archivo=$name.$id.".pdf";
          $pdf=PDF::loadView($rutapdf,compact($redic,'mi_empresa','contacto','archivo_informe_tecnico'));
          $content=$pdf->download();

          $especif = $carbon_sp.$archivo;
          Storage::disk('mailbox')->put($especif,$content);
          $date = $carbon_sp;
          return view('mailbox.create',compact('archivo','clientes','redic','date'));
        }
        $contacto = Contacto::all();
      $archivo=$name.$id.".pdf";
      $pdf=PDF::loadView($rutapdf,compact($redic,'mi_empresa','contacto'));
      $content=$pdf->download();

      $especif = $carbon_sp.$archivo;
      // $archivo=$especif;
      // \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
       Storage::disk('mailbox')->put($especif,$content);
       $date = $carbon_sp;
       return view('mailbox.create',compact('archivo','clientes','redic','date'));
    }
  }

  public function send(Request $request){
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);
    $dates = $request->get('dates');
    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    $firma=$correo_busqueda->firma;
    $mensaje_html = $request->get('mensaje');
    if($firma == null){
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
   .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
    table{
      width:100%;
    }
      </style>'.$mensaje_html.'</body>';
    }else{
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
   .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
    table{
      width:100%;
    }
      </style>'.$mensaje_html.'</body><br/><br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="150px" height="100px" /></footer>';
    }
    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        $estado = '0';
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente')  ;
        $titulo = $request->get('asunto');
        $mensaje = $mensaje_con_firma;
        $bakcup=    $correo_busqueda->email_backup ;

        // $file = $request->archivo;
        $pdf=$request->get('pdf');
        $carpet =$request->get('redict');
        $pdfile = public_path().'/archivos/'.$dates.$pdf;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivos');
        if($request->hasfile('archivos')){
          foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            $especif = $carbon_sp.$nombre;
            \Storage::disk('mailbox')->put( $especif ,  \File::get($file));

            $news[] = public_path().'/archivos/'.$especif;
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
          $mail->mensaje =$mensaje_con_firma;
          $mail->mensaje_sin_html =$texto ;
          $mail->estado= $estado;
          $mail->fecha_hora =Carbon::now() ;
          $mail-> save();

          $newfile2 = $request->file('archivos');
          if($request->hasfile('archivos')){
            foreach ($newfile2 as $file2) {
              $guardar_email_archivo=new EmailBandejaEnviosArchivos;
              $guardar_email_archivo->id_bandeja_envios=$mail->id;
              $guardar_email_archivo->archivo= $file2->getClientOriginalName();
              $guardar_email_archivo->fecha_hora= $carbon_sp;
              $guardar_email_archivo->save();
            }
          }
          $archivo_pdf = new EmailBandejaEnviosArchivos;
          $archivo_pdf->id_bandeja_envios=$mail->id;
          $archivo_pdf->archivo=$pdf;
          $archivo_pdf->fecha_hora= $dates;
          $archivo_pdf->save();

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
    public function delete(Request $request){
      $id = $request->get('id');
      $mail =EmailBandejaEnvios::find($id);
      $mail ->id_usuario=$mail->id_usuario;
      $mail->destinatario=$mail->destinatario;
      $mail->remitente=$mail->remitente;
      $mail->asunto =$mail->asunto;
      $mail->mensaje=$mail->mensaje;
      $mail->mensaje_sin_html=$mail->mensaje_sin_html;
      $mail->fecha_hora=$mail->fecha_hora;
      $mail->estado = '1';
      $mail->save();
      return back();
    }

    public function trash()
    {
      $id_usuario=auth()->user()->id;
      $user=User::where('id',$id_usuario)->first();
      $clientes=Cliente::all();
      $mailbox =EmailBandejaEnvios::where('estado','1')->where('id_usuario',$id_usuario)->OrderBy('updated_at','desc')->get();
      $count = count($mailbox);

      $mailbox_file =EmailBandejaEnviosArchivos::all();
      return view('mailbox.delete',compact('mailbox','user','clientes','mailbox_file','count'));

    }

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
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        // $archivos =EmailBandejaEnviosArchivos::findOrFail('id_bandeja_envios',$id)->get();
        // $archivos->delete();
        $email=EmailBandejaEnvios::findOrFail($id);
         $email->delete();


        return back() ;
    }
    public function configstore(Request $request){

      $this->validate($request,[
            'email' => ['required','email','unique:email_configuraciones,email'],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);

        $correo = $request->get('email');
        // $firma=$request->get('firma') ;
        if($request->hasfile('firma')){
            $image1 =$request->file('firma');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firmas/');
            $image1->move($destinationPath,$name);
        }else{
            $name="";
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
        $configmail->encryption= $request->get('encryp') ;
        $configmail-> save();

        $user=User::find($id_usuario);
        $user->email_creado='1';
        $user->save();
        return redirect()->route('email.index');
    }


    public function configupdate(Request $request,$id){
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
        $configmail=EmailConfiguraciones::find($id);
        $configmail->email = $correo ;
        $configmail->password = $request->get('password') ;
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->encryption= $request->get('encryp') ;
        $configmail->firma = $name;
        $configmail->save();
        return redirect()->route('email.index');
    }
}

