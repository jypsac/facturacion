@extends('layout')

@section('title', 'Cierre Periodo')
@section('breadcrumb', 'Cierre Periodo')
@section('breadcrumb2', 'Cierre Periodo')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title" style="padding-right: 25px;padding-left: 25px">
                    <h5></h5>
                    <br>
                    <div class="ibox-tools">

                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-sm-10">

                            </div>
                            <div class="col-sm-2" align="center">
                                <div class="row">
                                    {{-- <div class="col-sm-6" align="right">
                                        <a href="" class="btn btn-success" style="background-color: green;border-color: green"><i class="fa fa-file-excel-o"></i></a>
                                    </div> --}}
                                    <div class="col-sm-12" align="right">
                                        <form action="{{route('cierre-periodo.pdf', $cierre_periodo->id)}}" >
                                    <input type="text" hidden="" name="cierre-periodo-id" value="1">
                                    <button type="submit" class="btn btn-danger" ><i class="fa fa-file-pdf-o"></i></button>
                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <br>
                         <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th colspan="8">
                                        <h3>{{$empresa->nombre}}</h3>
                                        <br>
                                        <h2>REPORTE DE STOCK VALORIZADO</h2>
                                        <br>
                                        <h5>AL: {{$cierre_periodo->mes}}/{{$cierre_periodo->año}}</h5>
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2">Almacen</th>
                                    <th rowspan="2">Almacen Central</th>
                                    <th rowspan="2">Stock Actual</th>
                                    <th rowspan="2"></th>
                                    <th rowspan="2">{{$cierre_periodo->moneda->simbolo}}</th>
                                    <th rowspan="2">Costo</th>
                                    <th>Tipo Cambio:</th>
                                    <th>{{$cierre_periodo->tipo_cambio}}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Valorizacion</th>
                                </tr>
                                <tr>
                                    <th>Cod. Anexo</th>
                                    <th>Nombre del Artículo</th>
                                    <th></th>
                                    <th>Monto</th>
                                    <th></th>
                                    <th>Precio Unitario</th>
                                    <th>{{$moneda1->nombre}} ({{$moneda1->simbolo}}) </th>
                                    <th>{{$moneda2->nombre}} ({{$moneda2->simbolo}}) </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $costo_nacional_total = 0;
                                $costo_extranjero_total = 0;
                                ?>
                                @foreach($cierre_periodo_registro as $cierre_registro)
                                <tr>
                                    <td>{{$cierre_registro->producto->codigo_producto}}</td>
                                    <td>{{$cierre_registro->producto->nombre}}</td>
                                    <td>{{$cierre_registro->cantidad}}</td>
                                    <td>{{$cierre_registro->producto->unidad_i_producto->unidad}}. {{$cierre_registro->producto->unidad_i_producto->simbolo}}</td>
                                    <td>{{ $a = $cierre_periodo->moneda->simbolo}}</td>
                                    <td>
                                        @if( $cierre_periodo->moneda->tipo == 'nacional')
                                           {{$cierre_registro->costo_nacional}}
                                        @else
                                            {{$cierre_registro->costo_extranjero}}
                                        @endif
                                    </td>
                                    <td>{{ $cos_na = ($cierre_registro->costo_nacional*$cierre_registro->cantidad)}}</td>
                                    <td>{{ $cos_ex = ($cierre_registro->costo_extranjero*$cierre_registro->cantidad)}}</td>
                                </tr>
                                <?php
                                    $costo_nacional_total += $cos_na;
                                    $costo_extranjero_total += $cos_ex;
                                ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="6"></td>
                                <td>
                                    {{$costo_nacional_total}}
                                </td>
                                <td>
                                    {{$costo_extranjero_total}}
                                </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
            //     buttons: [
            //         { extend: 'copy'},
            //         {extend: 'csv'},
            //         {extend: 'excel', title: 'ExampleFile'},
            //         {extend: 'pdf', title: 'ExampleFile'},

            //         {extend: 'print',
            //          customize: function (win){
            //                 $(win.document.body).addClass('white-bg');
            //                 $(win.document.body).css('font-size', '10px');

            //                 $(win.document.body).find('table')
            //                         .addClass('compact')
            //                         .css('font-size', 'inherit');
            //         }
            //         }
            //     ]
            // });
        });
    </script>
@endsection