@extends('layout')

@section('title', 'Boleta Agregar M.Secundaria')
@section('breadcrumb', 'Boleta M.Secundaria')
@section('breadcrumb2', 'Boleta M.Secundaria')
@section('href_accion', route('boleta.index'))
@section('value_accion', 'Atras')
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
@section('content')
@if (session('repite'))
<div class="alert alert-success">
    {{ session('repite') }}
</div>
@endif

@if (session('campo'))
<div class="alert alert-success">
    {{ session('campo') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif


@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'cotizacion')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
<!-- Modal CLiente -->

<div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 100%">
            <!-- Consulta API -->
            <form class="wizard-big" style="margin:20px 20px 20px 20px">
                {{ csrf_field() }}
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Introducir Ruc (Inestable):</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" class="ruc" id="ruc" name="ruc">
                        <button class="btn btn-primary" id="botoncito" class="botoncito"><i
                            class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>

            <script>
                $(function () {
                    $('#botoncito').on('click', function () {
                        var ruc = $('#ruc').val();
                        var url = "{{ url('provedorruc') }}";
                        $('.ajaxgif').removeClass('hide');
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data: 'ruc=' + ruc,
                            success: function (datos_dni) {
                                $('.ajaxgif').addClass('hide');
                                var datos = eval(datos_dni);
                                var nada = 'nada';
                                if (datos[0] == nada) {
                                    alert('DNI o RUC no válido o no registrado');
                                } else {
                                    $('#numero_ruc').val(datos[0]);
                                    $('#razon_social').val(datos[1]);
                                    $('#fecha_actividad').val(datos[2]);
                                    $('#condicion').val(datos[3]);
                                    $('#tipo').val(datos[4]);
                                    $('#estado').val(datos[5]);
                                    $('#fecha_inscripcion').val(datos[6]);
                                    $('#domicilio').val(datos[7]);
                                    $('#emision').val(datos[8]);
                                }
                            }
                        });
                        return false;
                    });
                });
            </script>

            <!-- Fin Consulta API -->

            <form action="{{ route('agregado_rapido.cliente_cotizado') }}" enctype="multipart/form-data" id="form"
            class="wizard-big" method="post" style="margin:0 20px 20px 20px">

            @csrf
            <h1><i class="fa fa-user-o" aria-hidden="true"></i></h1>
            <div class="form-group row ">
                <label class="col-sm-2 col-form-label">Tipo Documento:</label>
                <div class="col-sm-4">
                    <select class="form-control m-b" name="documento_identificacion">
                        <option value="Ruc">Ruc</option>
                        <option value="dni">DNI</option>
                        <option value="pasaporte">Pasaporte</option>
                    </select>
                </div>

                <label class="col-sm-2 col-form-label">Numero de Documento:</label>
                <div class="col-sm-4">

                    <input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc"
                    required value="{{ old('numero_documento')}}" autocomplete="off">
                    <datalist id="browserdoc">
                        @foreach($clientes as $cliente)
                        <option id="a">{{$cliente->numero_documento}} - existente</option>
                        @endforeach
                    </datalist>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Cliente:</label>
                <div class="col-sm-4">


                    <input list="browsersc" class="form-control m-b" name="nombre" id="razon_social" required
                    value="{{ old('nombre')}}" autocomplete="off">
                    <datalist id="browsersc">
                        @foreach($clientes as $cliente)
                        <option id="a">{{$cliente->nombre}} - existente</option>
                        @endforeach
                    </datalist>

                </div>

                <label class="col-sm-2 col-form-label">Direccion:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="direccion" id="domicilio" class="form-control"
                    required value="{{ old('direccion')}}" autocomplete="off">
                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">correo:</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="email" class="form-control" required
                    value="{{ old('email')}}" autocomplete="off">
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Grabar">
        </form>
    </div>
</div>
</div>
<!-- Fin Modal Clieb¿nte -->
<form action="{{ route('boleta.create')}}" enctype="multipart/form-data" id="almacen-form" method="POST">
    @csrf
    <input type="text" value="{{$sucursal->id}}" hidden="hidden" name="almacen">
    <input class="btn btn-sm btn-info" hidden="hidden" type="submit" value="cambiar" >
</form>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Agregar </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{route('boleta.store',[$moneda->id,$boleta_numero])}}" enctype="multipart/form-data" method="post" onsubmit="return valida(this)"  id="form_store">
                        @csrf
                         @method('put')

                        <div class="row">
                            <div class="col-sm-4 text-left" align="left">

                                <address class="col-sm-4" align="left">

                                    <img src="{{asset('img/logos/logo.png')}}" alt="" width="300px">
                                </address>
                            </div>
                            <div class="col-sm-4">
                            </div>

                            <div class="col-sm-4 ">
                                <div class="form-control ruc" style="height: 125px">
                                    <center>
                                        <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                        <h2>BOLETA ELECTRONICA</h2>
                                        <h5>{{$boleta_numero}}</h5>
                                    </center>

                                </div>
                            </div>
                        </div><br>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cliente</td>
                                    <td>:</td>
                                    <td><input list="browsersc1" class="form-control m-b" name="cliente" id="cliente"  required="required" value="{{ old('nombre')}}" autocomplete="off">
                                        <datalist id="browsersc1" >
                                            @foreach($clientes as $cliente)
                                            <option id="{{$cliente->id}}">{{$cliente->numero_documento}} - {{$cliente->nombre}}</option>
                                            @endforeach
                                        </datalist></td>

                                        <td>Comisionista</td>
                                        <td>:</td>
                                        <td> <input list="browsersc2" class="form-control m-b" id="comisionista" name="comisionista" required value="Sin comision - 0" onkeyup="comision()" autocomplete="off">
                                            <datalist id="browsersc2" >
                                                <option id="">Sin comision - 0 </option>
                                                @foreach($p_venta as $p_ventas)
                                                <option id="{{$p_ventas->id}}">{{$p_ventas->cod_vendedor}} - {{$p_ventas->personal->personal_l->nombres}} - <span style="color: red">{{$p_ventas->comision}}</span></option>
                                                @endforeach
                                            </datalist>
                                        </td>
                                    </tr>
<tr>
                                    <td>Orden de compra</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control m-b" name="orden_compra" required  autocomplete="off" value="0">
                                    </td>
                                    <td>Forma de pago</td>
                                    <td>:</td>
                                    <td>
                                         <div class="row">
                                            <div class="col-sm-5">
                                                <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado()">
                                                    @foreach($forma_pagos as $forma_pago)
                                                        <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                                    @endforeach
                                                <select>
                                            </div>
                                            <div class="col-sm-5" id="credito_pago" style="visibility: hidden;">
                                                <button  type="button" class='cuota_modal btn btn-info' id="cuota_modal"  data-toggle="modal" data-target="#cuotas_modal">Cuotas</button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                              <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"   id="alert_campos" style="display: none">
                                                      <strong style="font-size:11px">Rellenar todos los campos</strong>
                                                      <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()" style="padding: 6;">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"  id="suma_campos" style="display: none" >
                                                      <strong style="font-size:11px">La suma de las cuotas exceden el monto total</strong>
                                                      <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()" style="padding: 6;">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="row_number">
                                                        <div class="pago_modal row">
                                                            <div class="col-sm-1"><label>Fecha:</label></div>
                                                            <div class="col-sm-4">
                                                                <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control" >
                                                            </div>
                                                            <div class="col-sm-1"><label>Monto:</label></div>
                                                            <div class="col-sm-4">
                                                                <div class="input-group mb-3" style="padding-right:15px">
                                                                  <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3">{{$moneda->simbolo}}</span>
                                                                  </div>
                                                                  <input type="text" name="monto_pago[]" id="monto_pago0" class="monto_pago form-control"   >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label ><button type="button"  aria-hidden="true" id="add_pago" class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg" > </i></button></label>
                                                        </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                            <tr>
                                                <td>Vendedor</td>
                                                <td>:</td>
                                                <td><input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}"></td>

                                                <td>Guia remision</td>
                                                <td>:</td>
                                                <td> <input type="text" class="form-control" value="0" name="guia_r"></td>


                                            </tr>
                                            <tr>
                                                <td>Moneda</td>
                                                <td>:</td>
                                                <td class="row" style="padding-left: 20px">
                                                    <input type="text" name="moneda" class="form-control col-sm-8" value="{{$moneda->nombre}}" readonly="readonly">&nbsp;
                                                    {{-- <br> --}}
                                                    <input type="hidden" name="almacen" class="form-control col-sm-4" value="{{$sucursal->id}}" readonly="readonly">
                                                    <a onclick="event.preventDefault();
                                                        document.getElementById('almacen-form').submit(); " style="padding-left: 10px;padding-top: 5px ">
                                                        <button type="button" class='addmores btn btn-success'>Cambiar</button>
                                                    </a>
                                                </td>

                                                        <td>Fecha</td>
                                                        <td>:</td>
                                                        <td><input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly"></td>
                                                    </tr>
                                                    <tr>
                                            <td>Tipo de Operacion</td>
                                            <td>:</td>
                                            <td><select class="form-control" name="tipo_operacion" >
                                                @foreach($tipo_operacion as $t_op)
                                                <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                                @endforeach
                                                </select>
                                            </td>
                                            {{-- <td>Fecha de cotizacion</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly">
                                            </td> --}}
                                        </tr>
                                                    <tr>

                                                        <td>Observacion</td>
                                                        <td>:</td>
                                                        <td colspan="4"><textarea class="form-control" name="observacion" id="observacion"  rows="2"  >Emitimos la siguiente Factura a vuestra solicitud</textarea>
                                                        </td>
                                                    </tr>
                                                </div>


                                            </tbody>
                                        </table>

                                        <div class="div table-responsive">

                                            <table   cellspacing="0" class="table tables  " >
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                                        <th style="width: 500px;font-size: 13px">Articulo</th>
                                                        <th>Stock</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Dcto</th>
                                                        <th>PU. Dcto.</th>
                                                        <th>PU. Com.</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type='checkbox' class="case">
                                                        </td>
                                                        <td>
                                                            <input list="browsers2" class="form-control " name="articulo[]"
                                                            class="monto0 form-control" required id='articulo'
                                                            onkeyup="calcular(this,0);multi(0)" autocomplete="off">
                                                            <datalist id="browsers2">
                                                                @foreach($productos as $index => $producto)
                                                                <option
                                                                value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$array_promedio[$index]}} {{$array_cantidad[$index]}} {{$producto->descuento2}} {{$array[$index]}}">
                                                                @endforeach
                                                            </datalist>
                                                            <textarea  type='text' id='descripcion0'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                                            <textarea id='numero_serie0'  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px"></textarea>

                                                        </td>
                                                        <td>
                                                            <input type='text' id='stock0' disabled="disabled" name='stock[]' class="form-control" required  autocomplete="off"/>
                                                        </td>
                                                        <td>
                                                            <input type='number' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
                                                        </td>
                                                        <td>
                                                            <input type='text' id='precio0' name='precio[]' disabled="disabled" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                                        </td>
                                                        <td>
                                                            <div style="position: relative; " > <input class="text_des"type='text' id='descuento0' name='descuento[]' readonly="readonly" class="" required  autocomplete="off"/></div>


                                                            <div  class="div_check" >
                                                                <input class="check"  type='checkbox' id='check0' name='check[]'    onclick="multi(0)" style="" autocomplete="off"/></div>
                                                                <input type='hidden' id='check_descuento0' name='check_descuento[]'  class="form-control"  required >
                                                                <input type='hidden' id='promedio_original0' name='promedio_original[]'  class="form-control"  required >
                                                            </td>
                                                            <td>
                                                                <input type='text' id='precio_unitario_descuento0' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento0 form-control"  required  autocomplete="off" />
                                                            </td>
                                                            {{--                                        <td>--}}
                                                                <input type='hidden' name="1" id='comision0'  disabled="disabled" class="form-control"  required  autocomplete="off" />
                                                            {{--                                        </td>--}}
                                                            <td>
                                                                <input type='text' id='precio_unitario_comision0'  disabled="disabled" class="form-control"  required  autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                <input type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                                            </td>
                                                            <span id="spTotal"></span>
                                                        </tr>

                                                    </tbody>
                                                    <br>
                                                    <tbody>

                                                        <tr align="center">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total :</td>
                                                            <td><input id='total_final' style="width: 76px" name="total_comi" readonly="" class="form-control" required/>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="button" class='delete btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>&nbsp;
                                            <button type="button" class='addmore btn btn-success'><i class="fa fa-plus-square" aria-hidden="true"></i></button>&nbsp;
                                            <button class="btn btn-primary float-right" type="submit"id="boton" name="boton"><i class="fa fa-cloud-upload" aria-hidden="true">Guardar</i></button>&nbsp;


                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .form-control{border-radius: 10px}
                        .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
                        .check{-webkit-appearance: none;height: 34px;background-color: #ffffff00;-moz-appearance: none;border: none;appearance: none;width: 80px;border-radius: 10px;}
                        .div_check{position: relative;top: -33px;left: 0px;background-color: #ffffff00;  top: -35;}
                        .check:checked {background: #0375bd6b;}
                        input[type=number]::-webkit-inner-spin-button,
                        input[type=number]::-webkit-outer-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                        }

                        input[type=number] { -moz-appearance:textfield; }
                    </style>

                    <!-- Mainly scripts -->
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

                    <!-- Jquery Validate -->
                    <script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

                    <!-- Steps -->
                    <script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
                    {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
                    <script>
                        function valida(f) {
                            var boton=document.getElementById("boton");
                            var completo = true;
                            var incompleto = false;
                            if( f.elements[0].value == "" )
                               { alert(incompleto); }
                           else{boton.type = 'button';}
                       }
                   </script>
                   {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
                    <script>
                        var i = 2;
                        $(".addmore").on('click', function () {
                            var data = `[
                            <tr>
                            <td>
                            <input type='checkbox' class='case'/>
                            </td>";
                            <td>
                            <input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onkeyup="calcular(this,${i});multi(${i});ajax(${i})" autocomplete="off">
                            <datalist id="browsers" >
                            @foreach($productos as $index => $producto)
                            <option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$array_promedio[$index]}} {{$array_cantidad[$index]}} {{$producto->descuento2}} {{$array[$index]}}" >
                            @endforeach
                            </datalist>

                            <textarea type='text' id='descripcion${i}'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                            <textarea  id='numero_serie${i}'  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px"></textarea>

                            </td>
                            <td>
                            <input type='text' id='stock${i}' name='stock[]' disabled="disabled" class="form-control" required  autocomplete="off"/>
                            </td>
                            <td>
                            <input type='text' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                            </td>
                            <td>
                            <input type='text' id='precio${i}' name='precio[]' disabled="disabled" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                            </td>
                            <td>
                            <div style="position: relative;" >
                            <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required onkeyup="multi(${i})"  autocomplete="off"/>
                            </div>
                            <div  class="div_check">
                            <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                            </div>
                            <input style="width: 76px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
                            <input type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control"  required >
                            </td>
                            <td>
                            <input type='text' id='precio_unitario_descuento${i}' name='precio_unitario_descuento[]' disabled="disabled" class="form-control"  required  autocomplete="off" />
                            </td>

                            <input type='hidden' name'${i}' id='comision${i}' disabled="disabled" class="form-control"  required  autocomplete="off" />

                            <td>
                            <input type='text' id='precio_unitario_comision${i}' disabled="disabled" class="form-control"  required  autocomplete="off" />
                            </td>

                            <td>
                            <input type='text' id='total${i}' name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
                            </td>

                            </tr>`;
                            $('.tables').append(data);
                            i++;
                        });
                    </script>
                    <script>
                        $('#articulo').change(function(e){
                            e.preventDefault();

                            var articulo = $('[id="articulo"]').val();
                            // var data={articulo:articulo,_token:token};
                                    $.ajax({
                                        type: "post",
                                        url: "{{ route('descripcion_ajax') }}",
                                        data: {
                                            '_token': $('input[name=_token]').val(),
                                            'articulo': articulo
                                            },
                                        success: function (msg) {
                                            // console.log(msg);

                                            $('#descripcion0').val(msg);
                                        }
                                    });
                                });


                        function ajax (a){
                            var articulo2 = $(`[id='articulo${a}']`).val();
                            $.ajax({
                                        type: "post",
                                        url: "{{ route('descripcion_ajax') }}",
                                        data: {
                                            '_token': $('input[name=_token]').val(),
                                            'articulo': articulo2
                                            },
                                        success: function (msg) {
                                            // console.log(msg);

                                            $(`#descripcion${a}`).val(msg);
                                        }
                                    });
                        }
                    </script>

                    <script>

                        function comision(){

            //comision
            var comision=document.querySelector(`#comisionista`).value;
            var separador=" ";
            //revirtiendo la cadena
            var reverse9=reverseString(comision);//devuelve toda la cadena articulo al reves
            //para comision
            var comision_v_r=reverse9.split(separador,1); //devuelve el precio en objeto al revez
            var comision_r=comision_v_r[0];//obtiene el precio del objeto [0] al revez
            var comision_v =reverseString(comision_v_r[0]);//convierte el precio al revez a la normalidad

            var campos_num = document.getElementsByClassName("total").length;

            console.log(comision_v);

            document.getElementById(`comision0`).value = comision_v;

            if(campos_num!=1){
                for(var i=2;i<=campos_num;i++){
                    document.getElementById(`comision${i}`).value = comision_v;
                }
            }
            multi(0);
            if(campos_num!=1){
                for(var i=2;i<=campos_num;i++){
                    multi(i);
                }
            }


        }

        function multi(a) {
            var total = 1;
            var totales=0;
            var change= false; //
            $(`.monto${a}`).each(function(){
                if (!isNaN(parseFloat($(this).val()))) {
                    change= true;

                    total *= parseFloat($(this).val());
                }
            });
            total = (change)? total:0;

            // Get the checkbox
            var checkBox = document.getElementById(`check${a}`);
            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var promedio_origina_descuento1=document.querySelector(`#precio_unitario_descuento${a}`).value;
            var promedio_original2=document.querySelector(`#promedio_original${a}`).value;
            var descuento = document.querySelector(`#descuento${a}`).value;
            var igv = {{$igv->renta}};
            console.log (igv);
            if (checkBox.checked == true && descuento > 0){

                var precio = document.querySelector(`#precio${a}`).value;
                var promedio_original=document.querySelector(`#promedio_original${a}`).value;
                var comision_porcentaje=document.querySelector(`#comision${a}`).value;
                var multiplier = 100;
                var precio_uni=precio-(promedio_original*descuento/100);
                var precio_uni_dec = Math.round((precio_uni+(precio_uni*(igv/100))) * multiplier) / multiplier;

                document.getElementById(`check_descuento${a}`).value = descuento;
                 document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;

                var comisiones9=precio_uni+(precio_uni*comision_porcentaje/100);
                var comisiones = Math.round((comisiones9+(comisiones9*(igv/100))) * multiplier) / multiplier;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones;

                var final=comisiones*cantidad;
                var final_decimal = Math.round(final * multiplier) / multiplier;
                console.log(final_decimal);


                document.getElementById(`total${a}`).value = final_decimal;
            } else {
                var multiplier = 100;
                var descuento = 0;
                var precio = document.querySelector(`#precio${a}`).value;
                // var precio_igv = (Math.round(precio * multiplier) / multiplier)+(precio*igv/100);
                var precio_igv = Math.round((parseFloat(precio)+(precio*(igv/100)))*multiplier)/multiplier;
                var comision_porcentaje=document.querySelector(`#comision${a}`).value;
                var final= cantidad*precio;
                var end9=parseFloat(precio)+((parseFloat(precio)*parseInt(comision_porcentaje)/100));

                var end = Math.round((end9+(end9*(igv/100)))*multiplier)/multiplier;
                var final2=cantidad*end;
                var final_decimal = Math.round(final2 * multiplier) / multiplier;

                console.log("la promedio_origina_descuento1 es:"+  promedio_origina_descuento1);
                console.log("la comision procentaje es:"+  comision_porcentaje);
                console.log("la promedio_original2 procentaje es:"+   promedio_original2);
                console.log("la end es:"+  end);

                document.getElementById(`check_descuento${a}`).value = 0;
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_igv;
                document.getElementById(`precio_unitario_comision${a}`).value = end;
            }

            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function () {
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            $('#total_final').val(total_tt);

            // var igv_valor={{$igv->renta}};
            // $(`#monto_pago0`).attr('max', total_tt);
            // document.getElementById("monto_pago0").value = total_tt;
            var monto_c = document.getElementsByClassName('monto_pago');
            
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                // var input_text = document.getElementById(`${monto}`).value;
                var fin = (total_tt/inp_mont)
                document.getElementById("monto_pago0").value = Math.round(total_tt * multiplier2)/ multiplier2;
                // document.getElementById(`${monto}`).value = total_tt;
            }

        }
    </script>

    <script>
        function reverseString(str) {
            return str.split("").reverse().join("");
            ;
        }

        function calcular(input,a)
        {
            var id = input.id;
            var caracteres = input.value;
            var caracteres_reverse=reverseString(caracteres);
            var cadena=input.value;
            var separador=" ";
            var seprador_total= " / ";
            var id=cadena.split(separador,1);
            //revirtiendo la cadena
            var reverse=reverseString(caracteres);//devuelve toda la cadena articulo al reves
            //para precio
            var precio_v_r=reverse.split(separador,1); //devuelve el precio en objeto al revez
            var precio_r=precio_v_r[0];//obtiene el precio del objeto [0] al revez
            var precio_v =reverseString(precio_v_r[0]);//convierte el precio al revez a la normalidad

            var caracteres_space=caracteres_reverse.replace(precio_r,"");//obtiene la cadena articulo sin precio,pero con un espacio en blanco
            var reverse2=caracteres_space.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para descuento
            var descuento_v_r=reverse2.split(separador,1);////obtiene el descuento del objeto [0] al revez
            var descuento_r=descuento_v_r[0];//obtiene el descuento del objeto [0] al revez
            var descuento_v =reverseString(descuento_v_r[0]);//convierte el descuento al revez a la normalidad

            var caracteres_space_2=reverse2.replace(descuento_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
            var reverse3=caracteres_space_2.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para stock
            var stock_v_r=reverse3.split(separador,1);
            var stock_r=stock_v_r[0];
            var stock_v =reverseString(stock_v_r[0]);

            var caracteres_space_3=reverse3.replace(stock_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
            var reverse4=caracteres_space_3.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para promedio_original
            var prom_v_r=reverse4.split(separador,1);
            var prom_r=prom_v_r[0];
            var prom_v =reverseString(prom_v_r[0]);

            console.log("el promedio original es: "+prom_v);
            console.log("el strock es: "+stock_v+"-------------")

            document.getElementById(`precio${a}`).value = precio_v;
            document.getElementById(`cantidad${a}`).value = 1;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio_v;
            document.getElementById(`promedio_original${a}`).value = prom_v;
            document.getElementById(`stock${a}`).value = stock_v;
            document.getElementById(`descuento${a}`).value = descuento_v;
            document.getElementById(`check_descuento${a}`).value =0;
            var msg2 = parseInt(stock_v) ;
            $(`#cantidad${a}`).attr('max', stock_v );
            //comision
            var comision=document.querySelector(`#comisionista`).value;
            //revirtiendo la cadena
            var reverse9=reverseString(comision);//devuelve toda la cadena articulo al reves
            //para comision
            var comision_v_r=reverse9.split(separador,1); //devuelve el precio en objeto al revez
            var comision_r=comision_v_r[0];//obtiene el precio del objeto [0] al revez
            var comision_v =reverseString(comision_v_r[0]);//convierte el precio al revez a la normalidad
            // console.log(comision_v);
            if(comision){
                document.getElementById(`comision${a}`).value = comision_v;
            }else{
                document.getElementById(`comision${a}`).value = 0;
            }


        }
    </script>

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function () {
                total_t += parseFloat($(this).val());
            });
            $('#sub_total').val(total_t);

            var igv_valor ={{$igv->renta}};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv = parseFloat(subtotal) * igv_valor / 100;
            var end = parseFloat(igv) + parseFloat(subtotal);

            // console.log(typeof igv);
            // console.log(typeof end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;

            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var monto_c = document.getElementsByClassName('monto_pago');
            var multiplier2 = 100;

            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (end/inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end * multiplier2)/ multiplier2; ;
                // document.getElementById(`${monto}`).value = end;
            }
        });
    </script>

    <script>
        function select_all() {
            $('input[class=case]:checkbox').each(function () {
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }
    </script>

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <style type="text/css">
        .a {
            color: #ff0000
        }
    </style>
 <script type="text/javascript">
        function seleccionado(){
            var opt = $('#forma_pago').val();
                if(opt=="1"){
                    // $('#consulta_p_input').prop('disabled', false);
                    
                    document.getElementById('credito_pago').style.visibility = "hidden";
                    // $('#consulta_s').hide();
                }else{
                    // $('#consulta_p_input').prop('disabled', 'disabled');
                    document.getElementById('credito_pago').style.visibility = "initial";
                    // $('#consulta_s_input').prop('disabled', false);
                    // $('#consulta_s').show();
                }
        }
    </script>
      <script>
        var total = document.getElementById('total_final').value;
        var x = 1;
        $(".add_pago").on('click', function () {
        var total = document.getElementById('total_final').value;
        var data = `
        <div class="delete_modal${x} row">
        <div class="col-sm-1"><label>Fecha:</label></div>
        <div class="col-sm-4">
            <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" >
        </div>
        <div class="col-sm-1"><label>Monto:</label></div>
        <div class="col-sm-4">
            <div class="input-group mb-3" style="padding-right:15px">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">{{$moneda->simbolo}}</span>
              </div>
              <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}"    >
            </div>
        </div>
        <div class="col-sm-2">
            <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
        </div>
        </div>`;
        $('.row_number').append(data);
        var inp_mont = document.getElementsByClassName('monto_pago').length;

       // document.getElementById(`monto_pago${x}`).value = (total/inp_mont);

        x++;
        if(inp_mont>6){
            $('.add_pago').attr('disabled');
        }
        var multiplier2 = 100;
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total/inp_mont)
                document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
        }
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
        }else{
            document.getElementById('add_pago').removeAttribute('disabled');
        }
        });
    </script>
    <style type="text/css">
        .a{color: red}
    </style>
    <script type="text/javascript">
        // $(".delete_pago").on('click', function () {
        function eliminar(x){
            $(`.delete_modal${x}`).remove();
            var monto_c = document.getElementsByClassName('monto_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var multiplier2 = 100;

            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;

                var fin = (total/inp_mont)
                document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            if(inp_mont>5){
                document.getElementById('add_pago').setAttribute('disabled', "true");
            }else if(inp_mont == 1){
                document.getElementById("monto_pago0").value = total;
            }else{
                document.getElementById('add_pago').removeAttribute('disabled');
            }
        };
    </script>
<script>
        $("#boton").on("click",function(buton){
            var cliente = document.getElementById("cliente").value;
            console.log(cliente);
           // if(cliente.length != 0){
                var f_p = $('#forma_pago').val();
                var total = document.getElementById('total_final').value;
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                if(f_p == "2" ){
                    var sum = 0;
                    for(g = 0; g<inp_mont;g++){
                        var monto1 = monto_c[g].id;
                        var input_text_2 = document.getElementById(`${monto1}`).value;
                        var sum = parseFloat(sum) + parseFloat(input_text_2);
                    }
                    console.log(sum);
                    if(sum != total){
                        document.getElementById('cuota_modal').click();
                        document.getElementById('suma_campos').style.display = "flex";
                        buton.preventDefault();
                    }
                    for (var i = 0; i < inp_mont; i++) {
                        var fecha = monto_fc[i].id;
                        var monto = monto_c[i].id;
                        var input_text = document.getElementById(`${monto}`).value;
                        var date_text = document.getElementById(`${fecha}`).value;
                        if( input_text.length  == 0 || date_text.length  == 0 ){
                            document.getElementById('cuota_modal').click();
                            document.getElementById('alert_campos').style.display = "flex";
                            buton.preventDefault();
                        }else{
                            document.getElementById('boton').click();
                            // buton.preventDefault();
                        }
                    }
                }else{
                    document.getElementById('boton').click();
                     // buton.preventDefault();
                }
            // buton.preventDefault();
        });

    </script>
    <script >
        function cerrar_but_rc(){
            document.getElementById('alert_campos').style.display = "none";
        }
        function cerrar_but_mt(){
            document.getElementById('suma_campos').style.display = "none";
        }
    </script>
    @stop