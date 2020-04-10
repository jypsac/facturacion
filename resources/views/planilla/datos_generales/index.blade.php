@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal')
@section('breadcrumb2', 'Personal')
@section('href_accion', route('personal.create'))
@section('value_accion', 'Agregar')

@section('content')

        <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Creacion de Almacen</h5>
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
                                                <th>NOMBRE</th>
                                                <th>APELLIDO</th>
                                                <th>NR DOCUMENTO</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th>Estado</th>
                                                <th>Foto</th>
                                                <th>Ver</th>
                                                {{-- <th>EDITAR</th> --}}
                                                {{-- <th>Eliminar</th> --}}
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($personales as $personal)
                                            <tr class="gradeX">
                                                <td>{{$personal->id}}</td>
                                                <td>{{$personal->nombres}}</td>
                                                <td>{{$personal->apellidos}}</td>
                                                <td>{{$personal->numero_documento}}</td>
                                                <td>{{$personal->celular}}</td>
                                                <td>{{$personal->email}}</td>
                                                <td>{{$personal->estado_trabajador_laboral}}</td>
                                                <td><img src="
                                                    {{ asset('/profile/images/')}}/{{$personal->foto}}" style="width: 45px;">
                                                </td>
                                                <td><center><a href="{{ route('personal.show', $personal->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>{{-- 
                                                <td><center><a href="{{ route('personal.edit', $personal->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td> --}}
                                               {{--  <td>
                                                    <center>
                                                        <form action="{{ route('personal.destroy', $personal->id)}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
                                                        </form>
                                                    </center>
                                                </td> --}}
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