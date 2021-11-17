@extends('layout')

@section('title', ' Boleta- Servicio')
@section('breadcrumb', ' Boleta- Servicio')
@section('breadcrumb2', ' Boleta- Servicio')
@section('href_accion', route('cotizacion_servicio.index') )
@section('value_accion', 'Atras')
@extends('layout_agregado_rapido')
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


{{-- Boton para modal de Clientes --}}
@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'boleta')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
{{--Fin Boton para modal de Clientes --}}

<form action="{{ route('boleta_servicio.create_ms')}}" enctype="multipart/form-data" id="almacen-form" method="POST">
    @csrf
    <input type="text" value="{{$sucursal->id}}" hidden="hidden" name="almacen">
    <input class="btn btn-sm btn-info" hidden="hidden" type="submit" value="cambiar" >
</form>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">
                    <form action="{{route('boleta_servicio.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                       @csrf
                       {{-- @method('put') --}}
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
                            <h2 style="font-size: 19px">BOLETA ELECTRONICA</h2>
                            <h5>{{$boleta_numero}}</h5>
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
                                <input list="browsersc1" class="form-control m-b" name="cliente" required="required"  autocomplete="off">
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
                                            <textarea class="form-control" name="observacion" id="observacion"  rows="1"  >Emitimos la siguiente cotización a vuestra solicitud</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div id="resultado_moneda"></div>

                            <div class="table-responsive">
                                <table   cellspacing="0" class="table tables  " {{-- style="width: 1150px" --}}>
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">{{-- <input class='check_all' type='checkbox' onclick="select_all()" /> --}}</th>
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
                                                <button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </td>
                                            <td>
                                                <select class="monto0 select2_demo_3 select_change" name="articulo[]" required="" id="articulo"  onchange="calcular(this,0);multi(0);selet_one()"  autocomplete="off">
                                                    <option value=""></option>
                                                    @foreach($servicios as $index => $servicio)
                                                        <option value="{{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$prc_afec[$index] = strtok($servicio->tipo_afec_i_serv->informacion," ")}} {{$igv_precio[$index]}} 0 {{$servicio->descuento}} {{$array[$index]}}">
                                                            {{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                    <textarea  type='text' id='descripcion0'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                                    <input style="width: 76px" hidden="" type='text' id='tipo_afec0' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off"  />
                                                    <input type="hidden" class="celda"  name="articulo[]" id="input_prod1" >
                                                </td>
                                                <td>
                                                    <input type='text' id='precio0' name='precio[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" />
                                                </td>
                                                <input type="text" hidden="" id='prom_ori0' name='prom_ori[]' onclick="multi(0)">
                                                <td>
                                                    <input type='text' id='cantidad0' name='cantidad[]' class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                                </td>
                                                <td>
                                                    {{-- <input type='text' id='descuento0' name='descuento[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" /> --}}
                                                    <div style="position: relative; " > <input class="text_des"type='text' id='descuento0' name='descuento[]' readonly="readonly" class="" required  autocomplete="off"/>
                                                    </div>
                                                    <div class="div_check" >
                                                       <input class="check"  type='checkbox' id='check0' name='check[]' onclick="multi(0)" style="" autocomplete="off"/>
                                                   </div>
                                                   <input type='hidden' id='check_descuento0' name='check_descuento[]'  class="form-control"  required >
                                               </td>
                                               <td>
                                                <input type='text' id='descuento_unitario0' name='descuento_unitario[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" />
                                            </td>
                                            {{-- <td> --}}
                                                <input type='text' hidden="" id='comision0' name='comision[]' readonly="readonly" class="form-control" required  autocomplete="off" />
                                            {{-- </td> --}}
                                            <td>
                                                <input type='text' id='precio_unitario_comision0'  disabled="disabled" class="form-control"  required  autocomplete="off" />
                                            </td>
                                            <td>
                                                <input type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                                <input type='text' id='afectacion0'  style="width: 76px"  name='afectacion' disabled="disabled" class="afectacion form-control " hidden=""  required  autocomplete="off"/>
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>

                                    </tbody><br>
                                    <tbody>

                                        <tr  align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total :</td>
                                            <td><input id='total_final'  name="total_comi" class="form-control" required readonly="" /></td>
                                        </tr>
                                    </tbody>
                                </table>

                                &nbsp;
                                <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;

                                <button class="btn btn-primary float-right" id="boton" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true" > Guardar</i></button>&nbsp;


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
            label.col-form-label::marker{
                list-style:none;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                font-size: 12px;
            }
            .select2-container--default .select2-selection--single {
                border: none;
            }
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
                <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
                {{-- scritp de modal agregar --}}
                <script type="text/javascript">
                    $(".select2_demo_3").select2({
                        placeholder: "Seleccionar Servicio",
                    });
                </script>
    {{-- / --}}
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
            <button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
            </td>
            <td>
            <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="calcular(this,${i});multi(${i});ajax(${i});seleccion_options(${i})"  autocomplete="off">
                <option ></option>
                @foreach($servicios as $index => $servicio)
                    <option value="{{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$prc_afec[$index] = strtok($servicio->tipo_afec_i_serv->informacion," ")}} {{$igv_precio[$index]}} 0 {{$servicio->descuento}} {{$array[$index]}}">
                        {{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}} 
                    </option>
                @endforeach
            </select>
            <textarea type='text' id='descripcion${i}'  name='descripcion[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
            <input type='text' style="width: 76px"  id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required hidden  autocomplete="off" />
             <input type="hidden"    class="celda"  name="articulo[]" id="input_prod${i}">
            </td>
            <td>
            <input type='text' id='precio${i}' name='precio[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
             <input type="hidden" hidden="" id="prom_ori${i}" name="prom_ori[]" onclick="multi(${i})">
            <td>
            <input type='text' id='cantidad${i}' name='cantidad[]' class="monto0 form-control" onkeyup="multi(${i})" required  autocomplete="off" />
            </td>

            <td>
            {{-- <input type='text' id='descuento0' name='descuento[]' readonly="readonly" class="monto0 form-control" required  autocomplete="off" /> --}}
            <div style="position: relative; " > <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required  autocomplete="off"/>
            </div>
            <div class="div_check" >
            <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
            </div>
            <input style="width: 76px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
            </td>

            <td>
            <input type='text' id='descuento_unitario${i}' name='descuento_unitario[]' readonly="readonly" class="form-control"  required  autocomplete="off" />
            </td>

            <input type='hidden' name="comision[]" id='comision${i}'  style="width: 76px"  readonly="readonly" class="form-control"  required  autocomplete="off" />

            <td>
                <input type='text' id='precio_unitario_comision${i}' name="precio_unitario_comision[]" disabled="disabled" class="form-control"  required  autocomplete="off" />
            </td>
            <td>
            <input type='text' id='total${i}' name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
            <input type='text' id='afectacion${i}'  style="width: 76px" hidden  name='afectacion' disabled="disabled" class="afectacion form-control "  required  autocomplete="off"/>
            </td>

            </tr>`;
            $('.tables').append(data);
            i++;
            var input_ds = [];
            var number_tot = document.getElementsByName('articulo[]').length;
            for( j = 0; j < number_tot; j++){
                input_ds[j]  = document.getElementsByName('articulo[]')[j].value;
                $('option[value="'+input_ds[j]+'"]').prop("disabled", true);
            };
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Servicio",
            });
            $(".addmore").prop("disabled", true);
            $(".borrar").prop("disabled", false);
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
                    const msg2 = msg.slice(2);
                    $('#descripcion0').val(msg2);
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
                 const msg2 = msg.slice(2);
                $(`#descripcion${a}`).val(msg2);
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
            var prom_ori = document.querySelector(`#prom_ori${a}`).value;
            var afec = document.querySelector(`#tipo_afec${a}`).value;

            var multiplier = 100;
            var igv = {{$igv->renta}};

            if (checkBox.checked == true){
                var precio = document.querySelector(`#precio${a}`).value;
                var promedio_original=document.querySelector(`#prom_ori${a}`).value;
                var comision_porcentaje=document.querySelector(`#comision${a}`).value;
                document.getElementById(`check_descuento${a}`).value = descuento;
                var multiplier = 100;
                var precio_uni=precio-(promedio_original*descuento/100);

                if(afec.toString() == "Gravado"){
                    var precio_uni_dec= Math.round((precio_uni+(precio_uni*(igv/100)))* multiplier) / multiplier;
                    var comisiones9=precio_uni+(precio_uni*comision_porcentaje/100);
                    var comisiones = Math.round((comisiones9+(comisiones9*(igv/100)))* multiplier) / multiplier;

                    var final=comisiones*cantidad;
                    var final_decimal = Math.round(final * multiplier) / multiplier;

                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
               }else{
                    var precio_uni_dec= Math.round((precio_uni)* multiplier) / multiplier;
                    var comisiones9=precio_uni+(precio_uni*comision_porcentaje/100);
                    var comisiones = Math.round((comisiones9)* multiplier) / multiplier;

                    var final=comisiones*cantidad;
                    var final_decimal = Math.round(final * multiplier) / multiplier;

                    document.getElementById(`total${a}`).value = final_decimal;
                   document.getElementById(`afectacion${a}`).value = final_decimal;
               }
                document.getElementById(`descuento_unitario${a}`).value = precio_uni_dec;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones;
            }else{
                var multiplier = 100;
                var descuento = 0;
                var precio = document.querySelector(`#precio${a}`).value;
                var comision_porcentaje=document.querySelector(`#comision${a}`).value;

                if(afec.toString() == "Gravado"){

                    var final= cantidad*precio;
                    var end9=parseFloat(precio)+(parseFloat(precio)*parseInt(comision_porcentaje)/100);
                    var end = Math.round((end9+(end9*(igv/100))) * multiplier) / multiplier;
                    var final2=cantidad*end;
                    var final_decimal = Math.round(final2 * multiplier) / multiplier;

                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
               }else{

                    var final= cantidad*precio;
                    var end9=parseFloat(precio)+(parseFloat(precio)*parseInt(comision_porcentaje)/100);
                    var end = Math.round(end9 * multiplier) / multiplier;
                    var final2=cantidad*end;
                    var final_decimal = Math.round(final2 * multiplier) / multiplier;

                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
               }

                document.getElementById(`descuento_unitario${a}`).value = end;
                document.getElementById(`precio_unitario_comision${a}`).value = end;
                document.getElementById(`check_descuento${a}`).value = 0;
            }



            var totalInp = $('[name="afectacion"]');
            var total_t = 0;

            totalInp.each(function(){
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

            var caracteres_space_2=reverse2.replace(descuento_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
            var reverse3=caracteres_space_2.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para stock
            var stock_v_r=reverse3.split(separador,1);
            var stock_r=stock_v_r[0];
            var stock_v =reverseString(stock_v_r[0]);

            var caracteres_space_3=reverse3.replace(stock_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
            var reverse4=caracteres_space_3.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio

            var prom_v_r=reverse4.split(separador,1);
            var prom_r=prom_v_r[0];
            var prom_v =reverseString(prom_v_r[0]);
             //tipo de afectacion
            var caracteres_space_4 = reverse4.replace(prom_r,"");
            var reverse5 = caracteres_space_4.slice(1);
            // tipo de afectacion
            var afec_prec_tot=reverse5.split(separador,1);
            var afec_pre_r=afec_prec_tot[0];
            var afec_pre_v =reverseString(afec_prec_tot[0]);
            document.getElementById(`tipo_afec${a}`).value =  afec_pre_v;
            document.getElementById(`prom_ori${a}`).value = prom_v;
            document.getElementById(`precio${a}`).value = precio_v;
            document.getElementById(`descuento${a}`).value = descuento_v;
            document.getElementById(`cantidad${a}`).value = 1;
            //comision
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
        $(document).on('click', '.borrar', function (event) {
           event.preventDefault();
            var e = document.getElementsByClassName("e").length;
            
            var fila = $(this).parents("tr");
            var input_text_opt = fila.find('input[class="celda"]').val();
            $('option[value="'+input_text_opt+'"]').prop("disabled", false);
            $(".addmore").prop("disabled", false);
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Servicio",
            });
            // ELIMINAR TR
           // fila.remove();
           if (e>1) {
                fila.closest('tr').remove();
                $(".borrar").prop("disabled", true);
                $(".addmore").prop("disabled", false);
            }else{
                $(".borrar").prop("disabled", false);
                $(".addmore").prop("disabled", false);
            }

            var multiplier = 100;
            var totalInp = $('[name="afectacion"]');
            var total_t = 0;

            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });
            var tot_rou = Math.round(total_t * multiplier)/multiplier;
            $('#total_final').val(tot_rou);

            var igv_valor={{$igv->renta}};
            var subtotal = document.querySelector(`#total_final`).value;
            var igv1=parseFloat(subtotal)*igv_valor/100;
            var igv= Math.round(igv1 * multiplier)/ multiplier;
            var end1=parseFloat(igv)+parseFloat(subtotal);
            var end=Math.round(end1 * multiplier)/ multiplier;

            // console.log(typeof igv);
            // console.log(typeof end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;
        });
    </script>

{{--     <script>
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
    </script> --}}

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
    <script>

        function seleccion_options(b){
            var cant_opt = document.getElementById(`articulo${b}`).length;
            var count_input = document.getElementsByClassName('celda').length;

            var option = document.getElementById(`articulo${b}`);
            var valor_select = option.value;
            if(valor_select == ""){
                document.getElementById(`input_prod${b}`).value = valor_select;
                $('option[value="'+valor_select+'"]').prop( "disabled", true);
            }else{
                var ant_val = document.getElementById(`input_prod${b}`).value;
                $('option[value="'+ant_val+'"]').prop( "disabled", false);
                $('option[value="'+valor_select+'"]').prop( "disabled", true);
                document.getElementById(`input_prod${b}`).value = valor_select;

                $(".addmore").prop("disabled", false);
            }
            if(cant_opt-1 == count_input ){
                    $(".addmore").prop("disabled", true);
                }else{
                    $(".addmore").prop("disabled", false);
                }
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Servicio",
            });
        }
  </script>
    <script  >
    function selet_one(){
        var cant_opt = document.getElementById(`articulo`).length;
        var count_input = document.getElementsByClassName('celda').length;
        var option = document.getElementById(`articulo`);
        var valor_select = option.value;
        if(valor_select == ""){
            document.getElementById(`input_prod1`).value = valor_select;
            $('option[value="'+valor_select+'"]').prop( "disabled", true);
        }else{
            var ant_val = document.getElementById(`input_prod1`).value;
            $('option[value="'+ant_val+'"]').prop( "disabled", false);
            $('option[value="'+valor_select+'"]').prop( "disabled", true);
            document.getElementById(`input_prod1`).value = valor_select;
            $(".addmore").prop("disabled", false);
            if(cant_opt-1 == count_input ){
                $(".addmore").prop("disabled", true);
            }else{
                $(".addmore").prop("disabled", false);
            }

        }
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Servicio",
        });
    }

    </script>

    @stop
