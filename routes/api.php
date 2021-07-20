<?php

use Illuminate\Http\Request;
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
Route::get('productos',function(){
    $producto = Producto::get();
    return Datatables($producto)
        // ->addColumn('categoria', function ($producto) {
        //     return $producto->categoria_i_producto->descripcion;
        // })
        ->addColumn('marca', function ($producto) {
            return $producto->marcas_i_producto->nombre;
        })
        ->addColumn('estado', function ($producto) {
            return $producto->estado_i_producto->nombre;
        })
        // ->addColumn('afectacion', function ($producto) {
        //     return $producto->tipo_afec_i_producto->informacion;
        // })
        ->toJson();
});
// Route::get('productos',function(){
//     return datatables(Producto::all())->toJson();
// });