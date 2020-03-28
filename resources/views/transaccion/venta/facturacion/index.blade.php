@extends('layout')

@section('title', 'Facturacion')
@section('breadcrumb', 'Facturacion')
@section('breadcrumb2', 'Facturacion')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <!-- modal -->

                            
                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                                <center><div class="col-sm-12 b-r"><h2 align="center" class="m-t-none m-b">Agregar</h2><br>
                                                    <a class="btn btn-info a" href="{{route('facturacion.create')}}">Factura</a>
                                             <a class="btn btn-success a" href="{{route('create.boleta')}}">Boleta</a>

                                                        </div></center>

                                            </div>
                                    </div>
                                    </div>
                                </div>

                <!-- modal fin -->
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
                                            <th>Codigo de Factura</th>
                                            <th>Cliente</th>
                                            <th>Observacion</th>
                                            <th>Ver</th> 
                                            <th>EDITAR</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($facturacion as $facturacions)
                                        <tr class="gradeX">
                                            <td>{{$facturacions->id}}</td>
                                            <td>{{$facturacions->codigo_fac}}</td>
                                            <td>{{$facturacions->cliente}}</td>
                                            <td>{{$facturacions->observacion}}</td>
                                            <td><center><a href="{{route('boleta',$facturacions->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                            <td><center><a href="{{route('facturacion.edit',$facturacions->id)}}" ><button type="button" class="btn btn-w-m btn-success">Editar</button></a></center></td> 
                                            <td><center>
                                            <!--  <form action="" method="POST">
                                              @csrf
                                              @method('delete') -->
                                              <button type="submit" class="btn btn-w-m btn-danger">Anular</button>
                                            <!-- </form> --></center>
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


<style type="text/css">
    .a{width: 200px}
</style>



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
