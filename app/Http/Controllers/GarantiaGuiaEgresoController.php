<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\Marca;
use App\Cliente;

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
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        return view('transaccion.garantias.guia_egreso.show',compact('garantias_guias_egreso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Enviando vista para crear guia de egreso con datos de ingreso para egresar
        $garantias_guias_ingresos=GarantiaGuiaIngreso::find($id);
        return view('transaccion.garantias.guia_egreso.edit',compact('garantias_guias_ingresos'));
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
