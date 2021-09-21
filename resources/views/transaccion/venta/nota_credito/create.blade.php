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
                                <h2>FACTURA ELECTRONICA</h2>
                                <h5> {{$facturacion->codigo_fac}}</h5>
                            </center>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                <strong>Cliente:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                                    @else{{$facturacion->cotizacion->cliente->nombre}}
                                    @endif <br>
                                <strong>R.U.C:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                                    @else{{$facturacion->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                <strong>Direccion:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                                    @else{{$facturacion->cotizacion->cliente->direccion}}
                                    @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                                    @else{{$facturacion->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                                    @else{{$facturacion->cotizacion->moneda->nombre }}
                                    @endif <br>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" >
                            <h3>Condiciones Generales</h3>
                            <div align="left">
                                <strong>Orden de Compra:</strong>
                                    {{$facturacion->orden_compra}} <br>
                                <strong>Guia de Remision:</strong>
                                    {{$facturacion->guia_remision}} <br>
                                <strong>Fecha Emision:</strong>
                                    {{$facturacion->fecha_emision}} <br>
                                <strong>Fecha de Vencimiento:</strong>
                                    {{$facturacion->fecha_vencimiento }} <br>
    
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
            <form action="{{route('facturacion_electronica.nota_credito',$facturacion->id)}}"  enctype="multipart/form-data" method="post" >
                @csrf
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>x</th>
                            <th>ITEM</th>
                            <th>Codigo Producto</th>
                            <th>Cantidad</th>
                            <th>Cantidad Nueva</th>
                            <th>Unid.Medida</th>
                            <th>Descripción</th>
                            <th>Valor Unitario</th>
                            <th>Dscto.%</th>
                            <th>P. Unitario Desc</th>
                            <th>Comision</th>
                            <th>P. Unitario Com.</th>
                            <th>Valor Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($facturacion_registro as $e => $facturacion_registros)
                            <span hidden="hidden">{{$i=1}} </span>
                            <tr>
                                <td><input class="form-check-input" type="checkbox" id="inlineCheckbox_{{$e}}" name="inlineCheckbox_{{$e}}"  onclick="check('{{$e}}')"></td>
                                <td>{{$i}}</td>
                                <td>{{$facturacion_registros->producto->codigo_producto}}</td>
                                <td>{{$facturacion_registros->cantidad}}</td>
                                <td><input type="text" id="input_disabled_{{$e}}" name="input_disabled_{{$e}}" value="0" disabled></td>
                                <td>{{$facturacion_registros->producto->unidad_i_producto->medida}}</td>
                                <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                <td>{{$facturacion_registros->precio}}</td>
                                <td>{{$facturacion_registros->descuento}}%</td>
                                <td>{{$facturacion_registros->precio_unitario_desc}}</td>
                                <td>{{$facturacion_registros->comision}}%</td>
                                <td>{{$facturacion_registros->precio_unitario_comi}}</td>
                                <td>{{$facturacion_registros->precio_unitario_comi* $facturacion_registros->cantidad }}</td>
                                <td style="display: none">
                                    {{$sub_total=($facturacion_registros->factura_ids->op_gravada)+($facturacion_registros->factura_ids->op_inafecta)+($facturacion_registros->factura_ids->op_exonerada)}}
                                    {{$sub_total_gravado=($facturacion_registros->factura_ids->op_gravada)}}
                                        {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                </td>
                            </tr>
                            <span hidden="hidden">{{$i++}}</span>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <br><br><br><br>

            <h3 align="left">
                <?php $v=new CifrasEnLetras() ;
                $letra=($v->convertirEurosEnLetras($end));
                $letra_final = strstr($letra, 'soles',true);
                $end_final=strstr($end, '.');
                ?>
                Son : {{$letra_final}} {{$end_final}}/100 {{$facturacion->moneda->nombre }}
            </h3>
                <div class="row">
                    <div class="col-sm-8">
    
                    </div>
                    <div class="col-sm-4 form-control">
                        <span style="display: block;float: left"> Sub Total:</span>
                        <span style="display: block;float: right;"> {{$simbologia=$facturacion->moneda->simbolo}}. {{number_format($sub_total, 2)}}</span>
                        <br>
                        <span style="display: block;float: left"> Op. Agravada: </span>
                        <span style="display: block;float: right">{{$simbologia}}. {{number_format($facturacion->op_gravada,2)}}</span><br>
                        <span style="display: block;float: left"> Op. Inafecta: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{ number_format($facturacion->op_inafecta,2)}}</span><br>
                        <span style="display: block;float: left"> Op. Exonerada: </span>
                        <span style="display: block;float: right">{{$simbologia}}. {{number_format($facturacion->op_exonerada,2)}} </span><br>
                        <span style="display: block;float: left"> I.G.V.: </span>
                        <span style="display: block;float: right">{{$facturacion->moneda->simbolo}}.{{number_format(round($igv_p, 2),2)}}</span><br>
                        <span style="display: block;float: left"> Importe Total: </span>
                        <span style="display: block;float: right">{{$facturacion->moneda->simbolo}}.{{$end}}</span>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-8">
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-w-m btn-primary">Enviar</button>
                    </div>
                </div>
            <br> 
            <br>
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

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []

        });

    });

</script>
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
