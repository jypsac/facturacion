@extends('layout')

@section('title', 'Cotizacion - Boleta M.principal')
@section('breadcrumb', 'Cotizacion - Boleta M.principal')
@section('breadcrumb2', 'Cotizacion - Boleta M.principal')
@section('href_accion', route('cotizacion.index') )
@section('value_accion', 'Atras')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1">
        <i class="fa fa-user-o" aria-hidden="true"></i><span> cliente</span>
    </a>
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

            <form  enctype="multipart/form-data" id="form"
            class="wizard-big"  style="margin:0 20px 20px 20px">

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


            <input type="submit"class="btn btn-primary" value="Grabar" id="enviar">

        </form>
        <script>
            $("#enviar").click(function (e) {
                e.preventDefault();
                var documento_identificacion = $('[name="documento_identificacion"]').val();
                var numero_documento = $('[name="numero_documento"]').val();
                var nombre = $('input:text[name=nombre]').val();
                var direccion = $('input:text[name=direccion]').val();
                var email = $('input:text[name=email]').val();
                var token = '{{csrf_token()}}';// ó $("#token").val() si lo tienes en una etiqueta html.

                var data={documento_identificacion:documento_identificacion,numero_documento:numero_documento,nombre:nombre,direccion:direccion,email:email,_token:token};
                $.ajax({
                    type: "post",
                    url: "{{ route('agregado_rapido.cliente_cotizado') }}",
                    data: data,
                    success: function (msg) {
                        var mensaje;
                        var opcion = confirm("Se ha registrado con exito el cliente, desea cargar la pagina para ver los cambios");
                        if (opcion == true) {
                            location.reload();
                        }else{
                            mensaje = "Has clickado Cancelar";
                        }
                        document.getElementById("ejemplo").innerHTML = mensaje;
                    }
                });
            });
        </script>

    </div>
</div>
</div>
<form action="{{ route('cotizacion.create_boleta_ms')}}" enctype="multipart/form-data" id="almacen-form" method="POST">
    @csrf
    <input type="text" value="{{$sucursal->id}}" hidden="hidden" name="almacen">
    <input class="btn btn-sm btn-info" hidden="hidden" type="submit" value="cambiar" >
</form>
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
                    <form action="{{route('cotizacion.store_boleta',$moneda->id)}}" enctype="multipart/form-data" method="post">
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
                                            <div class="col-sm-9">
                                                <input type="text" name="moneda" class="form-control" value="{{$moneda->nombre}}" readonly="readonly">
                                                <input type="hidden" name="almacen" class="form-control" value="{{$sucursal->id}}" readonly="readonly">
                                            </div>
                                            <div class="col-sm-1">
                                                <a onclick="event.preventDefault();document.getElementById('almacen-form').submit();">
                                                    <button style="height: 35px;width: auto" type="button" class='addmores btn btn-info'>@if($moneda->tipo=='nacional')Dolares @elseif($moneda->tipo=='extranjera') Soles @endif</button></a>
                                                </div>
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
                                            <textarea class="form-control" name="observacion" id="observacion"  rows="2"  >Emitimos la siguiente Boleta a vuestra solicitud</textarea>
                                        </td>
                                    </tr>
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

                                            </td>
                                            <td>
                                                <input type='text' id='stock0' disabled="disabled" name='stock[]' class="form-control" required  autocomplete="off"/>
                                            </td>
                                            <td>
                                                <input type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
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
                                                <td>Total :</td>
                                                <td colspan="2"><input id='total_final' disabled="disabled" class="form-control" required/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class='delete btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>&nbsp;
                                <button type="button" class='addmore btn btn-success'><i class="fa fa-plus-square" aria-hidden="true"></i></button>&nbsp;
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true">Guardar</i></button>&nbsp;


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
                    <input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onkeyup="calcular(this,${i});multi(${i});ajax(${i})" autocomplete="off">
                <datalist id="browsers" >
                @foreach($productos as $index => $producto)
                <option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$array_promedio[$index]}} {{$array_cantidad[$index]}} {{$producto->descuento1}} {{$array[$index]}}" >
                @endforeach
                </datalist>
                <textarea type='text' id='descripcion${i}'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>

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
                <input type='text' id='precio_unitario_descuento${i}' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento${i} form-control"  required  autocomplete="off" />
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

            if (checkBox.checked == true){
                var descuento = document.querySelector(`#descuento${a}`).value;
                var precio = document.querySelector(`#precio${a}`).value;
                var promedio_original=document.querySelector(`#promedio_original${a}`).value;
                var comision_porcentaje=document.querySelector(`#comision${a}`).value;
                var multiplier = 100;
                var precio_uni=precio-(promedio_original*descuento/100);
                var precio_uni_dec=Math.round(precio_uni * multiplier) / multiplier;

                document.getElementById(`check_descuento${a}`).value = descuento;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;

                var comisiones9=precio_uni_dec+(promedio_original*comision_porcentaje/100);
                var comisiones=Math.round(comisiones9*multiplier)/multiplier;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones;

                var final=comisiones*cantidad;
                var final_decimal = Math.round(final * multiplier) / multiplier;
                console.log(final_decimal);
                document.getElementById(`total${a}`).value = final_decimal;
            } else {
                var multiplier = 100;
                var descuento = 0;
                var precio = document.querySelector(`#precio${a}`).value;
                var comision_porcentaje=document.querySelector(`#comision${a}`).value;
                var final= cantidad*precio;
                var end9=parseFloat(precio)+(parseFloat(promedio_original2)*parseInt(comision_porcentaje)/100);

                var end =Math.round(end9 * multiplier) / multiplier;
                var final2=cantidad*end;
                var final_decimal = Math.round(final2 * multiplier) / multiplier;

                console.log("la promedio_origina_descuento1 es:"+  promedio_origina_descuento1);
                console.log("la comision procentaje es:"+  comision_porcentaje);
                console.log("la promedio_original2 procentaje es:"+   promedio_original2);
                console.log("la end es:"+  end);

                document.getElementById(`check_descuento${a}`).value = 0;
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio;
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
            // var subtotal = document.querySelector(`#sub_total`).value;
            // var igv=subtotal*igv_valor/100;

            // var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            // var end=igv_decimal+parseFloat(subtotal);

            // var end2 = Math.round(end * multiplier2) / multiplier2;

            // document.getElementById("igv").value = igv_decimal;
            // document.getElementById("total_final").value = end2;

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


    @stop