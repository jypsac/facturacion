    
@extends('layout')

@section('title', 'Guia Remision Agregar')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('href_accion', route('guia_remision.index'))
@section('value_accion', 'Atras')
@section('content')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<head>
    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });


        });
    </script>
</head>
<form action="{{route('guia_remision.store')}}"  enctype="multipart/form-data" method="post">
    @csrf
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">

                        <address class="col-sm-4" align="left">

                            <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div> 

                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">{{$empresa->ruc}}</h3>
                                <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>   
                                <h5>1</h5>   
                            </center>

                        </div>
                    </div>
                </div><br>
                {{--  Cabecera --}}
                <div class="row">
                    <div class="col-sm-6" >
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Cliente:</label>
                            <div class="col-sm-4">
                                <input  class="form-control m-b"  value="{{$cotizacion->cliente->nombre}}" readonly="readonly">
                                
                            </div>
                            <label class="col-sm-2 col-form-label">RUC/DNI:</label>
                            <div class="col-sm-4">
                                <input  class="form-control m-b"   value="{{$cotizacion->cliente->numero_documento}}" readonly="readonly">
                                <input type="text" value="{{$cotizacion->cliente->id}}" name="cliente_id" hidden="hidden">
                                <input type="text" value="{{$cotizacion->id}}" name="id" hidden="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <div class="row">
                            <label class="col-sm-2 col-form-label">F.Emision:</label>
                            <div class="col-sm-3">
                                <input type="text" style="font-size: 12px" name="fecha_emision" class="form-control" value="{{date("Y/m/d")}}" readonly="readonly">
                            </div>
                            <label class="col-sm-2 col-form-label">F.Entrega:</label>
                            <div class="col-sm-5">
                                <input type="date" name="fecha_entrega" class="form-control"  required="required" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Domicilio Partida:</label>
                            <div class="col-sm-10">
                                <textarea  class="form-control m-b" readonly="readonly">{{$empresa->calle}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Domicilio Llegada:</label>
                            <div class="col-sm-10">
                                <textarea  class="form-control m-b" readonly="readonly">{{$cotizacion->cliente->direccion}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" >
                            <div class="row">
                                <label class="col-sm-1">Vehiculo:</label>
                                <div class="col-sm-5">
                                   <input list="browsersc" class="form-control m-b" name="vehiculo" autocomplete="off">
                                    <datalist id="browsersc" >
                                        @foreach($vehiculo as $vehiculos)
                                        <option id="{{$vehiculos->id}}">{{$vehiculos->placa}} / {{$vehiculos->marca}}</option>
                                        @endforeach
                                    </datalist>
                               </div>
                               <label class="col-sm-1">Conductor:</label>
                               <div class="col-sm-5">
                                   <input type="text" name="conductor" class="form-control"  value="0" >
                               </div>
                           </div>
                       </div>
                </div>
                {{-- Fin Cabecera --}}
                {{-- Tabla Mostrito --}}
                
                <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th>Codigo Producto</th>
                                        <th>Marca/Descripcion</th>
                                        <th>N/S</th>
                                        <th>Und.Medida</th>
                                        <th>Cantidad</th>
                                        <th>peso</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cotizacion_registro as $cotizacion_registros)
                                    <tr>
                                        <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                        <td><b>{{$cotizacion_registros->producto->marcas_i_producto->nombre}}</b> {{$cotizacion_registros->producto->nombre}}</td>
                                        <td><textarea {{-- name="numero_serie" --}} class="form-control" style="width: 180px;font-size: 12px"></textarea></td>
                                        <td>{{$cotizacion_registros->producto->unidad_i_producto->medida}}</td>
                                        <td>{{$cotizacion_registros->cantidad}}</td>
                                        <td>{{$cotizacion_registros->producto->unidad_i_producto->peso}}</td>
                                    </tr>
                                    
                                      @endforeach                                      

                                </table>

                    <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
                    <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                    {{-- <a onclick="print()"><button class="btn btn-warning float-right" ><i class="fa fa-cloud" aria-hidden="true">Imprimir</i></button></a> --}}
                    <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp;
                    {{-- Fin de Tabla Mostrito --}}




                </div>
            </div>
        </div>

 </form>
        <style type="text/css">
            .ruc{border-radius: 10px; height: 150px;}
            .form-control{border-radius: 10px;}
        </style>

        <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
        <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <!-- Custom and plugin javascript -->
        <script src="{{ asset('js/inspinia.js') }}"></script>
        <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script> 

    @endsection
