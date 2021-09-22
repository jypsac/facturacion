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
                </div>
            </div>

            <div class="table-responsive m-t">
                <table class="table invoice-table" >
                    <thead>
                        <tr>
                            <th style="width:50px"></th>
                            <th >Producto</th>
                            <th style="width:150px">Cantidad</th>
                            <th style="width:150px">Precio </th>
                            <th style="background: #f3f3f4;width:150px">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                       <tr>
                        <td> <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button></td>
                        <td >
                            <select align="left" class="select2_demo_3 asf" name="articulo[]" required="" id="producto1" >
                                <option></option>
                                @foreach($productos as $producto)
                                <option value="{{$producto->id}}" @if($producto->id==$kardex_entradas_registro->id) selected=""@endif >{{$producto->nombre}}- {{$producto->codigo_original}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="background: #f3f3f4"><input type="text" class="form-control" value="{{$kardex_entradas_registro->cantidad_inicial}}"></td>

                        <td><input type="text" class="form-control" value="{{$kardex_entradas_registro->id}}"></td>
                        <td style="background: #f3f3f4"><input type="text" class="form-control" value="{{$kardex_entradas_registro->id}}"></td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <div style="text-align: right;"><button class="btn btn-info">Guardar</button> <button class="btn btn-secondary">Guardar y Finalizar</button></div>
        </div>
        <br>
    </div>
</div>
</div>
</div>
<style type="text/css">
.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 12px;text-align: left;}
.select2-container--default .select2-selection--single { border: none;}

span.select2.select2-container.select2-container--default{
    width: 100%!important;
    background-color: #FFFFFF;
    background-image: none;
    border-radius: 1px;
    display: block;
    padding: 3px 12px;
    border: 1px solid #e5e6e7;
}
</style>

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

<script type="text/javascript">
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar Producto",
        allowClear: true
    });
</script>

@endsection
