<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaInformeTecnico;
use App\GarantiaGuiaEgreso;
use Barryvdh\DomPDF\Facade as PDF;
use App\Cliente;
use App\User;
use App\Contacto;
use App\Empresa;
use App\GarantiaInformeTecnicoArchivos;
use Carbon\Carbon;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class GarantiaInformeTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garantias_informe_tecnicos=GarantiaInformeTecnico::all();
        return view('transaccion.garantias.informe_tecnico.index',compact('garantias_informe_tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_tecnico($id)
    {
     $empresa = Empresa::first();
     $garantia_guia_egreso=GarantiaGuiaEgreso::find($id);
     return view('transaccion.garantias.informe_tecnico.create_tecnico',compact('garantia_guia_egreso','empresa','id'));
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_egreso=$request->get('id_egreso');
        //consulta
        $egreso=GarantiaGuiaEgreso::where('id',$id_egreso)->first();
        if (empty($egreso)){return redirect()->route('garantia_informe_tecnico.guias')->withErrors(['Numero de Guia no existe en Registro.']);}
        if ($egreso->informe_tecnico==1){return redirect()->route('garantia_informe_tecnico.guias')->withErrors(['Numero de Guia Ya fue Registrada en Informe Tecnico.']);}
        // return $egreso->informe_tecnico;

        $garantia_informe_tecnico= new GarantiaInformeTecnico;
        $garantia_informe_tecnico->garantia_egreso_id=$egreso->id;
        $garantia_informe_tecnico->orden_servicio=$egreso->orden_servicio;
        $garantia_informe_tecnico->estado=1;
        $garantia_informe_tecnico->egresado=0;
        $garantia_informe_tecnico->informe_tecnico=0;
        $garantia_informe_tecnico->fecha=date('Y-m-d');
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->save();

         // //GUIA EGRESO
        $garantia_guia_egreso=GarantiaGuiaEgreso::find($id_egreso);
        $garantia_guia_egreso->informe_tecnico=1;
        $garantia_guia_egreso->save();

        /*new*/
        $newfile = $request->file('files');
        if($request->hasfile('files')){
            $orden_servicio=$request->get('orden_servicio');
            // $date = Carbon::now();
            // $hora = $date->toTimeString();
            foreach ($newfile as $file) {
                $nombre =  $orden_servicio.'_'.$file->getClientOriginalName();
                \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($file));
                // $news[] = public_path().'/app/public/'.$nombre;
            }
            foreach ($newfile as $files) {
                $archivo_tecnico = new GarantiaInformeTecnicoArchivos;
                $archivo_tecnico->id_informe_tecnico = $garantia_informe_tecnico->id;
                $archivo_tecnico->archivos = $orden_servicio.'_'.$files->getClientOriginalName();
                $archivo_tecnico->save();
            }
        }
        /* /
        new*/
      return redirect()->route('garantia_informe_tecnico.show',$garantia_informe_tecnico->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contacto = Contacto::all();
        $empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        $usuario = User::where('personal_id',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_lab_id)->first();
        return view('transaccion.garantias.informe_tecnico.show',compact('garantias_informe_tecnico','empresa','archivo_informe_tecnico','contacto','usuario'));
        // return $archivo_informe_tecnico;
    }
    public function update(Request $request, $id)
    {
        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->save();

        // $id_archivos_db = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->get();

        // $id_archivo = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->pluck('id');
        // $nombre_archivo = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->pluck('archivos');
        // $orden_servicio=$request->get('orden_servicio');

        // foreach ($id_archivo as $ids) {
        //     $nombre_orig = $request->get('original');
        //     if ($request->hasfile("nombre$ids")) {
        //         $archivo_input = $request->file("nombre$ids");
        //             //Eliminar
        //         $nombre =  $orden_servicio.'_'.$archivo_input->getClientOriginalName();
        //             //         \Storage::disk('informe_tecnico_imagenes')->delete($nombre_archivo);
        //             // Guardar base de datos
        //         $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::find($ids);
        //         $archivo_informe_tecnico->archivos = $nombre;
        //         $archivo_informe_tecnico->save();
        //             //Guardar en disk
        //         \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($archivo_input));
        //              // $archivo_storage = \Storage::disk('informe_tecnico_imagenes')->allFiles();
        //         $archivo_base = GarantiaInformeTecnicoArchivos::pluck('archivos');
        //             //ELIMINAR ARCHIVO (?)
        //             // foreach ($archivo_base as $base) {
        //             //     $original = $request->get('original');

        //             //      // foreach ($archivo_storage as $storage) {
        //             //         if( $base != $original  ){
        //             //             // $delete = $storage;
        //             //            \Storage::disk('informe_tecnico_imagenes')->delete($original);
        //             //             // return $delete;
        //             //         }else{
        //             //              // \Storage::disk('informe_tecnico_imagenes')->delete($delete);
        //             //              // return 'nohay';
        //             //         }
        //             //     // }

        //             // }
        //              //
        //     }

        // }
        // $newfile = $request->file('files');
        // if($request->hasfile('files')){
        //     $orden_servicio=$request->get('orden_servicio');
        //         // $date = Carbon::now();
        //         // $hora = $date->toTimeString();
        //     foreach ($newfile as $file) {
        //         $nombre =  $orden_servicio.'_'.$file->getClientOriginalName();
        //         \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($file));
        //             // $news[] = public_path().'/app/public/'.$nombre;
        //     }
        //     foreach ($newfile as $files) {
        //         $archivo_tecnico = new GarantiaInformeTecnicoArchivos;
        //         $archivo_tecnico->id_informe_tecnico = $id;
        //         $archivo_tecnico->archivos = $orden_servicio.'_'.$files->getClientOriginalName();
        //         $archivo_tecnico->save();
        //     }
        // }
      return redirect()->route('garantia_informe_tecnico.show',$garantia_informe_tecnico->id);
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

    public function guias()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::where('estado',1)->where('informe_tecnico',0)->get();
        return view('transaccion.garantias.informe_tecnico.guias',compact('garantias_guias_egresos'));
    }

    public function actualizar($id)
    {
        $contacto = Contacto::all();
        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        return view('transaccion.garantias.informe_tecnico.actualizar',compact('garantia_informe_tecnico','archivo_informe_tecnico','contacto'));
    }
    public function print($id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        $usuario = User::where('personal_id',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_lab_id)->first();
        return view('transaccion.garantias.informe_tecnico.show_print',compact('garantias_informe_tecnico','mi_empresa','archivo_informe_tecnico','contacto','usuario'));
    }

    public function pdf(Request $request,$id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        $archivo=$request->get('archivo');
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome');
        $pdf=PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf',compact('garantias_informe_tecnico','mi_empresa','archivo_informe_tecnico','contacto'));
    //     return $pdf->download();
        return $pdf->download('Guia Informe Tecnico - '.$archivo.' .pdf');

    }
    public function ticket_infome_tecnico(Request $request){
        $ids = $request->get('id');
        // $facturacion=Facturacion::find($ids);
        $garantia_informe_tecnico = GarantiaInformeTecnico::find($ids);
        $empresa=Empresa::first();

        $nombre_impresora = "EPSONTICKET";

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        #Mando un numero de respuesta para saber que se conecto correctamente.
        echo 1;

         //EMPRESA
        $empresa=Empresa::first();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text("GUIA DE INFORME TECNICO\n");
        $printer->text($garantia_informe_tecnico->garantia_egreso_i->orden_servicio."\n");
        $printer->text("===============================\n");
        $printer->text($garantia_informe_tecnico->garantia_egreso_i->created_at."\n");
        $printer->text($empresa->nombre."\n");
        $printer->setEmphasis(true);
        $printer->text("RUC: ".$empresa->ruc."\n");
        // $printer->setEmphasis(false);
        $printer->text($empresa->calle." - ".$empresa->ciudad." - ".$empresa->region_provincia."\n");
        $printer->text("Telefono: ".$empresa->telefono);
        $printer->setEmphasis(false);
        $printer->text("\n===============================\n");
        //CLIENTE
        $cliente_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Cliente", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre);
        $printer->text($cliente_dato."\n");
        $cliente_id= sprintf('%-15.20s %-2.2s %-21.21s', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion, ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento);
        $printer->text($cliente_id);
        $printer->text("\n===============================\n");
        //TRABAJADOR
        $trabajador_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Ing. Asignado", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres);
        $printer->text($trabajador_dato."\n");
        $motivo= sprintf('%-15.15s %-2.2s %-21.21s', "Motivo", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo);
        $printer->text($motivo."\n");
        $marca= sprintf('%-15.15s %-2.2s %-21.21s', "Marca", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre);
        $printer->text($marca."\n");
        $asunto= sprintf('%-15.15s %-2.2s %-21.21s', "Asunto", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto);
        $printer->text($asunto);
        $printer->text("\n===============================\n");
        //DATOS DEL EQUIPO
        $modelo= sprintf('%-15.15s %-2.2s %-21.21s', "Modelo", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo);
        $printer->text($modelo."\n");
        $n_serie= sprintf('%-15.15s %-2.2s %-21.21s', "Nro.  Serie", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie);
        $printer->text($n_serie."\n");
        $codigo_int= sprintf('%-15.15s %-2.2s %-21.21s', "Codigo Interno", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno);
        $printer->text($codigo_int."\n");
        $fecha_compra= sprintf('%-15.15s %-2.2s %-21.21s', "Fecha Compra", ':', $garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra);
        $printer->text($fecha_compra);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n===============================\n");


        $printer->feed(3);
        $printer->cut();
        $printer->pulse();
        $printer->close();
      }

}
