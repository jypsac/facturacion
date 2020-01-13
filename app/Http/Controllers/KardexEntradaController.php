<?php

namespace App\Http\Controllers;

use App\Kardex_entrada;
use App\Almacen;
use DB;
use App\Provedor;
use App\Producto;
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
        return view('inventario.kardex.entrada.create',compact('almacenes','provedores','productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Kardex_entrada::create(request()->all());
        // return redirect()->route('kardex-entrada.index');
        $cantidad = $request->input('cantidad');
        $count_productos=count($cantidad);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('inventario.kardex.entrada.show');
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
