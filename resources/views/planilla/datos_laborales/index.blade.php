@extends('layout')

@section('title', 'Personal Datos Laborales')
@section('breadcrumb', 'Personal Datos Laborales')
@section('breadcrumb2', 'Personal Datos Laborales')
@section('href_accion', route('personal-datos-laborales.create'))
@section('value_accion', 'Agregar')

@section('content')

        <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>Personal</th>
                                                <th>Estado</th>
                                                <th>Sede</th>
                                                <th>Turno</th>
                                                <th>Cargo</th>
                                                <th>Banco Afiliado</th>
                                                <th>N° Cuenta</th>
                                                <th>Notas</th>
                                                <th>Perfil</th>
                                                {{-- <th>ver</th>
                                                <th>EDITAR</th>
                                                <th>Eliminar</th> --}}
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($personales as $personal)
                                            <tr class="gradeX">
                                                <td>{{$personal->personal_l->nombres}} {{$personal->personal_l->apellidos}}</td>
                                                <td>{{$personal->estado_trabajador}}</td>
                                                <td>{{$personal->sede}}</td>
                                                <td>{{$personal->turno}}</td>
                                                <td>{{$personal->cargo}}</td>
                                                <td>{{$personal->banco_renumeracion}}</td>
                                                <td>{{$personal->numero_cuenta}}</td>
                                                <td>{{$personal->notas}}</td>
                                                <td><img src="
                                                    {{ asset('/profile/images/')}}/{{$personal->personal_l->foto}}" style="width: 45px;">
                                                </td>

                                                {{-- <td><center><a href="{{ route('personal-datos-laborales.show', $personal->id) }}" ><button type="button" class="btn btn-s-m btn-success">ver</button></a></center></td>
                                                <td><center><a href="{{ route('personal-datos-laborales.edit', $personal->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td>
                                                <td>
                                                    <center>
                                                        <form action="{{ route('personal-datos-laborales.destroy', $personal->id)}}" method="POST">
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