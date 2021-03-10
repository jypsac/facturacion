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

class KardexEntradaDistribucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $kardex_distribucion=Kardex_entrada::where('tipo_registro_id',3)->get();

      return view('inventario.kardex.entrada.distribucion_producto.index',compact('kardex_distribucion'));
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
      $almacenes=Almacen::where('estado','0')->where('id','!=',1)->get();
      $motivos=Motivo::all();
      $categorias=Categoria::all();
      $moneda=Moneda::orderBy('principal','DESC')->get();
      $user_login =auth()->user()->id;
      $usuario=User::where('id',$user_login)->first();

      return view('inventario.kardex.entrada.distribucion_producto.create',compact('almacenes','provedores','productos','motivos','categorias','moneda','usuario'));
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
      return view('inventario.kardex.entrada.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera'));
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

    public function create_distribucion()
    {
      // return 'xd';

    }

  }
