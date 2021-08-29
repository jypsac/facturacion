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
use App\Igv;
use App\Provedor;
use App\TipoCambio;
use App\User;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use DB;
use App\Stock_producto;
use App\Stock_almacen;
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
      $user_login =auth()->user();
      $almacenes=Almacen::all();
      $clasificaciones=Categoria::all();
      if ($user_login->name== 'Administrador') {
        $kardex_entradas=Kardex_entrada::where('tipo_registro_id',1)->get();
        /* numero '1' es igual a Entrada de productos*/
      }else{ $kardex_entradas=Kardex_entrada::where('almacen_id',$user_login->almacen_id)->get();}

      foreach ($kardex_entradas as $value => $kardex_entrada) {
        $kardex_entrada_registros=kardex_entrada_registro::where('kardex_entrada_id',$kardex_entrada->id)->get();
        foreach ($kardex_entrada_registros as $value2 => $kardex_entrada_registro) {
          $KER_cantidad_inicial=$kardex_entrada_registro->cantidad_inicial;
          $KER_cantidad=$kardex_entrada_registro->cantidad;
          if($KER_cantidad_inicial==$KER_cantidad){
            $validador=1;
          }else{
            $validador=0;
            break;
          }
        }
        $array_final[$value]=$validador;

      }
      if(count($kardex_entradas) == 0){
          $validador=0;
          $array_final[1]=$validador;
      }
      // return $array_final;
      
      return view('inventario.kardex.entrada.entrada_producto.index' ,compact('kardex_entradas','almacenes','clasificaciones','array_final'));

    }

    public function fetcha(Request $request)
    {
      if($request->get('query'))
      {
        $query = $request->get('query');
        $data = DB::table('productos')->where('nombre', 'LIKE', "%{$query}%")->get();
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
        foreach($data as $row){
          $output .= '
          <li><a href="#">'.$row->nombre.'</a></li>
          ';
        }
        $output .= '</ul>';
        echo $output;
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
      $provedores=Provedor::all();
      $almacenes=Almacen::where('estado','0')->where('id',1)->get();
      $kardex_entrada = Kardex_entrada::get();
      $count_kardex_e = count($kardex_entrada);
      if($count_kardex_e > 0){
        $motivos=Motivo::where('nombre','!=','Inventario Inicial')->get();
      }else{
        $motivos=Motivo::all();
      }
      $categorias=Categoria::all();
      $moneda=Moneda::orderBy('principal','DESC')->get();
      $user_login =auth()->user()->id;
      $usuario=User::where('id',$user_login)->first();

      return view('inventario.kardex.entrada.entrada_producto.create',compact('almacenes','provedores','productos','motivos','categorias','moneda','usuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // return $request;
      $this->validate($request,[
        'motivo' => ['required','exists:motivos,id'],
        'factura' => ['required'],
        'almacen' => ['required','exists:almacen,id'],
            // 'clasificacion' => ['required','exists:categorias,id'],
        // 'guia_remision' => ['required'],
        'provedor' => ['required','exists:provedores,id'],
        'moneda' => ['required','exists:monedas,id'],
      ]
    );
      $data = $request->all();

        //codigo para convertir nombre a producto
      $cantidad_p = $request->input('cantidad');
      $count_cantidad_p=count($cantidad_p);

      $precio_p = $request->input('precio');
      $count_precio_p=count($precio_p);

      for($i=0 ; $i<$count_cantidad_p;$i++){
        $articulos[$i]= $request->input('articulo')[$i];
        $producto_id[$i]=strstr($articulos[$i], ' ', true);
      }
        //contador de valores de articulos
      $articulo = $request->input('articulo');
      $count_articulo=count($articulo);
        //validacion para la no incersion de dobles articulos
      for ($e=0; $e < $count_articulo; $e++){
        $articulo_comparacion_inicial=$request->get('articulo')[$e];
        for ($a=0; $a< $count_articulo ; $a++) {
          if ($a==$e) {
            $a++;
          }else {
            $articulo_comparacion=$request->get('articulo')[$a];
            if ($articulo_comparacion_inicial==$articulo_comparacion) {
              return redirect()->route('kardex-entrada.create')->with('repite', 'Datos repetidos - No permitidos!');
            }
          }

        }
      }
        //buscador al cambio
      $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
      if(!$cambio){
        return "error por no hacer el cambio diario";
      }

        //Guardado de almacen para inventario-inicial
      $almacen=$request->get('almacen');
      $almacen_id_buscador=Almacen::where('id',$almacen)->first();
      $almacen_codigo_sunat=$almacen_id_buscador->codigo_sunat;/*Codigo que brinda sunat a cada sucursal*/

      $agrupar_almacen=Kardex_entrada::where('almacen_id',$almacen)->get()->last();
      if (isset($agrupar_almacen)) {
        $numero = substr(strstr($agrupar_almacen->codigo_guia, '-'), 1);
        $numero++;

        $cantidad_sucursal=str_pad($almacen_codigo_sunat, 3, "0", STR_PAD_LEFT);
        $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
        $codigo_guia='GE'.$cantidad_sucursal.'-'.$cantidad_registro;
      }
      else{
        $cantidad_sucursal=str_pad($almacen_codigo_sunat, 3, "0", STR_PAD_LEFT);
        $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
        $codigo_guia='GE'.$cantidad_sucursal.'-'.$cantidad_registro;
      }
      if($request->get('guia_remision') == ""){
        $guia_re = 'Sin Guia de Remision';
      }else{
        $guia_re=$request->get('guia_remision');
      }
      $provedor = $request->get('provedor');
      $factura = $request->get('factura');
      $guia_remision = $request->get('guia_remision');

      $busc_prove_fac = Kardex_entrada::where('provedor_id',$provedor)->where('factura',$factura)->where('motivo_id','!=', '5')->first();
      // return $busc_prove_fac;
      if(isset($busc_prove_fac)){
        // return redirect()->route('kardex-entrada.create')->with('repite', 'El numero de factura ya está en uso');
         $this->validate($request,[
            'factura' => ['required','unique:kardex_entrada'],
          ]);
      }else{
        $factura = $request->get('factura');
      }

      $busc_prove_guia = Kardex_entrada::where('provedor_id',$provedor)->where('guia_remision',$guia_remision)->where('motivo_id','!=', '5')->first();
      if(isset($busc_prove_guia)){
        $this->validate($request,[
            'guia_remision' => ['required','unique:kardex_entrada'],
          ]);
      }else{
        $guia_remision = $request->get('factura');
      }



      $kardex_entrada=new Kardex_entrada();
      $kardex_entrada->motivo_id=$request->get('motivo');
      $kardex_entrada->codigo_guia=$codigo_guia;
      $kardex_entrada->provedor_id=$provedor;
      $kardex_entrada->guia_remision=$guia_remision;
      $kardex_entrada->categoria_id='2';
      $kardex_entrada->factura=$factura;
      $kardex_entrada->almacen_id=$request->get('almacen');
      $kardex_entrada->almacen_emisor_id=$request->get('almacen');
      $kardex_entrada->almacen_receptor_id=$request->get('almacen');
      $kardex_entrada->moneda_id=$request->get('moneda');
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

      $kardex_entrada_moneda_id=$request->get('moneda');


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
            $kardex_entrada_registro->precio_nacional=$request->get('precio')[$i];
            $precio_nacional=$request->get('precio')[$i];

            $precio_nacional_array[]=$request->get('precio')[$i]*$request->get('cantidad')[$i];

            $kardex_entrada_registro->precio_extranjero=$precio_nacional/$cambio->compra;

            $precio_extranjero_array[]= $kardex_entrada_registro->precio_extranjero*$request->get('cantidad')[$i];

            $kardex_entrada_registro->cambio=$cambio->compra;
          }else{
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
      }else {
        return redirect()->route('kardex-entrada.create')->with('campo', 'Falto introducir un campo de la tabla productos');
      }
      return redirect()->route('kardex-entrada.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $igv = Igv::first();
      $mi_empresa=Empresa::first();
      $moneda_nacional=Moneda::where('id','1')->first();
      $moneda_extranjera=Moneda::where('id','2')->first();
      $kardex_entradas=Kardex_entrada::find($id);
      $kardex_entradas_registros=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
      return view('inventario.kardex.entrada.entrada_producto.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera','igv'));
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
      return view('inventario.kardex.entrada.entrada_producto.edit' ,compact('kardex_entrada'));
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
    public function destroy(Request $request, $id)
    {
      $Kardex_entrada=Kardex_entrada::find($id);
        $bucador_registro_kardex=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
        foreach ($bucador_registro_kardex as $registro => $ids) {
          kardex_entrada_registro::whereIn('id', [$ids->id])->update(['estado' => 'ANULADO']);
          //STOCK ALMACEN
          Stock_almacen::egreso($Kardex_entrada->almacen_id,$ids->producto_id,$ids->cantidad);
          // STOCK PRODUCTOS -> CANTIDAD
          $stock_productos=Stock_producto::where('producto_id',$ids->producto_id)->first();
          $stock_productos->stock=$stock_productos->stock-$ids->cantidad;
          $stock_productos->save();
          // PRECIO //ANULAR RESTAR
          kardex_entrada_registro::stock_producto_precio();
        }

      $Kardex_entrada->estado='ANULADO';
      $Kardex_entrada->save();
      return redirect()->route('kardex-entrada.index');

    }

 //    function fetch(Request $request)
 //    {
 //     if($request->get('query'))
 //     {
 //      $query = $request->get('query');
 //      $data = DB::table('productos')
 //      ->where('nombre', 'LIKE', "%{$query}%")
 //      ->get();
 //      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
 //      foreach($data as $row)
 //      {
 //       $output .= '
 //       <li><a href="#">'.$row->country_name.'</a></li>
 //       ';
 //     }
 //     $output .= '</ul>';
 //     echo $output;
 //   }
 // }

  }
