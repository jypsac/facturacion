@extends('layout')

@section('title', 'Vendedores')
@section('breadcrumb', 'Vendedores')
@section('breadcrumb2', 'Vendedores')
@section('href_accion', route('vendedores.create'))
@section('value_accion', 'Agregar')

@section('content')

        <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Vendedores</h5>
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
                                                <th>Cod-Vendedor</th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Nª Documento</th>
                                                <th>Correo</th>
                                                <th>Tipo Trabajador</th>
                                                <th>Comision %</th>
                                                <th>Ver</th>
                                                <th>Estado</th>
                                                {{-- <th>EDITAR</th> --}}
                                                {{-- <th>Eliminar</th> --}}
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($vendedores as $vendedor)
                                            <tr class="gradeX">
                                                <td>{{$vendedor->id}}</td>
                                                <td>{{$vendedor->cod_vendedor}}</td>
                                                <td>{{$vendedor->personal->personal_l->nombres}}</td>
                                                <td>{{$vendedor->personal->personal_l->apellidos}}</td>
                                                <td>{{$vendedor->personal->personal_l->numero_documento}}</td>
                                                <td>{{$vendedor->personal->personal_l->email}}</td>
                                                <td>{{$vendedor->personal->tipo_trabajador}}</td>
                                                <td>% {{$vendedor->comision}}</td>
                                                <td><center><a href="{{ route('vendedores.show', $vendedor->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                                                <td>
                                                    <center>
                                                        @if($vendedor->estado=='0')
                                                        <form action="{{ route('vendedores.estado', $vendedor->id)}}" method="POST">
                                                             @csrf 
                                                             @method('put')
                                                             <input type="text" name="numero" value="1" hidden="hidden">
                                                            <button type="submit" class="btn btn-s-m btn-danger">Desactivar</button>
                                                        </form>
                                                        @elseif($vendedor->estado=='1')
                                                        <form action="{{ route('vendedores.estado', $vendedor->id)}}" method="POST">
                                                             @csrf 
                                                             @method('put')
                                                             <input type="text" name="numero" value="0" hidden="hidden">
                                                            <button type="submit" class="btn btn-s-m btn-success">Activar</button>
                                                        </form>
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
