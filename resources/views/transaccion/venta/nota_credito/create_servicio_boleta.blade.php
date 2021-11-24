@extends('layout')

@section('title', 'Nota Credito Servicio Boleta')
@section('breadcrumb', 'Nota Credito Servicio Boleta')
@section('breadcrumb2', 'Nota Credito Servicio Boleta')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="margin-top: -5px;">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{$empresa->ruc}}</h3>
                                <h2>NOTA DE CREDITO BOLETA</h2>
                                <h5> {{$boleta->codigo_boleta}}</h5>
                            </center>
                        </div>
                    </div>
                </div><br>
                <form action="{{route('facturacion_electronica.nota_credito_bol',$boleta->id)}}"  enctype="multipart/form-data" method="post" >
                    @csrf

                    <div class="row">
                        <div class="col-sm-12">
                            <strong>Motivo:</strong>
                            <td><select class="form-control" name="motivo">
                                <option >Devolucion por Item</option>
                                <option >Descuento por Item</option>
                                <option >Anulacion de la operacion</option>
                                <option >Anulacion por error en el RUC</option>
                                <option >Descuento Global</option>
                                <option >Devolucion Ttotal</option>
                                <option >Correcion por error en la descripcion</option>
                                <option >Ajustes - montos y/o fechas de pago</option>
                            </select></td>
                        </div>
                    </div>

                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                <strong>Cliente:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                                @else{{$boleta->cotizacion->cliente->nombre}}
                                @endif <br>
                                <strong>R.U.C:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                                @else{{$boleta->cotizacion->cliente->numero_documento}}
                                @endif <br>
                                <strong>Direccion:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                                @else{{$boleta->cotizacion->cliente->direccion}}
                                @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                                @else{{$boleta->cotizacion->forma_pago->nombre }}
                                @endif  <br>
                                <strong>Tipo de Moneda:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                                @else{{$boleta->cotizacion->moneda->nombre }}
                                @endif <br>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" >
                            <h3>Condiciones Generales</h3>
                            <div align="left">
                                <div class="row">
                                    <strong>Orden de Compra:</strong>
                                    {{$boleta->orden_compra}} <br>
                                    <strong>Guia de Remision:</strong>
                                    {{$boleta->guia_remision}} <br>
                                    <div class="col-sm-6">
                                        <strong>Fecha Emision:</strong>
                                        {{$boleta->fecha_emision}} 
                                    </div>
                                    <div class="col-sm-6">
                                            <strong>Fecha de Vencimiento:</strong>
                                    {{$boleta->fecha_vencimiento }} 
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px ;margin-bottom: 10px">
                                    <div class="col-sm-2" style="padding-right: 0px">
                                        <strong>Motivo:</strong>
                                    </div>
                                    <div class="col-sm-10" style="padding-left: 0px">
                                        <select class="form-control" name="motivo">
                                            <option >Devolucion por Item</option>
                                            <option >Descuento por Item</option>
                                            <option >Anulacion de la operacion</option>
                                            <option >Anulacion por error en el RUC</option>
                                            <option >Descuento Global</option>
                                            <option >Devolucion Ttotal</option>
                                            <option >Correcion por error en la descripcion</option>
                                            <option >Ajustes - montos y/o fechas de pago</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" align="center">
                        <div class="form-control" style="border: none;height: auto" >
                            <div align="left">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ITEM</th>
                                    <th>Codigo Producto</th>
                                    <th  style="width:30px">Cantidad</th>
                                    <th style="width:30px">Cantidad Nueva</th>
                                    <th>Descripción</th>
                                    <th>Precio unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$u=0}} </span>
                                <tr>
                                    @foreach($boleta_registro as $e => $boleta_registros)
                                    <tr>
                                        <td><input class="form-check-input" type="checkbox" id="inlineCheckbox_{{$e}}" name="inlineCheckbox_{{$e}}"  onclick="check('{{$e}}')"></td>
                                        <td >{{$u++}}</td>
                                        <td>{{$boleta_registros->servicio->codigo_servicio}}</td>
                                        <td>{{$boleta_registros->cantidad}}</td>
                                        <td><input required="required" class="form-control" type="text" id="input_disabled_{{$e}}" name="input_disabled_{{$e}}" value="0" disabled></td>
                                        {{-- <td>{{$boleta_registros->producto->unidad_i_producto->medida}}</td> --}}
                                        <td>{{$boleta_registros->servicio->nombre}} <br><strong>N/S:</strong> {{$boleta_registros->numero_serie}}</td>
                                        <td>{{$boleta_registros->precio}}</td>
                                        <td>{{$boleta_registros->precio_unitario_comi* $boleta_registros->cantidad }}</td>
                                        <td style="display: none">
                                            {{-- {{$sub_total=($boleta_registros->factura_ids->op_gravada)+($boleta_registros->factura_ids->op_inafecta)+($boleta_registros->factura_ids->op_exonerada)}}
                                            {{$sub_total_gravado=($boleta_registros->factura_ids->op_gravada)}}
                                            {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                            {{$end=round($sub_total, 2)+round($igv_p, 2)}} --}}
                                        </td>
                                    </tr>
                                   {{--  <span hidden="hidden">{{$i=1}}</span>
                                   <span hidden="hidden">{{$i++}}</span> --}}
                                   @endforeach
                               </tr>

                               <tr>
                                <td colspan="13" align="right"><button type="submit" class="btn btn-w-m btn-primary">Enviar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br><br>
            </form>
        </div>
    </div>
</div>

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


<script>
    var estado=1;
    function check(i){
        if(document.getElementById(`inlineCheckbox_${i}`).value == "false"){
            document.getElementById(`input_disabled_${i}`).disabled = true;
            document.getElementById(`inlineCheckbox_${i}`).value = "true"
        }else{
            document.getElementById(`input_disabled_${i}`).disabled = false;
            document.getElementById(`inlineCheckbox_${i}`).value = "false"
        }
    }
</script>
@endsection
