<?php

namespace App;
use App\Stock_producto;
use App\CierrePeriodoRegistro;
use App\Moneda;
use App\Producto;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CierrePeriodo extends Model
{
    protected $table = 'cierre_periodo';

    protected $guarded = [];

    public function moneda(){
       return $this->belongsTo(Moneda::class,'moneda_id');
    }
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public static function cierre_periodo($compra_tipo_cambio){
        $fecha=Carbon::now();
        $fecha2=Carbon::now();
        $fecha_mes_anterior = $fecha->subMonth();
        $moneda_principal=Moneda::where('principal',1)->first();
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();
        $cierre_periodo_buscar=CierrePeriodo::latest('id')->first();


        if(empty($cierre_periodo_buscar)){
            $fecha_y=$fecha->format("Y");
            $fecha_m=$fecha->format("m");
            //primer registro en cierre periodo
            $cierre_periodo=New CierrePeriodo;
            $cierre_periodo->año=$fecha_y;
            $cierre_periodo->mes=$fecha_m;
            $cierre_periodo->ruta_excel="ruta excel";

            $name_pdf='Cierre_Periodo_'.$fecha_m.'_'.$fecha_y.'.pdf';


            $cierre_periodo->ruta_pdf=$name_pdf;
            $cierre_periodo->moneda_id=$moneda_principal->id;
            $cierre_periodo->tipo_cambio=$compra_tipo_cambio;
            $cierre_periodo->save();

            $stock_productos=Stock_producto::where('stock','!=',0)->get();
            foreach($stock_productos as $stock_producto){
                $cierre_periodo_r=New CierrePeriodoRegistro;
                $cierre_periodo_r->cierre_periodo_id=$cierre_periodo->id;
                $cierre_periodo_r->producto_id=$stock_producto->producto_id;
                $cierre_periodo_r->cantidad=$stock_producto->stock;
                $cierre_periodo_r->costo_nacional=$stock_producto->precio_nacional;
                $cierre_periodo_r->costo_extranjero=$stock_producto->precio_extranjero;
                $cierre_periodo_r->save();
            }
            $cierre_periodo_re = $cierre_periodo_r->get();
            $pdf=PDF::loadView('inventario.cierre_periodo.pdf',compact('cierre_periodo','moneda_principal','cierre_periodo_re','moneda1','moneda2'));

            $archivo =  $pdf->download();
            Storage::disk('cierre_periodo')->put($name_pdf,$archivo);

        }else{
        //  $fecha_diferencia = Carbon::createFromDate(         2021             ,              4             );
            $fecha_diferencia = Carbon::createFromDate($cierre_periodo_buscar->año,$cierre_periodo_buscar->mes);
            $diferencia_mes=$fecha_mes_anterior->diffInMonths($fecha_diferencia);
            $cont=intval($diferencia_mes);
            for($contador=0;$contador<=$cont;$contador++){
                $fecha_diferencia = Carbon::createFromDate($cierre_periodo_buscar->año,$cierre_periodo_buscar->mes)->addMonths($contador+1);
                $fecha_y=$fecha_diferencia->format("Y");
                $fecha_m=$fecha_diferencia->format("m");

                $cierre_periodo=New CierrePeriodo;
                $cierre_periodo->año=$fecha_y;
                $cierre_periodo->mes=$fecha_m;

                $name_pdf='Cierre_Periodo_'.$fecha_m.'_'.$fecha_y.'.pdf';

                $cierre_periodo->ruta_excel="ruta_excel";
                $cierre_periodo->ruta_pdf=$name_pdf;
                $cierre_periodo->moneda_id=$moneda_principal->id;
                $cierre_periodo->tipo_cambio=$compra_tipo_cambio;
                $cierre_periodo->save();

                $stock_productos=Stock_producto::where('stock','!=',0)->get();
                foreach($stock_productos as $stock_producto){
                    $cierre_periodo_r=New CierrePeriodoRegistro;
                    $cierre_periodo_r->cierre_periodo_id=$cierre_periodo->id;
                    $cierre_periodo_r->producto_id=$stock_producto->producto_id;
                    $cierre_periodo_r->cantidad=$stock_producto->stock;
                    $cierre_periodo_r->costo_nacional=$stock_producto->precio_nacional;
                    $cierre_periodo_r->costo_extranjero=$stock_producto->precio_extranjero;
                    $cierre_periodo_r->save();
                }
                $cierre_periodo_re = $cierre_periodo_r->get();
                $pdf=PDF::loadView('inventario.cierre_periodo.pdf',compact('cierre_periodo','moneda_principal','moneda1','moneda2','cierre_periodo_re'));

                $archivo =  $pdf->download();
                Storage::disk('cierre_periodo')->put($name_pdf,$archivo);

            }
        }
    }
}
