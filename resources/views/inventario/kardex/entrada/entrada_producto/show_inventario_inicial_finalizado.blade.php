@extends('layout')

@section('title', 'Ver')
@section('breadcrumb', 'INVENTARIO INICIAL')
@section('breadcrumb2', 'INVENTARIO INICIAL')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')
@section('button2', 'Nueva Entrada')
@section('config',route('kardex-entrada.create'))

@section('content')

<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-4 ">
                      <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 300px;margin-bottom: 15px;">
                  </div>
                  <div class="col-sm-4 ">
                  </div>
                  <div class="col-sm-4 text-right">
                    <div class="form-control ruc" >
                        <center>
                            <h3 style="padding-top:10px ">RUC : {{$mi_empresa->ruc}}</h3>
                            <h2>INVENTARIO INICIAL</h2>
                            <h4 class="text-navy">{{$inventario_inicial->codigo_guia}}</h4>
                        </center>
                    </div><br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="divmsg" style="display:none"  role="alert"></div>
                    <div class="form-group row ">
                        <label class="col-sm-1 col-form-label" >Motivos:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" disabled="" value="Inventario Inicial">
                        </div>

                        <label class="col-sm-1 col-form-label" >Almacen:</label>
                        <div class="col-sm-3">
                            <input type="text" disabled="" value="Almacen Principal" class="form-control">
                        </select>
                    </div>

                    <label class="col-sm-1 col-form-label" >Moneda:</label>
                    <div class="col-sm-3">
                       <div class="tooltip-demo">
                        <input type="text" class="form-control" disabled="" value="{{$inventario_inicial->moneda->nombre}} ({{$inventario_inicial->moneda->simbolo}})"  data-toggle="tooltip" data-placement="top" title="Si Deseas cambiar la Moneda, Puedes cambiarla en 'Monedas'">
                    </div>
                </div>
            </div>
        </div>
    </div>
      <table class="table invoice-table" >
        <thead>
            <tr>
                <th >Producto</th>
                <th style="width:150px">Cantidad</th>
                <th style="width:150px">Precio </th>
                <th style="background: #f3f3f4;width:150px">Precio Total</th>
            </tr>
        </thead>
        <tbody id="assas">
            @foreach($kardex_entradas_registros as $kardex_entradas_registro)
            <tr>
                <td >{{$kardex_entradas_registro->producto->codigo_original}} -  {{$kardex_entradas_registro->producto->nombre}}</td>
                <td>{{$kardex_entradas_registro->cantidad_inicial}}</td>
                <td>{{$kardex_entradas_registro->precio_nacional}}</td>
                <td> {{$kardex_entradas_registro->cantidad_inicial*$kardex_entradas_registro->precio_nacional}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

<br>
</div>
</div>
</div>
</div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

@endsection
