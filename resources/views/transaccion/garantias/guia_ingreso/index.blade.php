@extends('layout')

@section('title', 'Garantia - Guia de ingreso')
@section('breadcrumb', 'Guia de ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index'))
@section('value_accion', 'Actualizar')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Crear  <small>Guia de ingreso</small></h5>
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
                            <div class="text-center">
                            <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Agregar</a>
                            </div>
                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Agregar</h3>

                                                    <p>Selecciona marca a agregar</p>

                                                    <form action="{{ route('garantia_guia_ingreso.create') }}"  enctype="multipart/form-data" method="get">
                                                        <div class="form-group"><label>Marca</label>
                                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Familia:</label>
                                                                <div class="col-sm-10">
                                                                    <select class="form-control m-b" name="familia">
                                                                    @foreach($marcas as $marca)
                                                                        <option >{{$marca->nombre}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Enviar</strong></button>

                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
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
                                            <th>Ver</th>
                                            <th>Anular</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($garantias_guias_ingresos as $garantias_guias_ingreso)
                                        {{tiempo($garantias_guias_ingreso->created_at)}}
                                        <tr class="gradeX">
                                            <td>{{$garantias_guias_ingreso->id}}</td>
                                            <td>{{$garantias_guias_ingreso->marca}}</td>
                                            <td>
                                                @if($garantias_guias_ingreso->estado==1)
                                                    Activo
                                                @else
                                                    Anulado 
                                                @endif
                                            </td>
                                            <td>{{$garantias_guias_ingreso->motivo}}</td>
                                            <td>{{$garantias_guias_ingreso->ing_asignado}}</td>
                                            <td>{{$garantias_guias_ingreso->fecha}}</td>
                                            <td>{{$garantias_guias_ingreso->orden_servicio}}</td>
                                            <td>{{$garantias_guias_ingreso->asunto}}</td>
                                            <td>{{$garantias_guias_ingreso->nombre_cliente}}</td>
                                            <td><center><a href="{{ route('garantia_guia_ingreso.show', $garantias_guias_ingreso->id) }}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                            <td><center>

                                                @if( tiempo($garantias_guias_ingreso->created_at) ==1)

                                                    @if($garantias_guias_ingreso->estado==1)

                                                    <a data-toggle="modal" class="btn btn-warning" href="#modal-form{{$garantias_guias_ingreso->id}}">Anular</a>
                                                        <div id="modal-form{{$garantias_guias_ingreso->id}}" class="modal fade" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">¿Seguro que desea ANULAR esta guia? {{$garantias_guias_ingreso->id }}</h3>
                                                                                <p>Esta guia se anulara inmediatamente. Esta acción no se puede deshacer</p>
                                                                                <form action="{{ route('garantia_guia_ingreso.update',$garantias_guias_ingreso->id) }}"  enctype="multipart/form-data" method="post">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <button type="submit" class="btn btn-w-m btn-danger">ANULAR</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @else
                                                        <button class="btn btn-w-m btn-secondary">ANULADO</button>
                                                    @endif

                                                @else
                                                    <button class="btn btn-w-m btn-info">FUERA DE FUNCION</button>
                                                @endif
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