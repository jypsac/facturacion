<?php

namespace App\Http\Controllers;

use App\Config_fe;
use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro; 
use App\Guia_remision;
use App\g_remision_registro;
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

        $guia_remisiones=Guia_remision::where('g_electronica',0)->get();
        return view('facturacion_electronica.guia_remision.index',compact('guia_remisiones'));
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
        
        //configuracion de conexion
        $see=Config_fe::facturacion_electronica();

        if($factura->tipo=="producto"){
            //factura
            $invoice=Config_fe::factura($factura, $factura_registro);
        }elseif($factura->tipo=="servicio"){
            //factura
            $invoice=Config_fe::factura_servicio($factura, $factura_registro);
        }
        
        //envio a SUNAT    
        $result=Config_fe::send($see, $invoice);

        //lectura CDR
        $msg=Config_fe::lectura_cdr($result->getCdrResponse());

        //cambio de factura electronica - en caso sea todo exitoso
        $factura->f_electronica=1;
        $factura->save();

        return $msg;
    }

    

    public function boleta(Request $request)
    {
        //boletas a buscar
        $boleta=Boleta::where('b_electronica',0)->where('id',$request->factura_id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$request->factura_id)->get();
        
        //configuracion
        $see=Config_fe::facturacion_electronica();

        //boleta
        $invoice=Config_fe::boleta($boleta, $boleta_registro);
        
        //envio a SUNAT    
        $result=Config_fe::send($see, $invoice);

        //lectura CDR
        $msg=Config_fe::lectura_cdr($result->getCdrResponse());

        //cambio de boleta electronica - en caso sea todo exitoso
        $boleta->b_electronica=1;
        $boleta->save();

        return $msg;
    }



    public function guia_remision(Request $request)
    {   
        $guia=Guia_remision::where('g_electronica',0)->where('id',$request->factura_id)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$request->factura_id)->get();

        // return $request;
        //configuracion
         $see=Config_fe::guia_electronica();

        //guia
        $invoice=Config_fe::guia_remision($guia,$guias_registros);
        
        //envio a SUNAT    
        $result=Config_fe::send($see, $invoice);

        //lectura CDR
        $msg=Config_fe::lectura_cdr($result->getCdrResponse());

        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();

        return $msg;
    }

    /**
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
