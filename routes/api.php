<?php

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\GarantiaInformeTecnico;
use App\Producto;
use App\Categoria;
// use DB;
// use DataTables;
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

Route::get('productos',function(){
    $producto = DB::table('productos')
        ->select('*','productos.id as prod_id' ,'marcas.nombre as nombre_marca','familias.descripcion as familia_desc', 'tipo_afectacion.informacion as afectacion_info','estado.nombre as estado_nom' )
        ->join('familias', 'productos.familia_id', '=', 'familias.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
        ->join('estado', 'productos.estado_id', '=', 'estado.id')
        ->get();
    return DataTables($producto)->toJson();
});
// GARANTIA GUIA INGRESO
Route::get('garantia_ingreso',function(){

    $garantia_ingreso_q = DB::table('garantia_guia_ingreso')
        ->select('*','garantia_guia_ingreso.id as gar_ing_id','garantia_guia_ingreso.created_at as gar_ing_ct_at', 'marcas.nombre as nombre_marca','clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_guia_ingreso.estado as estado_ga_ing')
        ->orderby('garantia_guia_ingreso.id', 'DESC')
        ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
        ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
        ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')

        ->get();
    return Datatables($garantia_ingreso_q)
        ->addColumn('tiempo', function ($garantia_ingreso_q) {
            $valor = $garantia_ingreso_q->gar_ing_ct_at;
            if( tiempo($valor) == 1){
                return '1';
            }else{
                return '0';
            }
        })
    ->toJson();
});
// GARANTIA GUIA EGRESO
Route::get('garantia_egreso',function(){
    $garantia_egre_q = DB::table('garantia_guia_egreso')
        ->select('*','garantia_guia_egreso.id as egreso_id','marcas.nombre as nombre_marca','clientes.nombre as cliente_nom', 'personal.nombres as personal_as' ,'garantia_guia_egreso.estado as esta_egre')
        ->join('garantia_guia_ingreso', 'garantia_guia_egreso.garantia_ingreso_id', '=', 'garantia_guia_ingreso.id')
        ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
        ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
        ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')
        ->get();
    return Datatables($garantia_egre_q)
        ->addColumn('estado', function ($garantia_egre_q) {
            $valor = $garantia_egre_q->esta_egre;
            if($valor == 1){
                return 'ACTIVO';
            }else{
                return 'ANULADO';
            }
        })
    ->toJson();
});
//INFORME TECNICO
Route::get('informe_tecnico', function(){
    $inform_tec = DB::table('garantia_informe_tecnico')
        ->select('*','garantia_informe_tecnico.id as inf_tec_id','marcas.nombre as nombre_marca','clientes.nombre as cliente_nom', 'personal.nombres as personal_as' ,'garantia_informe_tecnico.estado as esta_egre')
        ->join('garantia_guia_egreso', 'garantia_informe_tecnico.garantia_egreso_id', '=', 'garantia_guia_egreso.id')
        ->join('garantia_guia_ingreso', 'garantia_guia_egreso.garantia_ingreso_id', '=', 'garantia_guia_ingreso.id')
        ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
        ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
        ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')
        ->get();
    return Datatables($inform_tec)
        ->addColumn('estado', function ($inform_tec) {
            $valor = $inform_tec->esta_egre;
            if($valor == 1){
                return 'ACTIVO';
            }else{
                return 'ANULADO';
            }
        })
    ->toJson();
});

//CLIENTES
Route::get('clientes',function(){
    $cliente = Cliente::query();
    return Datatables($cliente)
        ->toJson();
});
Auth::routes();
//TIPO DE CAMBIO
