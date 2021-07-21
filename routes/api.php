<?php

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\Producto;
use App\Categoria;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
// PRODUCTOS
Route::get('productos',function(){
    $producto = Producto::query();
    return Datatables($producto)
        ->addColumn('categoria', function ($producto) {
            return $producto->categoria_i_producto->descripcion;
        })
        ->addColumn('marca', function ($producto) {
            return $producto->marcas_i_producto->nombre;
        })
        ->addColumn('estado', function ($producto) {
            return $producto->estado_i_producto->nombre;
        })
        ->addColumn('afectacion', function ($producto) {
            return $producto->tipo_afec_i_producto->informacion;
        })->addColumn('afectacion', function ($producto) {
            return $producto->tipo_afec_i_producto->informacion;
        })
        ->toJson();
});
// GARANTIA GUIA INGRESO
Route::get('garantia_ingreso',function(){
    $garantia_ingreso_q = GarantiaGuiaIngreso::query();
    return Datatables($garantia_ingreso_q)
        ->addColumn('marcas', function ($garantia_ingreso_q) {
            return $garantia_ingreso_q->marcas_i->nombre;
        })
        ->addColumn('cliente', function ($garantia_ingreso_q) {
            return $garantia_ingreso_q->clientes_i->nombre;
        })
        ->addColumn('anulacion', function ($garantia_ingreso_q) {
            $valor = $garantia_ingreso_q->created_at;
            if(tiempo($valor) == 1){
                return '1';
            }else{
                return '0';
            }

        })
    ->toJson();
});
