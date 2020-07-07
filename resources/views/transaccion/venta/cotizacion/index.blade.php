@extends('layout')

@section('title', 'Cotizacion')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacions')
@section('href_accion', route('cotizacion.create_factura'))
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
                                            <th>Ruc/DNI</th>
                                            <th>Cliente</sth>
                                            <th>N° Cotizacion</th>
                                            {{-- <th>Moneda</th> --}}
                                            <th>Cod. Comision</th>
                                            <th>Fecha</th>
                                            <th>Ver</th> 
                                            <th>Estado</th>
                                            <th>Estado Aprobado</th>
                                            <th>Creado por</th>
                                            <!-- <th>Estado Vigencia</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cotizacion as $cotizacions)
                                        <tr class="gradeX">
                                            <td>{{$cotizacions->id}}</td>
                                            <td>{{$cotizacions->cliente->numero_documento}}</td>
                                            <td>{{$cotizacions->cliente->nombre}}</td>
                                            <td>Proximamte</td>
                                            {{-- <td>{{$cotizacions->moneda->nombre}}</td> --}}
                                            <td>Proximamente</td>
                                            <td>{{$cotizacions->created_at}}</td>
                                            <td><center><a href="{{route('cotizacion.show',$cotizacions->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                            <td>
                                                @if($cotizacions->estado =='0')
                                                   
                                            <button type="button" class="btn btn-w-m btn-info">En Proceso</button>

                                                @else
                                                <button type="button" class="btn btn-w-m btn-default">Procesado</button>
                                                @endif
                                            </td>

                                            <td>
                                                @if($cotizacions->estado_aprovar =='0')

                                                   <form action="{{ route('cotizacion.aprobar', $cotizacions->id)}}" method="POST">
                                                  @csrf 
                                                  @method('put')
                                                   <center>
                                                   <button type="submit" class="btn btn-w-m btn-info">Aprobar</button>
                                              </form>

                                                @else
                                                <button type="button" class="btn btn-w-m btn-default">Aprobado por <br> {{$cotizacions->aprobado->personal->nombres}}</button>
                                                @endif
                                            </td>
                                            <td>{{$cotizacions->user_personal->personal->nombres}}</td>
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
