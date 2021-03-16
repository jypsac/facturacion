<?php
namespace App\Http\Controllers;
use App\Almacen;
use App\Categoria;
use App\Empresa;
use App\InventarioInicial;
use App\Kardex_entrada;
use App\Moneda;
use App\Motivo;
use App\Producto;
use App\Provedor;
use App\TipoCambio;
use App\User;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use DB;
use App\Stock_producto;
use Illuminate\Http\Request;

class KardexEntradaTrasladoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$almacen=Almacen::where('estado',0)->where('id','!=',1)->get();
    	$kardex_distribucion=Kardex_entrada::where('tipo_registro_id',2)->get();

    	return view('inventario.kardex.entrada.traslado_almacen.index',compact('kardex_distribucion','almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function stock_ajax_traslado(Request $request){
        // return $request;
        $articulo=$request->get('articulo');
        $almacen=$request->get('almacen_emisor');
        $id=explode(" ",$articulo);

        $almacen_encontrado=Almacen::where('nombre',$almacen)->first();

        // //buscador del almacen perteneciente kardex_entrada
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_encontrado->id)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_encontrado->id)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                    $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('producto_id',$id[0])->get();
                    foreach( $nueva as $nuevas){
                        $id_kardex_entrada_registro[]=$nuevas->id;
                    }
            }
        }
        $stock=Kardex_entrada_registro::whereIn('id',$id_kardex_entrada_registro)->where('estado',1)->sum('cantidad');
        return $stock;
    }

    public function create(Request $request)
    {
    	$id_almacen_emisor=$request->get('almacen');
    	$almacen_emison=Almacen::where('id',$id_almacen_emisor)->first();
    	$productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
    	$almacenes=Almacen::where('estado','0')->where('id','!=',$id_almacen_emisor)->get();
    	$categorias=Categoria::all();
    	$user_login =auth()->user()->id;
    	$usuario=User::where('id',$user_login)->first();

    	return view('inventario.kardex.entrada.traslado_almacen.create',compact('almacenes','productos','categorias','usuario','almacen_emison'));

        // arreglamiento de los controladores a doble,llevando diferentes productos
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$mi_empresa=Empresa::first();
    	$moneda_nacional=Moneda::where('id','1')->first();
    	$moneda_extranjera=Moneda::where('id','2')->first();
    	$kardex_entradas=Kardex_entrada::find($id);
    	$kardex_entradas_registros=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
    	return view('inventario.kardex.entrada.traslado_almacen.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


    }

}
