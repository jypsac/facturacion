<?php

namespace App\Http\Controllers;

use App\Config_fe;
use App\config_acceso_sunat;

use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro; 
use App\Guia_remision;
use App\Codigo_guia_almacen;
use App\Almacen;

use App\g_remision_registro;
use App\Nota_Credito;
use App\Nota_Credito_registro;
use DateTime;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturacionElectronicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $facturacion=Facturacion::where('f_electronica',0)->get();
        return view('facturacion_electronica.factura.index',compact('facturacion'));
    }

    public function index_boleta(){

        $boletas=Boleta::where('b_electronica',0)->get();
        return view('facturacion_electronica.boleta.index',compact('boletas'));
    }

    public function index_guia_remision(){

        $guia_remisiones=Guia_remision::where('g_electronica',0)->where('estado_anulado',0)->get();
        $guia_remision_anulado=Guia_remision::where('g_electronica',1)->where('estado_anulado',1)->get();
        $guia_remision_enviados=Guia_remision::where('g_electronica',1)->where('estado_anulado',0)->get();
        return view('facturacion_electronica.guia_remision.index',compact('guia_remisiones','guia_remision_enviados','guia_remision_anulado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function factura(Request $request)
    {
        //facturas a buscar
        $factura=Facturacion::where('f_electronica',0)->where('id',$request->factura_id)->first();
        $factura_registro=Facturacion_registro::where('facturacion_id',$request->factura_id)->get();

        if($factura->guia_remision=="0"){
            $guia=0;
        }else{
            $guia=1;
        }
        
        //configuracion de conexion
        $see=config_acceso_sunat::facturacion_electronica();

        if($factura->tipo=="producto"){
            //factura
            $invoice=Config_fe::factura($factura, $factura_registro,$guia);
            
        }elseif($factura->tipo=="servicio"){
            //factura
            $invoice=Config_fe::factura_servicio($factura, $factura_registro,$guia);
            
        }
        
        //envio a SUNAT    
        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de factura electronica - en caso sea todo exitoso
        $factura->f_electronica=1;
        $factura->save();

        return redirect()->route('facturacion_electronica.index')->with('successMsg',$msg);
    }

    
    public function boleta(Request $request)
    {
        //boletas a buscar
        $boleta=Boleta::where('b_electronica',0)->where('id',$request->factura_id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$request->factura_id)->get();
        
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

        //boleta
        
        if($boleta->tipo=="producto"){
            //boleta
            
            $invoice=Config_fe::boleta($boleta, $boleta_registro);
            
        }elseif($boleta->tipo=="servicio"){
            //boleta
            
            $invoice=Config_fe::boleta_servicio($boleta, $boleta_registro);
            
        }
        
        //envio a SUNAT    
        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de boleta electronica - en caso sea todo exitoso
        $boleta->b_electronica=1;
        $boleta->save();

        return redirect()->route('facturacion_electronica.index_boleta')->with('successMsg',$msg);
    }


    public function guia_remision(Request $request)
    {   
        $guia=Guia_remision::where('g_electronica',0)->where('id',$request->factura_id)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$request->factura_id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acceso_sunat::guia_electronica();

        //guia
        $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);
        
        //envio a SUNAT    
        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();

        return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);

    }

    public function guia_remision_baja(Request $request)
    {   

        $guia=Guia_remision::where('g_electronica',1)->where('id',$request->factura_id)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$request->factura_id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acceso_sunat::guia_electronica();

        //guia
        $invoice=Config_fe::guia_remision_baja($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);
        
        //envio a SUNAT    
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
        // return $msg;


        //cambio de guia electronica - en caso sea exitodo
        $guia->estado_anulado=1;
        $guia->save();

        return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);

    }

    public function nota_credito(Request $request, $id)
    {   
        //contador nota de creditos
        $notas_creditos_count=Nota_Credito_registro::count();
        $notas_creditos_count++;
        $factura=Facturacion::where('id',$id)->first();
        $factura_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        $gravada_s=0;
        $exonerada_s=0;
        $inafecta_s=0;

        // code nota_c
        // obtencion de la sucursal
        $almacen=$factura->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_credito=$sucursal->cod_nota_credito;
        if (is_numeric($nota_cod_n_credito)) {
            // exprecion del numero de la nota de credito
            $nota_cod_n_credito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_credito, 2, "0", STR_PAD_LEFT);
            $nota_credito_nr=str_pad($nota_cod_n_credito, 8, "0", STR_PAD_LEFT);
        }else{
                // exprecion del numero de Nota de credito
                // GENERACION DE NUMERO DE Nota de credito
                $ultima_nota_c=Nota_Credito::where('almacen_id',$almacen_id->id)->latest()->first();
                $nota_credito_num=$ultima_nota_c->codigo_n_c;
                $nota_credito_num_string_porcion= explode("-", $nota_credito_num);
                $nota_credito_num_string=$nota_credito_num_string_porcion[1];
                $nota_credito_num=(int)$nota_credito_num_string;
                
                $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_credito','DESC')->latest()->first();
                if($nota_credito_num == 99999999){
                    $ultima_nota_c = $almacen_codigo->serie_nota_credito+1;
                    $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                    $almacen_save_last->serie_nota_credito = $almacen_codigo->serie_nota_credito+1;
                    $almacen_save_last->save();
                    $nota_credito_num = 00000000;
                }else{
                    $ultima_nota_c = $sucursal->serie_nota_credito;
                }
                $nota_credito_num++;
                $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
                $nota_credito_nr=str_pad($nota_credito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_credito_numero="FF".$sucursal_nr."-".$nota_credito_nr;


        if($factura->tipo=="producto"){

            $contadores=count($factura_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{
                    if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $gravada += round($factura_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $exonerada += round($factura_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $inafecta += round($factura_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                }
            }

            
             $invoice=Config_fe::nota_credito($factura,$factura_registro,$request,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            $nota_credito=new Nota_Credito();
            $nota_credito->codigo_n_c=$nota_credito_numero;
            $nota_credito->facturacion_id=$factura->id;
            $nota_credito->tipo="producto";
            $nota_credito->almacen_id=$factura->almacen_id;
            $nota_credito->motivo=$request->motivo;
            $nota_credito->op_gravada=$gravada;
            $nota_credito->op_inafecta=$inafecta;
            $nota_credito->op_exonerada=$exonerada;
            $nota_credito->save();

            $contador=count($factura_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{
                    $nota_creditos_r=new Nota_Credito_registro();
                    $nota_creditos_r->nota_credito_id=$nota_credito->id;
                    $nota_creditos_r->producto_id=$factura_registro[$p]->producto_id;
                    $nota_creditos_r->precio=$factura_registro[$p]->precio;
                    $nota_creditos_r->cantidad=$request->$nombre;
                    $nota_creditos_r->save();
                }
            }

        }else if($factura->tipo=="servicio"){

            $contadores=count($factura_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{

                    if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $gravada_s += round($factura_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $exonerada_s += round($factura_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $inafecta_s += round($factura_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                }
            }
            
            $invoice=Config_fe::nota_credito_servicio($factura,$factura_registro,$request,$notas_creditos_count,$nota_credito_numero,$gravada_s,$exonerada_s,$inafecta_s,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
            
            
            $nota_credito=new Nota_Credito();
            $nota_credito->codigo_n_c=$nota_credito_numero;
            $nota_credito->facturacion_id=$factura->id;
            $nota_credito->tipo="servicio";
            $nota_credito->almacen_id=$factura->almacen_id;
            $nota_credito->motivo=$request->motivo;
            $nota_credito->op_gravada=$gravada;
            $nota_credito->op_inafecta=$inafecta;
            $nota_credito->op_exonerada=$exonerada;
            $nota_credito->save();

            $contador=count($factura_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{
                    $nota_creditos_r=new Nota_Credito_registro();
                    $nota_creditos_r->nota_credito_id=$nota_credito->id;
                    $nota_creditos_r->servicio_id=$factura_registro[$p]->servicio_id;
                    $nota_creditos_r->precio=$factura_registro[$p]->precio;
                    $nota_creditos_r->cantidad=$request->$nombre;
                    $nota_creditos_r->save();
                }
            }
        }

        // modificacion para que se cierre el codigo en almacen
        $nc_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nc_primera->cod_nota_credito)){
            $nc_primera->cod_nota_credito='NN';
            $nc_primera->save();
        }

        return redirect()->route('nota-credito.show',$nota_credito->id);

    }

    public function nota_credito_boleta(Request $request, $id)
    {   
        //contador nota de creditos
        $notas_creditos_count=Nota_Credito_registro::count();
        $notas_creditos_count++;
        $boleta=Boleta::where('id',$id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        $gravada_s=0;
        $exonerada_s=0;
        $inafecta_s=0;


        // code nota_c
        // obtencion de la sucursal
        $almacen=$factura->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_credito=$sucursal->cod_nota_credito;
        if (is_numeric($nota_cod_n_credito)) {
            // exprecion del numero de la nota de credito
            $nota_cod_n_credito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_credito, 2, "0", STR_PAD_LEFT);
            $nota_credito_nr=str_pad($nota_cod_n_credito, 8, "0", STR_PAD_LEFT);
        }else{
                // exprecion del numero de Nota de credito
                // GENERACION DE NUMERO DE Nota de credito
                $ultima_nota_c=Nota_Credito::where('almacen_id',$almacen_id->id)->latest()->first();
                $nota_credito_num=$ultima_nota_c->codigo_n_c;
                $nota_credito_num_string_porcion= explode("-", $nota_credito_num);
                $nota_credito_num_string=$nota_credito_num_string_porcion[1];
                $nota_credito_num=(int)$nota_credito_num_string;
                
                $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_credito','DESC')->latest()->first();
                if($nota_credito_num == 99999999){
                    $ultima_nota_c = $almacen_codigo->serie_nota_credito+1;
                    $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                    $almacen_save_last->serie_nota_credito = $almacen_codigo->serie_nota_credito+1;
                    $almacen_save_last->save();
                    $nota_credito_num = 00000000;
                }else{
                    $ultima_nota_c = $sucursal->serie_nota_credito;
                }
                $nota_credito_num++;
                $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
                $nota_credito_nr=str_pad($nota_credito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_credito_numero="BB".$sucursal_nr."-".$nota_credito_nr;

        

        if($boleta->tipo=="producto"){

            $contadores=count($boleta_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $gravada += round($boleta_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $exonerada += round($boleta_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $inafecta += round($boleta_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                }
            }


            $nota_credito=new Nota_Credito();
            $nota_credito->codigo_n_c=$nota_credito_numero;
            $nota_credito->boleta_id=$boleta->id;
            $nota_credito->tipo="producto";
            $nota_credito->almacen_id=$boleta->almacen_id;
            $nota_credito->motivo=$request->motivo;
            $nota_credito->op_gravada=$gravada;
            $nota_credito->op_inafecta=$inafecta;
            $nota_credito->op_exonerada=$exonerada;
            $nota_credito->save();
            
            $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$request,$notas_creditos_count,$nota_credito_numero,$gravada_s,$exonerada_s,$inafecta_s,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            $contador=count($boleta_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{
                    $nota_creditos_r=new Nota_Credito_registro();
                    $nota_creditos_r->nota_credito_id=$nota_credito->id;
                    $nota_creditos_r->producto_id=$boleta_registro[$p]->producto_id;
                    $nota_creditos_r->precio=$boleta_registro[$p]->precio;
                    $nota_creditos_r->cantidad=$request->$nombre;
                    $nota_creditos_r->save();
                }
            }

        }else if($boleta->tipo=="servicio"){

            $contadores=count($boleta_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{

                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $gravada_s += round($boleta_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $exonerada_s += round($boleta_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $inafecta_s += round($boleta_registro[$a]->precio_unitario_comi*$request->$nombre,2);
                    }
                }
            }


            $nota_credito=new Nota_Credito();
            $nota_credito->codigo_n_c=$nota_credito_numero;
            $nota_credito->boleta_id=$boleta->id;
            $nota_credito->tipo="servicio";
            $nota_credito->almacen_id=$boleta->almacen_id;
            $nota_credito->motivo=$request->motivo;
            $nota_credito->op_gravada=$gravada;
            $nota_credito->op_inafecta=$inafecta;
            $nota_credito->op_exonerada=$exonerada;
            $nota_credito->save();
            
            $invoice=Config_fe::nota_credito_boleta_servicio($boleta,$boleta_registro,$request,$notas_creditos_count,$nota_credito_numero,$gravada_s,$exonerada_s,$inafecta_s,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            $contador=count($boleta_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                if($request->$nombre==NULL){
                }else{
                    $nota_creditos_r=new Nota_Credito_registro();
                    $nota_creditos_r->nota_credito_id=$nota_credito->id;
                    $nota_creditos_r->servicio_id=$boleta_registro[$p]->servicio_id;
                    $nota_creditos_r->precio=$boleta_registro[$p]->precio;
                    $nota_creditos_r->cantidad=$request->$nombre;
                    $nota_creditos_r->save();
                }
            }
        }

        // modificacion para que se cierre el codigo en almacen
        $nc_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nc_primera->cod_nota_credito)){
            $nc_primera->cod_nota_credito='NN';
            $nc_primera->save();
        }

        return redirect()->route('nota-credito.show',$nota_credito->id);
    }

    /**
     * 


     
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
