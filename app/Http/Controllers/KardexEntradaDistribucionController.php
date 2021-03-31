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
use App\Stock_almacen;
use Illuminate\Http\Request;

class KardexEntradaDistribucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kardex_distribucion=Kardex_entrada::where('tipo_registro_id',"3")->get();

        return view('inventario.kardex.entrada.distribucion_producto.index',compact('kardex_distribucion','almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kardex_entrada=Kardex_entrada::where('almacen_id',1)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',1)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado','!=','0')->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado','!=','0')->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
            return "no hay prodcutos en el almacen seleccionado";
        }

        $lista=array_values(array_unique($prod));
        sort($lista, SORT_NUMERIC);
        $lista_count=count($lista);

        for($x=0;$x<$lista_count;$x++){
           $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }
        // return $productos;

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        $almacenes=Almacen::where('estado','0')->where('id','!=',1)->get();

        $categorias=Categoria::all();
        $user_login =auth()->user()->id;
        $usuario=User::where('id',$user_login)->first();

        return view('inventario.kardex.entrada.distribucion_producto.create',compact('almacenes','productos','categorias','usuario'));
        //   manipulacion de la vista create para kardex dependiendo de los productosgit pushgit
    }

    public function stock_ajax_distribucion(Request $request){
        $articulo=$request->get('articulo');
        $id=explode(" ",$articulo);
        $almacen_encontrado=Almacen::where('id',1)->first();

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //ALMACEN
      $almacen_input=$request->input('almacen');

      $almacen_json=Almacen::where('id',$almacen_input)->first();

        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        $articulo_p = $request->input('articulo');
        $articulo_p=count($articulo_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
        }


        // Validacion para ver si la cantidad es suficiente con lo requerido

        //Primer verificacion de articulos en validacion del if
        $articulo1 = $request->input('articulo');
        $count_articulo1=count($articulo1);

        $cantidad1 = $request->input('cantidad');
        $count_cantidad1=count($cantidad1);

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_articulo1; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_articulo1 ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return "dobles articulos error";
                    }
                }
            }
        }


        //Validacion para cantidad
        for ($i=0; $i < $count_articulo1; $i++){
            $articulo_c=$producto_id[$i];
            $cantidad_c=$request->get('cantidad')[$i];
            $consulta_cantidad=kardex_entrada_registro::where('producto_id',$articulo_c)->where('estado','1')->sum('cantidad');
            if ($cantidad_c > $consulta_cantidad) {
                // return redirect()->route('kardex-salida.create')->with('cantidad', 'no hay cantidad deseada para el articulos');
              return "validacion en cantidad";
            }
        }

        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }


        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        $cantidad= $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //creacion del codigo guia
        // $codigo_guia="GD-00000002";
        $ultima_entrada = Kardex_entrada::where('tipo_registro_id','=','3')->orderby('created_aT','DESC')->first();
        // return $ultima_entrada;

        if(isset($ultima_entrada)){
          $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
          $numero++;
          $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
          $codigo_guia='GD'.'-'.$cantidad_registro;
        }else{
          $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
          $codigo_guia='GD'.'-'.$cantidad_registro;
        }


        //fin codigo guia

        if($count_articulo = $count_cantidad){
          $cantidad = $request->input('cantidad');
          $count_cantidad=count($cantidad);

          $kardex_entrada=new Kardex_entrada();
          $kardex_entrada->motivo_id=1;
          $kardex_entrada->codigo_guia=$codigo_guia;
          $kardex_entrada->provedor_id=1;
          $kardex_entrada->guia_remision="NN";
          $kardex_entrada->categoria_id='1';
          $kardex_entrada->factura="0";
          $kardex_entrada->almacen_id=$almacen_json->id;
          $kardex_entrada->moneda_id=1;
          $kardex_entrada->tipo_registro_id=3;
          $kardex_entrada->estado=1;
          $kardex_entrada->user_id=auth()->user()->id;
          $kardex_entrada->informacion="0";
          $kardex_entrada->save();

          //contador de valores de articulos (re verificacion)
          $articulo = $request->input('articulo');
          $count_articulo=count($articulo);

          $cantidad= $request->input('cantidad');
          $count_cantidad=count($cantidad);
          // return $count_articulo;
          if($count_articulo = $count_cantidad ){
            for($i=0;$i<$count_articulo;$i++){
              //Creacion del nuevo registro de kardex entrada
              $kardex_entrada_registro=new kardex_entrada_registro();
              $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
              $kardex_entrada_registro->producto_id=$producto_id[$i];
              $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
              $kardex_entrada_registro->precio_nacional=0;
              $kardex_entrada_registro->precio_extranjero=0;
              $kardex_entrada_registro->cambio=$cambio->compra;
              $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
              $kardex_entrada_registro->estado=1;
              // $kardex_entrada_registro->estado_devolucion;
              $kardex_entrada_registro->tipo_registro_id=3;
              $kardex_entrada_registro->save();

              $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('tipo_registro_id','=',1)->get();
              $cantidad=kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('tipo_registro_id','=',1)->sum('cantidad');


              //buble para la cantidad

              $cantidad=0;
              foreach($comparacion as $comparaciones){
                  $cantidad=$comparaciones->cantidad+$cantidad;
              }
              // return $cantidad;
              if(isset($comparacion)){
                  $var_cantidad_entrada=$kardex_entrada_registro->cantidad;

                  $contador=0;
                  foreach ($comparacion as $p) {
                      if($p->cantidad>$var_cantidad_entrada){
                          $cantidad_mayor=$p->cantidad;
                          $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                          $p->cantidad=$cantidad_final;
                          if($cantidad_final==0){
                              $p->estado=0;
                              $p->save();
                              break;
                          }else{
                              $p->save();
                              break;
                          }
                      }elseif($p->cantidad==$var_cantidad_entrada){
                          $p->cantidad=0;
                          $p->estado=0;
                          $p->save();
                          break;
                      }
                      else{
                          $var_cantidad_entrada=$var_cantidad_entrada-$p->cantidad;
                          $p->cantidad=0;
                          $p->estado=0;
                          $p->save();

                      }

                  }
              }
              // return $comparacion;
              //resta de cantidades de productos para la tabla stock productos
              $producto_stock=Stock_producto::where('producto_id',$producto_id[$i])->first();
              if($producto_stock){

              }else{
                //Agregado de cantidades para la tabla stock productos
                $stock_productos=new Stock_producto();
                $stock_productos->producto_id=$producto_id[$i];
                $stock_productos->stock=$request->get('cantidad')[$i];
                $stock_productos->save();
              }
              //$almacen_json = Almacen saliente
              $almacen_principal = Almacen::where('principal','1')->first();
              // return $almacen_principal->id;
              //suma de cantidades a la tabla por alamacen secundario elegido
              Stock_almacen::ingreso($almacen_json->id,$producto_id[$i],$kardex_entrada_registro->cantidad);
              //resta de cantidades a la tabla principal
              Stock_almacen::egreso($almacen_principal->id,$producto_id[$i],$kardex_entrada_registro->cantidad);
            }
            // return $comparacion;
          }else{
              return "Error fatal: por favor comunicarse con soporte inmediatamente";
          }
        }else{
            return redirect()->route('kardex-entrada-Distribucion.create')->with('campo', 'Falto introducir un campo de la tabla productos');
          // return "error campo de tabla";
        }
        // return $comparacion
        return redirect()->route('kardex-entrada-Distribucion.index');
        // return "exito";
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
      $almacen = Almacen::where('principal','1')->first();
      return view('inventario.kardex.entrada.distribucion_producto.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera','almacen'));
      // return $kardex_entradas;
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
