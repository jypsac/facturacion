@extends('layout')

@section('title', 'Cotizacion Servicio - Factura')
@section('breadcrumb', 'Cotizacion Servicio - Factura')
@section('breadcrumb2', 'Cotizacion Servicio - Factura')
@section('href_accion', route('cotizacion_servicio.index') )
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
<div style="padding-top: 20px;">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
</div>
@endif


<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1"><i class="fa fa-user-o" aria-hidden="true"></i><span> cliente</span></a>
    {{-- <a href="{{route('cotizacion_servicio.create_boleta')}}" class="icon icon-twitter" ><i style="padding-left: 5px" class="fa fa-male" aria-hidden="true"></i><span> Boleta</span></a> --}}

</div>
<form action="{{ route('cotizacion_servicio.create_factura')}}" enctype="multipart/form-data" id="almacen-form" method="POST">
    @csrf
    <input type="text" value="{{$sucursal->id}}" hidden="hidden" name="almacen">
    <input class="btn btn-sm btn-info" hidden="hidden" type="submit" value="cambiar" >
</form>
<!-- Modal CLiente -->

<div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 100%">
            <!-- Consulta API -->
            <form class="wizard-big" style="margin:20px 20px 20px 20px">
                {{ csrf_field() }}
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label" >Introducir Ruc (Inestable):</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" class="ruc" id="ruc" name="ruc">
                        <button class="btn btn-primary" id="botoncito" class="botoncito"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>

            <script>
                $(function(){
                    $('#botoncito').on('click', function(){
                        var ruc = $('#ruc').val();
                        var url = "{{ url('provedorruc') }}";
                        $('.ajaxgif').removeClass('hide');
                        $.ajax({
                            type:'GET',
                            url:url,
                            data:'ruc='+ruc,
                            success: function(datos_dni){
                                $('.ajaxgif').addClass('hide');
                                var datos = eval(datos_dni);
                                var nada ='nada';
                                if(datos[0]==nada){
                                    alert('DNI o RUC no válido o no registrado');
                                }else{
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

            <form action="{{ route('agregado_rapido.cliente_cotizado') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post" style="margin:0 20px 20px 20px">
                @csrf

                <h1 ><i class="fa fa-user-o" aria-hidden="true"></i></h1>
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label" >Tipo Documento:</label>
                    <div class="col-sm-4">
                        <select class="form-control m-b" name="documento_identificacion" >
                            <option value="Ruc">Ruc</option>
                            <option value="dni">DNI</option>
                            <option value="pasaporte">Pasaporte</option>
                        </select>
                    </div>

                    <label class="col-sm-2 col-form-label">Numero de Documento:</label>
                    <div class="col-sm-4">

                        <input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc" required value="{{ old('numero_documento')}}" autocomplete="off" type="number">
                        <datalist id="browserdoc" >
                            @foreach($clientes as $cliente)
                            <option id="a">{{$cliente->numero_documento}} - existente</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>



                <div class="form-group row" >
                    <label class="col-sm-2 col-form-label" >Cliente:</label>
                    <div class="col-sm-4">



                        <input list="browsersc" class="form-control m-b" name="nombre" id="razon_social" required value="{{ old('nombre')}}" autocomplete="off">
                        <datalist id="browsersc" >
                            @foreach($clientes as $cliente)
                            <option id="a">{{$cliente->nombre}} - existente</option>
                            @endforeach
                        </datalist>

                    </div>

                    <label class="col-sm-2 col-form-label">Direccion:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="direccion" id="domicilio" class="form-control" required value="{{ old('direccion')}}" autocomplete="off">
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" >correo:</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="email" class="form-control" required value="{{ old('email')}}" autocomplete="off">
                    </div>


                </div>


                <input type="submit"class="btn btn-primary" value="Grabar">

            </form>

        </div>
    </div>
</div>
<!-- Fin Modal Clieb¿nte -->

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
                    <form action="{{route('cotizacion_servicio.store_factura',$moneda->id)}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        @method('put')
                        {{-- Cabecera --}}
                        <div class="row">
                            <div class="col-sm-4 text-left" align="left">
                                <address class="col-sm-4" align="left">
                                     <img src="{{asset('img/logos/'.$empresa->foto)}}" alt="" width="300px">
                                </address>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">

                             <div class="form-control" align="center" style="height: auto;">
                                <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
                                <h5>{{$cotizacion_numero}}</h5>
                            </div>
                        </div>
                    </div>
                    <br>
                     <table class="table">
                        <tbody>
                            <tr>
                                <td>Cliente</td>
                                <td>:</td>
                                <td>
                                    <input list="browsersc1" class="form-control m-b" name="cliente" required="required" value="{{ old('nombre')}}" autocomplete="off">
                                    <datalist id="browsersc1" >
                                        @foreach($clientes as $cliente)
                                            <option id="{{$cliente->id}}">{{$cliente->numero_documento}} - {{$cliente->nombre}}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <input type="hidden" value="0" name="print" id="prints">
                                <td>Comisionista</td>
                                <td>:</td>
                                <td>
                                    <input list="browsersc2" class="form-control m-b" id="comisionista" name="comisionista" required value="Sin comision - 0" onkeyup="comision()" autocomplete="off">
                                    <datalist id="browsersc2" >
                                        <option id="">Sin comision - 0 </option>
                                        @foreach($p_venta as $p_ventas)
                                        <option id="{{$p_ventas->id}}">{{$p_ventas->cod_vendedor}} - {{$p_ventas->personal->personal_l->nombres}} - <span style="color: red">{{$p_ventas->comision}}</span></option>
                                        @endforeach
                                    </datalist>
                                </td>
                            </tr>
                            <tr>
                                <td>Forma de pago</td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" name="forma_pago" required="required">
                                        @foreach($forma_pagos as $forma_pago)
                                        <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                        @endforeach
                                        <select>
                                        </td>
                                        <td>Validez</td>
                                        <td>:</td>
                                        <td><select  class="form-control" name="validez" required="required">
                                            <option value="5 Días">5 Días</option>
                                            <option value="4 Días">4 Días</option>
                                            <option value="3 Días">3 Días</option>
                                            <option value="2 Días">2 Días</option>
                                            <option value="1 Día">1 Día</option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Vendedor</td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}">
                                        </td>
                                        <td>Garantia</td>
                                        <td>:</td>
                                        <td><select class="form-control" name="garantia">
                                            <option value="1 año">1 Año</option>
                                            <option value="2 años">2 Años</option>
                                            <option value="3 años">3 Años</option>
                                            <option value="6 meses">6 Meses</option>
                                        </select></td>
                                    </tr>

                                    <tr>
                                        <td>Moneda</td>
                                        <td>:</td>
                                        <td>
                                            <div class="row">
                                                <input type="hidden" name="almacen" class="form-control " value="{{$sucursal->id}}" readonly="readonly">
                                                <div class=" col-sm-5">
                                                    <input type="text" name="moneda" class="form-control " value=" {{$moneda->nombre}}" readonly="readonly">
                                                </div>

                                                <a class="col-sm-5" onclick="event.preventDefault();document.getElementById('almacen-form').submit();">
                                                    <button style="height: 35px;width: auto" type="button" class=' addmores btn btn-info'>@if($moneda->tipo=='nacional')Dolares @elseif($moneda->tipo=='extranjera') Soles @endif</button></a>

                                                </div>

                                            </td>
                                            <td>Fecha de cotizacion</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Observacion</td>
                                            <td>:</td>
                                            <td colspan="4">
                                                <textarea class="form-control" name="observacion" id="observacion"  rows="2"  >Emitimos la siguiente Factura a vuestra solicitud</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div id="resultado_moneda"></div>

                                            <div class="table-responsive">
                                    <table cellspacing="0" class="table tables  ">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                                            <th style="width: 400px;font-size: 13px">Articulo</th>
                                                            <th style="width: 100px;font-size: 13px">Precio</th>
                                                            <th style="width: 100px;font-size: 13px">Cantidad</th>
                                                            <th style="width: 100px;font-size: 13px">Descuento</th>
                                                            <th style="width: 100px;font-size: 13px">Precio U desc</th>
                                                            <th style="width: 100px;font-size: 13px">PU. Com.</th>
                                                            <th style="width: 100px;font-size: 13px">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type='checkbox' class="case">
                                                            </td>
                                                            <td>
                                                                <input list="browsers2" class="form-control " name="articulo[]" class="monto0 form-control" required id='articulo' onkeyup="calcular(this,0);multi(0)" onclick="Clear(this);" autocomplete="off">
                                                                <datalist id="browsers2" >
                                                                    @foreach($servicios as $index => $servicio)
                                                                    <option value="{{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 0 0 {{$servicio->descuento}} {{$array[$index]}}">
                                                                    @endforeach
                                                                </datalist>
                                                                 <textarea  type='text' id='descripcion0'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                                            </td>
                                                            <td>
                                                                <input type='text' id='precio0' name='precio[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                <input type='text' id='cantidad0' name='cantidad[]' class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                {{-- <input type='text' id='descuento0' name='descuento[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" /> --}}
                                                                <div style="position: relative;">
                                                                    <input class="text_des" type='text' id='descuento0' name='descuento[]' readonly="readonly" class="" required  autocomplete="off"/>
                                                                </div>
                                                                <div class="div_check" >
                                                                    <input class="check"  type='checkbox' id='check0' name='check[]' onclick="multi(0)" style="" autocomplete="off"/>
                                                                </div>
                                                                <input type='hidden' id='check_descuento0' name='check_descuento[]'  class="form-control"  required >
                                                            </td>
                                                            <td>
                                                                <input type='text' id='descuento_unitario0' name='descuento_unitario[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                <input type='text' id='comision0' name='comision[]' readonly="readonly" class="form-control" required  autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                <input type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                                            </td>
                                                            <span id="spTotal"></span>
                                                        </tr>

                                                    </tbody><br>
                                                    <tbody>
                                                        <tr style="background-color: #f5f5f500;" align="center">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Subtotal :</td>
                                                            <td><input id='sub_total'  disabled="disabled" class="form-control" required /></td>
                                                        </tr>
                                                        <tr style="background-color: #f5f5f500;" align="center">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>IGV :</td>
                                                            <td><input id='igv'  disabled="disabled" class="form-control" required /></td>
                                                        </tr>
                                                        <tr  align="center">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total :</td>
                                                            <td><input id='total_final'  disabled="disabled" class="form-control" required /></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        {{-- <input type="text" name="facturacion" value="producto"> --}}
                                        <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
                                        <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                                        <button class="btn btn-primary float-right"  onclick="return validacion()" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp;
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
                        </style>

                        <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
                        <script src="{{ asset('js/popper.min.js') }}"></script>
                        <script src="{{ asset('js/bootstrap.js') }}"></script>
                        <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
                        <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

                        <!-- Custom and plugin javascript -->
                        <script src="{{ asset('js/inspinia.js') }}"></script>
                        <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

                        <script>
                            var i = 2;
                            $(".addmore").on('click', function () {
                                var data = `[
                                <tr>
                                <td>
                                <input type='checkbox' class='case'/>
                                </td>";
                                <td>
                                <input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onkeyup="calcular(this,${i});multi(${i});ajax(${i})" onclick="Clear(this);" autocomplete="off" >
                                <datalist id="browsers" >
                                @foreach($servicios as $index => $servicio)
                                <option value="{{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 0 0 {{$servicio->descuento}} {{$array[$index]}}">
                                @endforeach
                                </datalist>
                                <textarea type='text' id='descripcion${i}'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                </td>
                                <td>
                                    <input type='text' id='precio${i}' name='precio[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                                </td>
                                <td>
                                    <input type='text' id='cantidad${i}' name='cantidad[]' class="monto0 form-control" onkeyup="multi(${i})" required  autocomplete="off" />
                                </td>
                                <td>
                                    {{-- <input type='text' id='descuento0' name='descuento[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" /> --}}
                                    <div style="position: relative; ">
                                        <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required  autocomplete="off"/>
                                    </div>
                                    <div class="div_check" >
                                        <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                                    </div>
                                    <input style="width: 76px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
                                </td>

                                <td>
                                <input type='text' id='descuento_unitario${i}' name='descuento_unitario[]' readonly="readonly" class="descuento_unitario${i} form-control"  required  autocomplete="off" />
                                </td>


                                <td>
                                <input type='text' id='comision${i}' name='comision[]' readonly="readonly" class="form-control"  required  autocomplete="off" />
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
                                        url: "{{ route('descripcion_ajax_serv') }}",
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
                                        url: "{{ route('descripcion_ajax_serv') }}",
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
                            function print(){
                                var print_input=1;
                                document.getElementById("prints").value = print_input;
                                var estado = document.querySelector("#prints").value;
            // console.log(estado);
        }

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

            // console.log(comision_v);

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

        function multi(a){


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

            var precio = document.querySelector(`#precio${a}`).value;
            var comision=document.querySelector(`#comision${a}`).value;
            var descuento=document.querySelector(`#descuento${a}`).value;
            var checkBox = document.getElementById(`check${a}`);
            var cantidad = document.getElementById(`cantidad${a}`).value;

            var multiplier = 100;


            if (checkBox.checked == true){
                precio=precio-(precio*descuento/100);
                document.getElementById(`descuento_unitario${a}`).value = precio;
                var descuento_p=precio*comision/100;
                var precio_final=parseFloat(descuento_p)+parseFloat(precio) ;
                var precio_final_redondeado=Math.round(precio_final * multiplier) / multiplier;
                var final_end=precio_final_redondeado*parseFloat(cantidad);

                document.getElementById(`total${a}`).value = final_end;
                document.getElementById(`check_descuento${a}`).value = descuento;
            }else{
                document.getElementById(`descuento_unitario${a}`).value = precio;
                var descuento_p=precio*comision/100;
                var precio_final=parseFloat(descuento_p)+parseFloat(precio) ;

                var precio_final_redondeado=Math.round(precio_final * multiplier) / multiplier;
                var final_end=precio_final_redondeado*parseFloat(cantidad);
                document.getElementById(`check_descuento${a}`).value = 0;
                document.getElementById(`total${a}`).value = final_end;
            }



            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            $('#sub_total').val(total_tt);

            var igv_valor={{$igv->renta}};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv=subtotal*igv_valor/100;

            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end=igv_decimal+parseFloat(subtotal);

            var end2 = Math.round(end * multiplier2) / multiplier2;

            document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;

        }
    </script>

    <script>
        function reverseString(str) {
            return str.split("").reverse().join("");;
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

            document.getElementById(`precio${a}`).value = precio_v;
            document.getElementById(`descuento${a}`).value = descuento_v;
            document.getElementById(`cantidad${a}`).value = 1;
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

            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });
            $('#sub_total').val(total_t);

            var igv_valor={{$igv->renta}};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv=parseFloat(subtotal)*igv_valor/100;
            var end=parseFloat(igv)+parseFloat(subtotal);

            // console.log(typeof igv);
            // console.log(typeof end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;
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

        function Clear(elem)
        {
            elem.value='';
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
        .a{color: red}
    </style>


    @stop
