@extends('layout')

@section('title', 'Facturacion')
@section('breadcrumb', 'Facturacion')
@section('breadcrumb2', 'Facturacion')
@section('href_accion', route('facturacion.create'))
@section('value_accion', 'Agregar')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Creacion de cotizacion</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Codigo de Factura</th>
                                        <th>Cliente</th>
                                        <th>Ruc/DNI</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>Ver</th>
                                        <th>Anular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($facturacion as $facturacions)
                                    <tr class="gradeX">
                                        <td>{{$facturacions->id}}</td>
                                        <td>{{$facturacions->codigo_fac}}</td>
                                        <td>{{$facturacions->cliente->nombre}}</td>
                                        <td>{{$facturacions->cliente->numero_documento}}</td>
                                        <td>{{$facturacions->fecha_vencimiento }}</td>
                                        <td>
                                            <center>
                                                <a href="{{route('facturacion.show',$facturacions->id)}}">
                                                    <button type="button" class="btn btn-w-m btn-primary">VER</button>
                                                </a>
                                            </center>
                                        </td>
                                        <td>
                                            @if($facturacions->estado == '0')
                                                <button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#{{$facturacions->id}}">Anular</button>
                                                <div class="modal fade" id="{{$facturacions->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                                        <div class="modal-content" >
                                                            <div class="modal-body" style="padding: 0px;">
                                                                <div class="ibox-content float-e-margins">
                                                                    <h3 class="font-bold col-lg-12" align="center">
                                                                        ¿Esta Seguro que Deseas Anular la Factura: {{$facturacions->codigo_fac}}".?
                                                                    <br>
                                                                    <h4 align="center">
                                                                        <strong>Nota: Una vez Anulado no hay opcion de devolver la accion </strong>
                                                                    </h4>
                                                                    </h3>
                                                                    <p align="center">
                                                                        <form action="{{ route('facturacion.destroy', $facturacions->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                            <center>
                                                                                <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                                                                            </center>
                                                                        </form>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($facturacions->estado == '1')
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal123">Anulado</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- ESTILOS --}}
<style type="text/css">
    .a{width: 200px}
</style>

    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Page Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>
@endsection
