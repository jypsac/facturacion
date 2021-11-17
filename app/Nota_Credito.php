<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    
    public static function kardex_devolucion($invoice,$nota_credito,$nota_creadito_registro){
        
        $kardex_entrada=new Kardex_entrada();
        $kardex_entrada->motivo_id=$motivo->id;
        $kardex_entrada->codigo_guia=$codigo_guia;
        $kardex_entrada->provedor_id=$provedor;
        $kardex_entrada->guia_remision=$guia_remision;
        $kardex_entrada->categoria_id='2';
        $kardex_entrada->factura=$factura;
        $kardex_entrada->almacen_id=$request->get('almacen');
        $kardex_entrada->almacen_emisor_id=$request->get('almacen');
        $kardex_entrada->almacen_receptor_id=$request->get('almacen');
        $kardex_entrada->moneda_id=$moneda->id;
        $kardex_entrada->tipo_registro_id=1;
        $kardex_entrada->estado=1;
        $kardex_entrada->user_id=auth()->user()->id;
        $kardex_entrada->informacion=$request->get('informacion');
        $kardex_entrada->fecha_compra = $request->get('fecha_compra');
        $kardex_entrada->save();

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores de precio
        $precio = $request->input('precio');
        $count_precio=count($precio);


        //convertido a moneda principal
        $moneda_principal=Moneda::where('tipo','nacional')->first();
        $moneda_principal_id=$moneda_principal->id;


        $kardex_entrada_moneda_id=$moneda->id;


        //cuando la moneda es la principal
        if($count_articulo = $count_cantidad = $count_precio){
            for($i=0;$i<$count_articulo;$i++){
                $kardex_entrada_registro=new kardex_entrada_registro();
                $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                $kardex_entrada_registro->producto_id=$producto_id[$i];
                $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                $kardex_entrada_registro->tipo_registro_id = 1;
                //monedas
                if($moneda_principal_id==$kardex_entrada_moneda_id){
                    // return "A";
                    $kardex_entrada_registro->precio_nacional=$request->get('precio')[$i];
                    $precio_nacional=$request->get('precio')[$i];

                    $precio_nacional_array[]=$request->get('precio')[$i]*$request->get('cantidad')[$i];

                    $kardex_entrada_registro->precio_extranjero=$precio_nacional/$cambio->compra;

                    $precio_extranjero_array[]= $kardex_entrada_registro->precio_extranjero*$request->get('cantidad')[$i];

                    $kardex_entrada_registro->cambio=$cambio->compra;
                }else{
                    // return "B";
                    $kardex_entrada_registro->precio_extranjero=$request->get('precio')[$i];
                    $precio_extranjero=$request->get('precio')[$i];

                    $precio_extranjero_array[]=$request->get('precio')[$i]*$request->get('cantidad')[$i];

                    $kardex_entrada_registro->precio_nacional=$precio_extranjero*$cambio->venta;

                    $precio_nacional_array[] = $kardex_entrada_registro->precio_nacional*$request->get('cantidad')[$i];

                    $kardex_entrada_registro->cambio=$cambio->venta;
                }

                $kardex_entrada_registro->almacen_id=$kardex_entrada->almacen_id;
                $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
                $kardex_entrada_registro->estado=1;
                $kardex_entrada_registro->save();

                //buscador de producto en la tabla stock productos
                $producto_stock=Stock_producto::where('producto_id',$producto_id[$i])->first();
                
                if($producto_stock){

                }else{
                    //Agregado de cantidades para la tabla stock productos
                    $stock_productos=new Stock_producto();
                    $stock_productos->producto_id=$producto_id[$i];
                    $stock_productos->stock=$request->get('cantidad')[$i];
                    $stock_productos->save();
                }
                Stock_almacen::ingreso($almacen,$producto_id[$i],$kardex_entrada_registro->cantidad);
            }

            kardex_entrada_registro::stock_producto_precio();

            //insercion de precio total en cabezera de kardex entrada
            $kardex_entrada_tot=Kardex_entrada::find($kardex_entrada->id);
            $kardex_entrada_tot->precio_nacional_total =  array_sum($precio_nacional_array);
            $kardex_entrada_tot->precio_extranjero_total = array_sum($precio_extranjero_array);
            $kardex_entrada_tot->save();
        }else{
            return redirect()->route('kardex-entrada.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
    }
    // public function nota_i_factura_boleta($estado){
    //     if($estado==0){
    //         return $this->belongsTo(Facturacion::class,'facturacion_id');
    //     }else{
    //         return $this->belongsTo(Boleta::class,'boleta_id');
    //     }
    // }

}
