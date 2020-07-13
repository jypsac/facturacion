<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaInformeTecnico;
use App\GarantiaGuiaEgreso;
use Barryvdh\DomPDF\Facade as PDF;
use App\Cliente;
use App\Empresa;
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

        if($request->hasfile('image1')){
            $image1 =$request->file('image1');
            $orden_servicio=$request->get('orden_servicio');
            $name1 = $orden_servicio.'/'.time().$image1->getClientOriginalName();
            $image1->move(public_path().'/imagenes/'.$orden_servicio,$name1);
        }else{
            $name1="sin_foto";
        }

        if($request->hasfile('image2')){
            $image2 =$request->file('image2');
            $orden_servicio=$request->get('orden_servicio');
            $name2 = $orden_servicio.'/'.time().$image2->getClientOriginalName();
            $image2->move(public_path().'/imagenes/'.$orden_servicio,$name2);
        }else{
            $name2="sin_foto";
        }

        if($request->hasfile('image3')){
            $image3 =$request->file('image3');
            $orden_servicio=$request->get('orden_servicio');
            $name3 = $orden_servicio.'/'.time().$image3->getClientOriginalName();
            $image3->move(public_path().'/imagenes/'.$orden_servicio,$name3);
        }else{
            $name3="sin_foto";
        }

        if($request->hasfile('image4')){
            $image4 =$request->file('image4');
            $orden_servicio=$request->get('orden_servicio');
            $name4 = $orden_servicio.'/'.time().$image4->getClientOriginalName();
            $image4->move(public_path().'/imagenes/'.$orden_servicio,$name4);
        }else{
            $name4="sin_foto";
        }

        if($request->hasfile('image5')){
            $image5 =$request->file('image5');
            $orden_servicio=$request->get('orden_servicio');
            $name5 = $orden_servicio.'/'.time().$image5->getClientOriginalName();
            $image5->move(public_path().'/imagenes/'.$orden_servicio,$name5);
        }else{
            $name5="sin_foto";
        }

        if($request->hasfile('image6')){
            $image6 =$request->file('image6');
            $orden_servicio=$request->get('orden_servicio');
            $name6 = $orden_servicio.'/'.time().$image6->getClientOriginalName();
            $image6->move(public_path().'/imagenes/'.$orden_servicio,$name6);
        }else{
            $name6="sin_foto";
        }

        if($request->hasfile('image7')){
            $image7 =$request->file('image7');
            $orden_servicio=$request->get('orden_servicio');
            $name7 = $orden_servicio.'/'.time().$image7->getClientOriginalName();
            $image7->move(public_path().'/imagenes/'.$orden_servicio,$name7);
        }else{
            $name7="sin_foto";
        }

        if($request->hasfile('image8')){
            $image8 =$request->file('image8');
            $orden_servicio=$request->get('orden_servicio');
            $name8 = $orden_servicio.'/'.time().$image8->getClientOriginalName();
            $image8->move(public_path().'/imagenes/'.$orden_servicio,$name8);
        }else{
            $name8="sin_foto";
        }

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
        $garantia_informe_tecnico->image1=$name1;
        $garantia_informe_tecnico->image2=$name2;
        $garantia_informe_tecnico->image3=$name3;
        $garantia_informe_tecnico->image4=$name4;
        $garantia_informe_tecnico->image5=$name5;
        $garantia_informe_tecnico->image6=$name6;
        $garantia_informe_tecnico->image7=$name7;
        $garantia_informe_tecnico->image8=$name8;
        $garantia_informe_tecnico->save();

         // //GUIA EGRESO
        $garantia_guia_egreso=GarantiaGuiaEgreso::where('orden_servicio',$orden_servicio_egreso)->first();
        $garantia_guia_egreso->informe_tecnico=1;
        $garantia_guia_egreso->save();
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
        $empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        return view('transaccion.garantias.informe_tecnico.show',compact('garantias_informe_tecnico','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    $tiempo_actual = Carbon::now();
        $tiempo_actual = $tiempo_actual->format('Y-m-d');
        $garantia_guia_egreso=GarantiaGuiaEgreso::find($id);
        return view('transaccion.garantias.informe_tecnico.edit',compact('garantia_guia_egreso','tiempo_actual'));
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
        if($request->hasfile('image1')){
            $image1 =$request->file('image1');
            $orden_servicio=$request->get('orden_servicio');
            $name1 = $orden_servicio.'/'.time().$image1->getClientOriginalName();
            $image1->move(public_path().'/imagenes/'.$orden_servicio,$name1);
        }else{
            $name1="sin_foto";
        }

        if($request->hasfile('image2')){
            $image2 =$request->file('image2');
            $orden_servicio=$request->get('orden_servicio');
            $name2 = $orden_servicio.'/'.time().$image2->getClientOriginalName();
            $image2->move(public_path().'/imagenes/'.$orden_servicio,$name2);
        }else{
            $name2="sin_foto";
        }

        if($request->hasfile('image3')){
            $image3 =$request->file('image3');
            $orden_servicio=$request->get('orden_servicio');
            $name3 = $orden_servicio.'/'.time().$image3->getClientOriginalName();
            $image3->move(public_path().'/imagenes/'.$orden_servicio,$name3);
        }else{
            $name3="sin_foto";
        }

        if($request->hasfile('image4')){
            $image4 =$request->file('image4');
            $orden_servicio=$request->get('orden_servicio');
            $name4 = $orden_servicio.'/'.time().$image4->getClientOriginalName();
            $image4->move(public_path().'/imagenes/'.$orden_servicio,$name4);
        }else{
            $name4="sin_foto";
        }

        if($request->hasfile('image5')){
            $image5 =$request->file('image5');
            $orden_servicio=$request->get('orden_servicio');
            $name5 = $orden_servicio.'/'.time().$image5->getClientOriginalName();
            $image5->move(public_path().'/imagenes/'.$orden_servicio,$name5);
        }else{
            $name5="sin_foto";
        }

        if($request->hasfile('image6')){
            $image6 =$request->file('image6');
            $orden_servicio=$request->get('orden_servicio');
            $name6 = $orden_servicio.'/'.time().$image6->getClientOriginalName();
            $image6->move(public_path().'/imagenes/'.$orden_servicio,$name6);
        }else{
            $name6="sin_foto";
        }

        if($request->hasfile('image7')){
            $image7 =$request->file('image7');
            $orden_servicio=$request->get('orden_servicio');
            $name7 = $orden_servicio.'/'.time().$image7->getClientOriginalName();
            $image7->move(public_path().'/imagenes/'.$orden_servicio,$name7);
        }else{
            $name7="sin_foto";
        }

        if($request->hasfile('image8')){
            $image8 =$request->file('image8');
            $orden_servicio=$request->get('orden_servicio');
            $name8 = $orden_servicio.'/'.time().$image8->getClientOriginalName();
            $image8->move(public_path().'/imagenes/'.$orden_servicio,$name8);
        }else{
            $name8="sin_foto";
        }


        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->image1=$name1;
        $garantia_informe_tecnico->image2=$name2;
        $garantia_informe_tecnico->image3=$name3;
        $garantia_informe_tecnico->image4=$name4;
        $garantia_informe_tecnico->image5=$name5;
        $garantia_informe_tecnico->image6=$name6;
        $garantia_informe_tecnico->image7=$name7;
        $garantia_informe_tecnico->image8=$name8;
        $garantia_informe_tecnico->save();

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
        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        return view('transaccion.garantias.informe_tecnico.actualizar',compact('garantia_informe_tecnico'));
    }

    public function print($id){
        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        return view('transaccion.garantias.informe_tecnico.show_print',compact('garantias_informe_tecnico','mi_empresa'));
    }

    public function pdf(Request $request,$id){

        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo=$request->get('archivo');
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome');
        $pdf=PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf',compact('garantias_informe_tecnico','mi_empresa'));
    //     return $pdf->download();
        return $pdf->download('Guia Informe Tecnico - '.$archivo.' .pdf');

}


}
