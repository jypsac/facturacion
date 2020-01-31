<?php

namespace App\Http\Controllers;

use DB;
use App\Almacen;
use App\Empresa;
use App\Provedor;
use App\Producto;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\Motivo;
use App\InventarioInicial;

use Illuminate\Http\Request;

class KardexEntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kardex_entradas=Kardex_entrada::all();
        return view('inventario.kardex.entrada.index' ,compact('kardex_entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos=Producto::all();
        $provedores=Provedor::all();
        $almacenes=Almacen::all();
        $motivos=Motivo::all();
        return view('inventario.kardex.entrada.create',compact('almacenes','provedores','productos','motivos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Guardado de almacen para inventario-inicial
        $almacen=$request->get('almacen');

        //Kardex Entrada Guardado
        $kardex_entrada=new Kardex_entrada();
        $kardex_entrada->motivo=$request->get('motivo');
        $kardex_entrada->provedor_id=$request->get('provedor');
        $kardex_entrada->guia_remision=$request->get('guia_remision');
        $kardex_entrada->factura=$request->get('factura');
        $kardex_entrada->almacen_id=$request->get('almacen');
        $kardex_entrada->informacion=$request->get('informacion');
        $kardex_entrada->save();

        //contador de valores de articulos
        $articulo = $request->input('articulo');    
        $count_articulo=count($articulo);  
         
        //validacion para la no incersion de dobles articulos
        
        $count_articulo_menos=$count_articulo-1;    
        
        for ($e=0; $e <= $count_articulo_menos; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=1; $a<=$count_articulo_menos ; $a++) {
                $articulo_comparacion=$request->get('articulo')[$a];
                if ($articulo_comparacion_inicial==$articulo_comparacion) {
                    return "igualdad";
                }
            }
        }

        return $articulo;
        
           

        // if($count_articulo==1){
        //     for ($e=0; $e < $count_articulo_menos; $e++) {
        //         $articulo_comparacion_inicial=$request->get('articulo')[$e];
        //         for ($a=0; $a<=$count_articulo ; $a++) {
        //             $articulo_comparacion=$request->get('articulo')[$a];
        //             if ($articulo_comparacion_inicial==$articulo_comparacion) {
        //                 return "---Count Articulo : ".$count_articulo." ---Articulo comparacion inicial ".$articulo_comparacion_inicial." ---Articulo comparacion : ".$articulo_comparacion;
        //             }
        //         }
        //     }
        // }else{
        //     $articulo_comparacion_inicial=$request->get('articulo')[0];
        //     return $count_articulo_menos;
        // }
        
        

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);
        //contador de valores de precio
        $precio = $request->input('precio');
        $count_precio=count($precio);


        if($count_articulo = $count_cantidad = $count_precio){
            for($i=0;$i<$count_articulo;$i++){
                $kardex_entrada_registro=new kardex_entrada_registro();
                $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                $kardex_entrada_registro->producto_id=$request->get('articulo')[$i];
                $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                $kardex_entrada_registro->precio=$request->get('precio')[$i];
                $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
                $kardex_entrada_registro->estado=1;
                $kardex_entrada_registro->save();
            }
        }else {
            return "Falto introducir un campo";
        }

        return "Guardado";

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
        $kardex_entradas=Kardex_entrada::find($id);
        $kardex_entradas_registros=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
        return view('inventario.kardex.entrada.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kardex_entrada=Kardex_entrada::find($id);
        return view('inventario.kardex.entrada.edit' ,compact('kardex_entrada'));
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
        $update=Kardex_entrada::find($id);
        $update->nombre=$request->get('nombre');
        $update->precio=$request->get('precio');
        $update->serie_producto=$request->get('serie_producto');
        $update->cantidad=$request->get('cantidad');
        $update->provedor=$request->get('provedor');
        $update->almacen=$request->get('almacen');
        $update->informacion=$request->get('informacion');
        $update->save();

        return redirect()->route('kardex-entrada.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy=Kardex_entrada::findOrFail($id);
        $destroy->delete();

        return redirect()->route('kardex-entrada.index');
    }

    function fetch(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('productos')
        ->where('nombre', 'LIKE', "%{$query}%")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="#">'.$row->country_name.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }

    // public function search(Request $request)
    // {
    //       $search = $request->get('term');

    //       $result = Producto::where('nombre', 'LIKE', '%'. $search. '%')->get();

    //       return response()->json($result);

    // }

    //  function productos(Request $request){
    //     $ruc=$request->get('ruc');
    //     $datos = array(
    //         0 => "1",
    //         1 => "2",
    //         2 => "3",
    //         3 => "4",
    //         4 => "5",
    //         5 => "6",
    //         6 => "7",
    //         7 => "8",
    //         8 => "9"
    //     );
    //         echo json_encode($datos);

    // }
}
