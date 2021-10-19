<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kardex_entrada_registro extends Model
{
    protected $table = 'kardex_entrada_registro';

    protected $guarded = [];

    protected $with = ['producto'];

     public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public function kardex_entrada_reg_id(){
        return $this->belongsTo(Kardex_entrada::class,'kardex_entrada_id');
    }

    public static function stock_producto_precio(){

        $stock_productos=Stock_producto::get();
        $stocks_activos = kardex_entrada_registro::where('estado',1)->get();

        foreach ($stocks_activos as $stocks_activo) {
           $productos[]=$stocks_activo->producto->id;
        }
        $prod=array_unique($productos, SORT_REGULAR);


        //ordena valores(?) funciona asi we
        $prod = array_values($prod);
        $count_cantidad=count($prod);

        for($x=0;$x<$count_cantidad;$x++){
            $cantidad[] = intval(kardex_entrada_registro::where('producto_id',$prod[$x])->where('estado',1)->sum('cantidad'));
        }
        //$prod -> los productos en orden
        //$cantidad -> obtiene el stock en orden al producto

        $contador=0;
        $array_registros[]=0;
        
        for($x=0;$x<$count_cantidad;$x++){
            while($cantidad[$x] > $contador){
                $kardex_almacen_principal_desc= kardex_entrada_registro::where('producto_id',$prod[$x])->where('estado',1)->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereNotIn('id',$array_registros)->first();
                $contador=$contador+$kardex_almacen_principal_desc->cantidad_inicial;
                $array_registros[]=$kardex_almacen_principal_desc->id;
            }
            //llamar los kardex_registros que tengan los id
            $precio_nacional= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_nacional');
            $precio_extranjero= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_extranjero');
            //guardar en sotck_productos
            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$prod[$x])->sum('cantidad');
            $stock_producto=Stock_producto::where('producto_id',$prod[$x])->first();
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=round($precio_nacional,2);
            $stock_producto->precio_extranjero=round($precio_extranjero,2);
            $stock_producto->save();
            unset($array_registros);
            unset($contador);
            $array_registros[]=0;
            $contador=0;
        }

    }
}
