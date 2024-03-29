@extends('layout')

@section('title', 'Facturacion Electronica')
@section('breadcrumb', 'Facturacion Electronica')
@section('breadcrumb2', 'Facturacion Electronica')
{{-- @section('href_accion', route('facturacion.create'))
@section('value_accion', 'Agregar') --}}

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    
                        @if(Session::has('successMsg'))
                        <div class="alert alert-success">
                            <a class="alert-link" href="#">{{ session('successMsg') }}</a>
                        </div>
                        @endif
                    
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
                                        <th>Guia Remision</th>
                                        <th>Enviar A Sunat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($facturacion as $facturaciones)
                                    <tr class="gradeX">
                                        <td>{{$facturaciones->id}}</td>
                                        <td>{{$facturaciones->codigo_fac}}</td>
                                        @if(isset($facturaciones->cliente_id)) <!-- Nombre del cliente -->
                                        <td>{{$facturaciones->cliente->nombre}}</td>
                                        @else
                                        <td>{{$facturaciones->cotizacion->cliente->nombre}}</td>
                                        @endif
                                        @if(isset($facturaciones->cliente_id))<!-- documento del cliente -->
                                        <td>{{$facturaciones->cliente->numero_documento}}</td>
                                        @else
                                        <td>{{$facturaciones->cotizacion->cliente->numero_documento}}</td>
                                        @endif
                                        <td>{{$facturaciones->fecha_vencimiento }}</td>
                                        @if($facturaciones->guia_remision=="0")
                                        <td>Sin guia</td>
                                        @else
                                        <td>{{$facturaciones->guia_remision}}</td>
                                        @endif
                                        <td>
                                            <center>
                                                <form action="{{route('facturacion_electronica.factura_sunat')}}" method="POST">
                                                    @csrf
                                                        <input type="hidden" name="factura_id" value="{{$facturaciones->id}}">
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
