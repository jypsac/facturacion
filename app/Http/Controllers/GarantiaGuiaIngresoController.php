<?php

namespace App\Http\Controllers;

use App\GarantiaGuiaIngreso;
use App\Marca;
use App\Cliente;
use App\Empresa;
use App\Personal_datos_laborales;
use App\Personal;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GarantiaGuiaIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas=Marca::all();
        $garantias_guias_ingresos=GarantiaGuiaIngreso::all();
        return view('transaccion.garantias.guia_ingreso.index',compact('marcas','garantias_guias_ingresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tiempo_actual = Carbon::now();
        $tiempo_actual = $tiempo_actual->format('Y-m-d');

        $name = $request->input('familia');
        $marca = Marca::where("id","=",$name)->first();
        $marca_nombre=(string)$marca->nombre;
        $marca=(string)$marca->abreviatura;
        $guion='-';
        $marca_cantidad= GarantiaGuiaIngreso::where("marca_id","=",$name)->count();
        $marca_cantidad++;
        $contador=1000000;
        $marca_cantidad=$contador+$marca_cantidad;
        $marca_cantidad=(string)$marca_cantidad;
        $marca_cantidad=substr($marca_cantidad,1);
        $orden_servicio=$marca.$guion.$marca_cantidad;

        $clientes=Cliente::all();
        // $personales=Personal_datos_laborales::where("cargo","=","ingeniero")->get();
        // $personales=Personal::join("personal_datos_laborales","id","=","personal_datos_laborales.personal_id")->get();
        $personales=DB::table('personal_datos_laborales')->where("cargo","=","ingeniero")->join("personal","personal.id","=","personal_datos_laborales.personal_id")->get();

        //llamar la abreviartura deacuerdo con el nombre del name separarlo por coma en el imput
        return view('transaccion.garantias.guia_ingreso.create',compact('name','marca','orden_servicio','tiempo_actual','clientes','marca_nombre','personales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $nombre_cliente=$request->get('nombre_cliente');
        // $cliente= Cliente::where("nombre","=",$nombre_cliente)->first();
        // $numero_doc=$cliente->numero_documento;

        //TRAANSFORMNADO CON VALUE DE MARCA A UN ID
        $marca_nombre=$request->get('marca_id');
        $marca= Marca::where("nombre","=",$marca_nombre)->first();
        $marca_id_var=$marca->id;

        $garantia_guia_ingreso=new GarantiaGuiaIngreso;
        $garantia_guia_ingreso->motivo=$request->get('motivo');
        $garantia_guia_ingreso->fecha=$request->get('fecha');
        $garantia_guia_ingreso->orden_servicio=$request->get('orden_servicio');
        $garantia_guia_ingreso->estado=1;
        $garantia_guia_ingreso->egresado=0;
        $garantia_guia_ingreso->asunto=$request->get('asunto');
        $garantia_guia_ingreso->nombre_equipo=$request->get('nombre_equipo');
        $garantia_guia_ingreso->numero_serie=$request->get('numero_serie');
        $garantia_guia_ingreso->codigo_interno=$request->get('codigo_interno');
        $garantia_guia_ingreso->fecha_compra=$request->get('fecha_compra');
        $garantia_guia_ingreso->descripcion_problema=$request->get('descripcion_problema');
        $garantia_guia_ingreso->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_guia_ingreso->estetica=$request->get('estetica');

        $garantia_guia_ingreso->marca_id=$marca_id_var;

        $garantia_guia_ingreso->personal_lab_id=$request->get('personal_lab_id');
        $garantia_guia_ingreso->cliente_id=$request->get('cliente_id');
        // $garantia_guia_ingreso->contacto_id=$request->get('cliente_id');

        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_ingreso.index');




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
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        return view('transaccion.garantias.guia_ingreso.show',compact('garantia_guia_ingreso','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        $clientes=Cliente::all();
        return view('transaccion.garantias.guia_ingreso.edit',compact('garantia_guia_ingreso','clientes'));
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
        // ACTUALIZACION DE ESTADO
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->estado=0;
        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_ingreso.index');
    }

    public function actualizar(Request $request, $id)
    {
        $nombre_cliente=$request->get('nombre_cliente');
        $cliente= Cliente::where("nombre","=",$nombre_cliente)->first();
        $numero_doc=$cliente->numero_documento;

        // ACTUALIZACION DE GUIA DE INGRESO
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->marca=$request->get('marca');
        $garantia_guia_ingreso->motivo=$request->get('motivo');
        $garantia_guia_ingreso->ing_asignado=$request->get('ing_asignado');
        $garantia_guia_ingreso->fecha=$request->get('fecha');
        $garantia_guia_ingreso->orden_servicio=$request->get('orden_servicio');
        $garantia_guia_ingreso->estado=1;
        $garantia_guia_ingreso->egresado=0;
        $garantia_guia_ingreso->asunto=$request->get('asunto');
        $garantia_guia_ingreso->nombre_cliente=$request->get('nombre_cliente');
        $garantia_guia_ingreso->direccion=$request->get('direccion');
        $garantia_guia_ingreso->telefono=$request->get('telefono');
        $garantia_guia_ingreso->telefono=$request->get('telefono');
        $garantia_guia_ingreso->numero_documento=$numero_doc;
        $garantia_guia_ingreso->contacto=$request->get('contacto');
        $garantia_guia_ingreso->nombre_equipo=$request->get('nombre_equipo');
        $garantia_guia_ingreso->numero_serie=$request->get('numero_serie');
        $garantia_guia_ingreso->codigo_interno=$request->get('codigo_interno');
        $garantia_guia_ingreso->fecha_compra=$request->get('fecha_compra');
        $garantia_guia_ingreso->descripcion_problema=$request->get('descripcion_problema');
        $garantia_guia_ingreso->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_guia_ingreso->estetica=$request->get('estetica');
        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_ingreso.index');
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
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','empresa'));
    } 
}
