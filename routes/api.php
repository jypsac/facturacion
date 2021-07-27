<?php

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\GarantiaInformeTecnico;
use App\Producto;
use App\Categoria;
Use App\Cliente;

use App\Providers\RouteServiceProvider;
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
Auth::routes();
Route::get('productos',function(){
    $producto = Producto::query();
    return Datatables($producto)
        ->addColumn('categoria', function ($producto) {
            return $producto->categoria_i_producto->descripcion;
        })
        ->addColumn('familia', function ($producto) {
            return $producto->familia_i_producto->descripcion;
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
        ->addColumn('personal', function ($garantia_ingreso_q) {
            return $garantia_ingreso_q->personal_laborales->nombres;
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
        ->addColumn('estado', function ($garantia_ingreso_q) {
            $valor = $garantia_ingreso_q->estado;
            if($valor == 1){
                return 'ACTIVO';
            }else{
                return 'ANULADO';
            }

        })
    ->toJson();
});
// GARANTIA GUIA EGRESO
Route::get('garantia_egreso',function(){
    $garantia_egre_q = GarantiaGuiaEgreso::query();
    return Datatables($garantia_egre_q)
        ->addColumn('marcas', function ($garantia_egre_q) {
            return $garantia_egre_q->garantia_ingreso_i->marcas_i->nombre;
        })
        ->addColumn('estado', function ($garantia_egre_q) {
            $valor = $garantia_egre_q->estado;
            if($valor == 1){
                return 'ACTIVO';
            }else{
                return 'ANULADO';
            }

        })
        ->addColumn('motivo', function ($garantia_egre_q) {
            return $garantia_egre_q->garantia_ingreso_i->motivo;
        })
        ->addColumn('personal', function ($garantia_egre_q) {
            return $garantia_egre_q->garantia_ingreso_i->personal_laborales->nombres;
        })
        ->addColumn('asunto', function ($garantia_egre_q) {
            return $garantia_egre_q->garantia_ingreso_i->asunto;
        })
        ->addColumn('clientes', function ($garantia_egre_q) {
            return $garantia_egre_q->garantia_ingreso_i->clientes_i->nombre;
        })
    ->toJson();
});
//INFORME TECNICO
Route::get('informe_tecnico', function(){
    $inform_tec = GarantiaInformeTecnico::query();
    return Datatables($inform_tec)
        ->addColumn('marcas', function ($inform_tec) {
            return $inform_tec->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre;
        })
        ->addColumn('estado', function ($inform_tec) {
            $valor = $inform_tec->estado;
            if($valor == 1){
                return 'ACTIVO';
            }else{
                return 'ANULADO';
            }

        })
        ->addColumn('motivo', function ($inform_tec) {
            return $inform_tec->garantia_egreso_i->garantia_ingreso_i->motivo;
        })
        ->addColumn('personal', function ($inform_tec) {
            return $inform_tec->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres;
        })
        ->addColumn('fecha', function ($inform_tec) {
            return $inform_tec->garantia_egreso_i->garantia_ingreso_i->fecha;
        })
        ->addColumn('asunto', function ($inform_tec) {
            return $inform_tec->garantia_egreso_i->garantia_ingreso_i->asunto;
        })
        ->addColumn('clientes', function ($inform_tec) {
            return $inform_tec->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre;
        })
    ->toJson();
});

//CLIENTES
Route::get('clientes',function(){
    $cliente = Cliente::query();
    return Datatables($cliente)
        ->toJson();
});