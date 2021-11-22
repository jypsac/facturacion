<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Nota_Credito extends Model
{
    protected $table = 'nota_credito';

	protected $guarded = [];

    public function nota_i_facturacion(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }  

    public function nota_i_boleta(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    } 

    // public function nota_i_factura_boleta($estado){
    //     if($estado==0){
    //         return $this->belongsTo(Facturacion::class,'facturacion_id');
    //     }else{
    //         return $this->belongsTo(Boleta::class,'boleta_id');
    //     }
    // }


    public static function kardex_devolucion($nota_credito,$contador,$codigo){

        // return $nota_credito_registro;

        
     
        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return redirect()->route('kardex-entrada-Traslado-almacen.index')->with('repite', 'Error por no hacer el cambio diario!');
        }
        $registro_nota_credito = Tipo_Registro::where('id','=','4')->first();
        if(!isset($registro_nota_credito)){
            $registro_nc= new Tipo_Registro;
            $registro_nc->nombre="Nota Credito";
            $registro_nc->informacion="devolucion por nota de credito";
            $registro_nc->save();
        }
        //creacion del codigo guia codigo GTA que es para TRASLADO
        $ultima_entrada = Kardex_entrada::where('tipo_registro_id','=','4')->orderby('created_aT','DESC')->first();

        if(isset($ultima_entrada)){
            $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
            $numero++;
            $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
            $codigo_guia='DEV.NC'.'-'.$cantidad_registro;
        }else{
            $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
            $codigo_guia='DEV.NC'.'-'.$cantidad_registro;
        }
        
        // $cantidad = $request->input('cantidad');
        // $count_cantidad=count($cantidad);
        // $cantidad = $nota_credito_registro;
        $count_cantidad=$contador;

        $kardex_entrada=new Kardex_entrada();
        $kardex_entrada->motivo_id=3;
        $kardex_entrada->codigo_guia=$codigo_guia;
        $kardex_entrada->provedor_id=1;
        $kardex_entrada->guia_remision="NN";
        $kardex_entrada->categoria_id='1';
        $kardex_entrada->factura="0";
        $kardex_entrada->almacen_id=$nota_credito->almacen_id;
        $kardex_entrada->almacen_emisor_id=$nota_credito->almacen_id;
        $kardex_entrada->almacen_receptor_id=$nota_credito->almacen_id;
        $kardex_entrada->moneda_id=1;
        $kardex_entrada->tipo_registro_id=4;
        $kardex_entrada->estado=0;
        $kardex_entrada->user_id=auth()->user()->id;
        $kardex_entrada->informacion="SE HIZO DEVOLUCION ADJUNTO ".$codigo;
        $kardex_entrada->save();

        $nota_credito_registro=Nota_Credito_registro::where('nota_credito_id',$nota_credito->id)->get();
        
        $count_articulo=$count_cantidad;
        //envio para el almacen principal
        //estado devvolucion=1
        // envio para otro almacen secundario
        

        if($count_articulo == $count_cantidad ){

            for($i=0;$i<$count_articulo;$i++){

                //Creacion del nuevo registro de kardex entrada
                $kardex_entrada_registro=new kardex_entrada_registro();
                $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                $kardex_entrada_registro->producto_id=$nota_credito_registro[$i]->producto_id;
                $kardex_entrada_registro->cantidad_inicial=$nota_credito_registro[$i]->cantidad;
                $kardex_entrada_registro->precio_nacional=0;
                $kardex_entrada_registro->precio_extranjero=0;
                $kardex_entrada_registro->cambio=$cambio->compra;
                $kardex_entrada_registro->cantidad=0;
                $kardex_entrada_registro->estado_devolucion=1;
                $kardex_entrada_registro->almacen_id=$kardex_entrada->almacen_id;
                $kardex_entrada_registro->estado=0;
                $kardex_entrada_registro->tipo_registro_id=2;
                $kardex_entrada_registro->save();

                $almacen=$nota_credito->almacen_id;
                $kardex_entrada_get=Kardex_entrada::where('almacen_id',$almacen)->get();
                $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();

                foreach($kardex_entrada_get as $kardex_entradas){
                    $kadex_entrada_id[]=$kardex_entradas->id;
                }
                
                for($x=0;$x<$kardex_entrada_count;$x++){
                    if(Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->first())  {
                        $nueva[]=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->first();
                    }
                }

                // if($i==1){
                //     return $nueva;
                // }
                
                $comparacion=$nueva;
                // return $comparacion;
                //buble para la cantidad
                $cantidad_requerida=0;
                    foreach($comparacion as $comparaciones){
                        $cantidad_requerida=$comparaciones->cantidad+$cantidad_requerida;
                    }

                $cantidad=$nota_credito_registro[$i]->cantidad;
                $logica=$nota_credito_registro[$i]->cantidad;

                // return $comparacion;

                if(isset($comparacion)){
                    $var_cantidad_entrada=$nota_credito_registro[$i]->cantidad;
                    $contador=0;

                    foreach ($comparacion as $p) {
                        if($p->cantidad+$cantidad < $p->cantidad_inicial){
                            // return $p->cantidad+$logica;
                            $p->cantidad=$p->cantidad+$logica;
                            $p->estado=1;
                            $p->save();
                            // return "guarda";
                            break;
                        }else{
                            $logica=($logica-$p->cantidad_inicial)+$p->cantidad;
                            $p->cantidad=$p->cantidad_inicial;
                            $p->estado=1;
                            $p->save();
                            continue;
                        }
                    }
                }
                
                $cant = $nota_credito_registro[$i]->cantidad;
                Stock_almacen::ingreso($nota_credito->almacen_id,$kardex_entrada_registro->producto_id,$cant);

                kardex_entrada_registro::stock_producto_precio();

                unset($nueva);
                // Stock_almacen::egreso($almacen_emisor_json->id,$producto_id[$i],$cant);
            }
            // kardex_entrada_registro::stock_producto_precio();
        }else{
            return "Error fatal: por favor comunicarse con soporte inmediatamente";
        }
        
    }

}
