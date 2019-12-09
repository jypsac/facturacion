@extends('layout')

@section('title', 'Garantia - Guia de egreso')
@section('breadcrumb', 'Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('consultas.garantias.guias_egreso'))
@section('value_accion', 'Actualizar')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Vista Previa</h5>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Marca</th>
                                            <th>Estado</th>
                                            <th>Motivo</th>
                                            <th>Ing Asignado</th>
                                            <th>fecha</th>
                                            <th>Orden servicio</th>
                                            <th>Asunto</th>
                                            <th>Cliente</th>
                                            <th>Nr Documento Cliente</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($garantias_guias_egresos as $garantias_guias_egreso)
                                        <tr class="gradeX">
                                            <td>{{$garantias_guias_egreso->id}}</td>

                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}}
                                            </td>

                                            <td>
                                                @if($garantias_guias_egreso->estado==1)Activo
                                                @elseAnulado
                                                @endif
                                            </td>
                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}</td>

                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</td>

                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->fecha}}</td>

                                            <td>{{$garantias_guias_egreso->orden_servicio}}
                                            </td>

                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}</td>


                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}</td>

                                            <td>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}</td>

                                            <td><center><a href="{{ route('garantia_guia_egreso.show', $garantias_guias_egreso->id) }}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>


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