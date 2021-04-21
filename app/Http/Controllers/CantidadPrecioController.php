<?php

namespace App\Http\Controllers;

use App\CantidadPrecio;
use App\Stock_producto;
use Illuminate\Http\Request;

class CantidadPrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_producto = Stock_producto::all();
        return view('inventario.cantidades-precios.index',compact('stock_producto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function show(CantidadPrecio $cantidadPrecio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function edit(CantidadPrecio $cantidadPrecio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CantidadPrecio $cantidadPrecio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function destroy(CantidadPrecio $cantidadPrecio)
    {
        //
    }
}
