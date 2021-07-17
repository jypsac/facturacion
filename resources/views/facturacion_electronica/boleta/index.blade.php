@extends('layout')

@section('title', 'Boleta Electronica')
@section('breadcrumb', 'Boleta Electronica')
@section('breadcrumb2', 'Boleta Electronica')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Boleta Electronica</h5>
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

                                        <th>Enviar A Sunat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($boletas as $boleta)
                                    <tr class="gradeX">
                                        <td>{{$boleta->id}}</td>
                                        <td>{{$boleta->codigo_fac}}</td>
                                        @if(isset($boleta->cliente_id)) <!-- Nombre del cliente -->
                                        <td>{{$boleta->cliente->nombre}}</td>
                                        @else
                                        <td>{{$boleta->cotizacion->cliente->nombre}}</td>
                                        @endif
                                        @if(isset($boleta->cliente_id))<!-- documento del cliente -->
                                        <td>{{$boleta->cliente->numero_documento}}</td>
                                        @else
                                        <td>{{$boleta->cotizacion->cliente->numero_documento}}</td>
                                        @endif
                                        <td>{{$boleta->fecha_vencimiento }}</td>
                                        <td>
                                            <center>
                                                <form action="{{route('facturacion_electronica.factura_sunat')}}" method="POST">
                                                    @csrf
                                                        <input type="hidden" name="factura_id" value="{{$boleta->id}}">
                                                        <button type="submit" class="btn btn-w-m btn-primary">Enviar</button>
                                                </form>
                                            </center>
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
