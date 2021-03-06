<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaInformeTecnico;
use App\GarantiaGuiaEgreso;
use Barryvdh\DomPDF\Facade as PDF;
use App\Cliente;
use App\Contacto;
use App\Empresa;
use App\GarantiaInformeTecnicoArchivos;
use Carbon\Carbon;


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

        //Informe tecnico Listo en Egresado
        $orden_servicio_egreso=$request->get('orden_servicio');
        $orden_servicio_egreso=(string)$orden_servicio_egreso;

        //consulta
        $egreso=GarantiaGuiaEgreso::where('orden_servicio',$orden_servicio_egreso)->first();
        $id_garantia_egreso=$egreso->id;

        $garantia_informe_tecnico= new GarantiaInformeTecnico;
        $garantia_informe_tecnico->garantia_egreso_id=$id_garantia_egreso;
        $garantia_informe_tecnico->orden_servicio=$request->get('orden_servicio');
        $garantia_informe_tecnico->estado=1;
        $garantia_informe_tecnico->egresado=1;
        $garantia_informe_tecnico->informe_tecnico=1;

        //$garantia_informe_tecnico->descripcion_problema=$request->get('descripcion_problema');
        $garantia_informe_tecnico->fecha=$request->get('fecha_uno');
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->save();

         // //GUIA EGRESO
        $garantia_guia_egreso=GarantiaGuiaEgreso::where('orden_servicio',$orden_servicio_egreso)->first();
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
        return redirect()->route('garantia_informe_tecnico.index');
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
        return view('transaccion.garantias.informe_tecnico.show',compact('garantias_informe_tecnico','empresa','archivo_informe_tecnico','contacto'));
        // return $archivo_informe_tecnico;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    $tiempo_actual = Carbon::now();
         $contacto = Contacto::all();
        $tiempo_actual = $tiempo_actual->format('Y-m-d');
        $garantia_guia_egreso=GarantiaGuiaEgreso::find($id);
        return view('transaccion.garantias.informe_tecnico.edit',compact('garantia_guia_egreso','tiempo_actual','contacto'));
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
        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->save();

            $id_archivos_db = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->get();

            $id_archivo = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->pluck('id');
            $nombre_archivo = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->pluck('archivos');
            $orden_servicio=$request->get('orden_servicio');

            foreach ($id_archivo as $ids) {
                $nombre_orig = $request->get('original');
                if ($request->hasfile("nombre$ids")) {
                    $archivo_input = $request->file("nombre$ids");
                    //Eliminar
                    $nombre =  $orden_servicio.'_'.$archivo_input->getClientOriginalName();
                    //         \Storage::disk('informe_tecnico_imagenes')->delete($nombre_archivo);
                    // Guardar base de datos
                    $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::find($ids);
                    $archivo_informe_tecnico->archivos = $nombre;
                    $archivo_informe_tecnico->save();
                    //Guardar en disk
                    \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($archivo_input));
                     // $archivo_storage = \Storage::disk('informe_tecnico_imagenes')->allFiles();
                     $archivo_base = GarantiaInformeTecnicoArchivos::pluck('archivos');
                    //ELIMINAR ARCHIVO (?)
                    // foreach ($archivo_base as $base) {
                    //     $original = $request->get('original');

                    //      // foreach ($archivo_storage as $storage) {
                    //         if( $base != $original  ){
                    //             // $delete = $storage;
                    //            \Storage::disk('informe_tecnico_imagenes')->delete($original);
                    //             // return $delete;
                    //         }else{
                    //              // \Storage::disk('informe_tecnico_imagenes')->delete($delete);
                    //              // return 'nohay';
                    //         }
                    //     // }

                    // }
                     //
                 }

            }
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
                    $archivo_tecnico->id_informe_tecnico = $id;
                    $archivo_tecnico->archivos = $orden_servicio.'_'.$files->getClientOriginalName();
                    $archivo_tecnico->save();
                }
            }
            return redirect()->route('garantia_informe_tecnico.index');

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
        $garantias_guias_egresos=GarantiaGuiaEgreso::all();
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
        return view('transaccion.garantias.informe_tecnico.show_print',compact('garantias_informe_tecnico','mi_empresa','archivo_informe_tecnico','contacto'));
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


}
