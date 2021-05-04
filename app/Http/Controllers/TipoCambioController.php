<?php

namespace App\Http\Controllers;

use App\TipoCambio;
use App\Moneda;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoCambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();/*Consulta .sí se hizo hoy el cambio*/
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $tipo_cambio=TipoCambio::all();
        // $tipo_cambio=TipoCambio::orderBy('id', 'DESC')->get(); -> no funciona en la tabla
        // return $tipo_cambio;
        return view('configuracion_general.tipo_cambio.index',compact('tipo_cambio','moneda1','moneda2','consulta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $moneda_principal=Moneda::where('principal',1)->first();
        return view('configuracion_general.tipo_cambio.create',compact('moneda_principal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*varaibles del Index*/
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $tipo_cambio=TipoCambio::all();
        /**/
        $moneda_principal=Moneda::where('principal',1)->first();
        /*Recibiendo datos*/
        $compra=$request->get('compra');
        $venta=$request->get('venta');
        $paralelo=$request->get('paralelo');
        /**/
        $consulta=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();/*Consulta .sí se hizo hoy el cambio*/

        if($consulta){/*Consulta para que redirija error si hace doble tipo de cambio*/
            $error= "no puede generar otro tipo de cambio , en el mismo dia";
            return view('configuracion_general.tipo_cambio.index',compact('tipo_cambio','moneda1','moneda2','error','consulta'));
        }

        if ($moneda_principal->id =='1')/*pregunta si esta en Soles(Nacional)*/ {
            if ($compra<$paralelo) {
               $paralelo_recomendado=$compra-0.05;
               $error= 'el tipo de Cambio "Paralelo"('.$paralelo.') debe ser menor al tipo de Cambio "Compra"('.$compra.'). ';
               return view('configuracion_general.tipo_cambio.create',compact('error','moneda_principal','compra','venta','paralelo_recomendado'));
           }
       }
        elseif ($moneda_principal->id =='2')/*pregunta si esta en Dolares(Extranjero)*/  {
             if ($compra>$paralelo) {
           $paralelo_recomendado=$compra+0.05;
           $error= 'el tipo de Cambio "Paralelo"('.$paralelo.') debe ser Mayor al tipo de Cambio "Compra"('.$compra.')';
           return view('configuracion_general.tipo_cambio.create',compact('error','moneda_principal','compra','venta','paralelo_recomendado'));
             }
        }
       $cambio=new TipoCambio;
       $cambio->compra=$request->get('compra');
       $cambio->venta=$request->get('venta');
       $cambio->paralelo=$request->get('paralelo');
       $cambio->fecha=Carbon::now()->format('Y-m-d');
       $cambio->save();

       return redirect()->route('tipo_cambio.index');
    }

    public function sunat_cambio(Request $request){
        $moneda=Moneda::where('principal',1)->first();
        // https://www.deperu.com/api/rest/cotizaciondolar.json
        // https://www.youtube.com/watch?v=WTxYp9ECnPY
        $data = file_get_contents("https://www.deperu.com/api/rest/cotizaciondolar.json");
        $info = json_decode($data, true);
        if($moneda->tipo=="nacional"){
            $num=$info['Cotizacion'][0]['Venta']-0.05;
        }else{
            $num=$info['Cotizacion'][0]['Venta']+0.05;
        }


        $num=round($num, 3);


        $datos=array(
            0 => $info['Cotizacion'][0]['Compra'],
            1 => $info['Cotizacion'][0]['Venta'],
            2 => $num,

        );



        echo json_encode($datos);
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
