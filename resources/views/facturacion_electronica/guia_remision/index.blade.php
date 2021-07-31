@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Guia de Remision</h5>
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
                                        <th>Codigo de Guia</th>
                                        <th>Fecha emision</th>
                                        <th>Fecha entrega</th>
                                        <th>Enviar A Sunat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($guia_remisiones as $guia_remision)
                                    <tr class="gradeX">
                                        <td>{{$guia_remision->id}}</td>
                                        <td>{{$guia_remision->cod_guia}}</td>
                                        <td>{{$guia_remision->fecha_emision}}</td>
                                        <td>{{$guia_remision->fecha_entrega}}</td>
                                        <td>
                                            <center>
                                                <form action="{{route('facturacion_electronica.guia_remision_sunat')}}" method="POST">
                                                    @csrf
                                                        <input type="hidden" name="factura_id" value="{{$guia_remision->id}}">
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
