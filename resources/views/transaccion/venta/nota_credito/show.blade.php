@extends('layout')

@section('title', 'Nota Credito')
@section('breadcrumb', 'Nota Credito')
@section('breadcrumb2', 'Nota Credito')
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
                                <h2>NOTA DE CREDITO</h2>
                                @if($estado==0)
                                    <h5>{{$notas_credito->nota_i_facturacion->codigo_fac}}</h5>
                                @else
                                    <h5>{{$notas_credito->nota_i_boleta->codigo_fac}}</h5>
                                @endif
                            </center>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                @if($estado==0)
                                    <strong>Cliente:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->nombre}}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->numero_documento}}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->direccion}}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->forma_pago->nombre }}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->moneda->nombre }}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->moneda->nombre }}
                                    @endif<br>
                                @else
                                    <strong>Cliente:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->nombre}}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->numero_documento}}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->direccion}}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->forma_pago->nombre }}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->moneda->nombre }}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->moneda->nombre }}
                                    @endif<br>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" >
                            <h3>Condiciones Generales</h3>
                            <div align="left">
                                @if($estado==0)
                                    <strong>Orden de Compra:</strong>
                                    {{$notas_credito->nota_i_facturacion->orden_compra}}<br>
                                    <strong>Guia de Remision:</strong>
                                    {{$notas_credito->nota_i_facturacion->guia_remision}}<br>
                                    <strong>Fecha Emision:</strong>
                                    {{$notas_credito->nota_i_facturacion->fecha_emision}}<br>
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{$notas_credito->nota_i_facturacion->fecha_vencimiento}}<br>
                                @else
                                    <strong>Orden de Compra:</strong>
                                    {{$notas_credito->nota_i_boleta->orden_compra}}<br>
                                    <strong>Guia de Remision:</strong>
                                    {{$notas_credito->nota_i_boleta->guia_remision}}<br>
                                    <strong>Fecha Emision:</strong>
                                    {{$notas_credito->nota_i_boleta->fecha_emision}}<br>
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{$notas_credito->nota_i_boleta->fecha_vencimiento}}<br>
                                @endif
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
                                    <th>ITEM</th>
                                    <th>Codigo Producto</th>
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                    <th>Precio unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$u=0}} </span>
                                <tr>
                                    @foreach($notas_credito_registros as $e => $notas_credito_registro)
                                        <tr>
                                            <td>{{$u++}}</td>
                                            <td>{{$notas_credito_registro->producto->codigo_producto}}</td>
                                            <td>{{$notas_credito_registro->cantidad}}</td>
                                            <td>{{$notas_credito_registro->producto->nombre}} <br><strong>N/S:</strong>{{$notas_credito_registro->numero_serie}}</td>
                                            <td>{{$notas_credito_registro->precio}}</td>
                                            <td>{{$notas_credito_registro->precio_unitario_comi* $notas_credito_registro->cantidad }}</td>
                                            <td style="display: none">
                                                {{-- {{$sub_total=($notas_credito_registro->factura_ids->op_gravada)+($notas_credito_registro->factura_ids->op_inafecta)+($notas_credito_registro->factura_ids->op_exonerada)}}
                                                {{$sub_total_gravado=($notas_credito_registro->factura_ids->op_gravada)}}
                                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                                {{$end=round($sub_total, 2)+round($igv_p, 2)}} --}}
                                            </td>
                                        </tr>
                                    @endforeach
                               </tr>

                               <tr>
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br><br>
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
