<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use Barryvdh\DomPDF\Facade as PDF;
use App\Marca;
use App\Empresa;
use App\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
use Auth;

class GarantiaGuiaEgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::all();
        return view('transaccion.garantias.guia_egreso.index',compact('garantias_guias_egresos'));
    }

    public function guias()
    {
        $marcas=Marca::all();
        $garantias_guias_ingresos=GarantiaGuiaIngreso::all();
        return view('transaccion.garantias.guia_egreso.ingresos',compact('marcas','garantias_guias_ingresos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $nombre_cliente=$request->get('nombre_cliente');
        $cliente= Cliente::where("nombre","=",$nombre_cliente)->first();
        $numero_doc=$cliente->numero_documento;

        $orden_servicio=$request->get('orden_servicio');
        $orden_servicio=(string)$orden_servicio;

        // //GUIA INGRESO
        $garantia_guia_ingreso=GarantiaGuiaIngreso::where('orden_servicio',$orden_servicio)->first();
        $garantia_guia_ingreso->egresado=1;
        $garantia_guia_ingreso->estado=0;
        $garantia_guia_ingreso->save();


        //consulta
        $id_garantia_ingreso=$garantia_guia_ingreso->id;
        //GUIA EGRESO
        $garantia_guia_egreso=new GarantiaGuiaEgreso;

        $garantia_guia_egreso->garantia_ingreso_id=$id_garantia_ingreso;
        $garantia_guia_egreso->estado=1;
        $garantia_guia_egreso->egresado=1;
        $garantia_guia_egreso->informe_tecnico=0;
        $garantia_guia_egreso->orden_servicio=$request->get('orden_servicio');
        $garantia_guia_egreso->fecha=$request->get('fecha_uno');
        $garantia_guia_egreso->descripcion_problema=$request->get('descripcion_problema');
        $garantia_guia_egreso->diagnostico_solucion=$request->get('diagnostico_solucion');
        $garantia_guia_egreso->recomendaciones=$request->get('recomendaciones');
        $garantia_guia_egreso->save();

        return redirect()->route('garantia_guia_egreso.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        return view('transaccion.garantias.guia_egreso.show',compact('garantias_guias_egreso','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tiempo_actual = Carbon::now();
        $tiempo_actual = $tiempo_actual->format('Y-m-d');
        // Enviando vista para crear guia de egreso con datos de ingreso para egresar
        $garantias_guias_ingresos=GarantiaGuiaIngreso::find($id);
        return view('transaccion.garantias.guia_egreso.edit',compact('garantias_guias_ingresos','tiempo_actual'));
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

      public function print($id){
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        return view('transaccion.garantias.guia_egreso.show_print',compact('garantias_guias_egreso','mi_empresa'));
    }

    public function pdf(Request $request,$id){
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        $archivo=$request->get('archivo');

        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome');
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa'));
    //     return $pdf->download();
        return $pdf->download('Guia Egreso - '.$archivo.' .pdf');
    }
    function email($id){
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        // return view('transaccion.garantias.guia_egreso.show_print',compact('garantia_guia_egreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
        $archivo=$id.".pdf";
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa'));
        $content=$pdf->download();
        Storage::disk('garantias_guias_egreso')->put($archivo,$content);

        return view('transaccion.garantias.guia_egreso.correo',compact('id'));
    } 

    public function enviar(Request $request){
       $smtpAddress = 'smtp.gmail.com'; // = $request->smtp
        $port = 465;
        $encryption = 'ssl';
        $yourEmail = 'danielrberru@gmail.com'; // = $request->yourmail
        $yourPassword = 'digimonheroes@1'; //colocar el password, 


        //Envio del mail al corre 
        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $sendto = $request->sendto;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;
        $file = $request->id;

        $pdfile = storage_path().'/app/public/guia_egreso/'.$file.'.pdf';

        $newfile = $request->file('archivo');

        if($request->hasfile('archivo')){
            foreach ($newfile as $dofile) {
                $nombre =  $dofile->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($dofile));
                $news[] = storage_path().'/app/public/'.$nombre;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
                 foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        }else{
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));

        }

        if($mailer->send($message)){
           return redirect()->route('garantia_guia_egreso.index');  
        }   
           return "Something went wrong :(";
            
            
         
    }

}
