@extends('layout')

@section('title', 'Usuario')
@section('breadcrumb', 'Usuario')
@section('breadcrumb2', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    @if(isset($mensaje))
    <div>
      <div class="alert alert-primary">
        <div class="alert-link" href="#">
          <li style="color: blue;">{{ $mensaje }}</li>
      </div>
  </div>
</div>
@elseif(isset($mensaje_creacion))
    <div>
      <div class="alert alert-primary">
        <div class="alert-link" href="#">
          <li style="color: blue;">{{ $mensaje_creacion }}Si no ve el Usuario, Haga Click<a href="../">Aqui</a></li>
      </div>
  </div>
</div>
@elseif(isset($error))
    <div>
      <div class="alert alert-danger">
        <div class="alert-link" href="#">
          <li style="color: red;">{{ $error }}</li>
      </div>
  </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Usuarios</h5>
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
                                <th>Personal</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Permisos</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr class="gradeX">
                                <td>{{$usuario->id}}</td>
                                <td>{{$usuario->personal->nombres}}</td>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>
                                @if($usuario->estado == 1)
                                <td>
                                    <center><a {{-- href="{{ route('usuario.permiso', $usuario->id) }}" --}} ><button type="button" class="btn btn-s-m btn-info">Permisos</button></a></center>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$usuario->id}}">Editar</button>
                                    <div class="modal fade" id="exampleModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                    {{-- ccccccccccccccccc --}}
                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                        <form action="{{ route('usuario.update',$usuario->id) }}"  enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <fieldset >
                                                                <legend style="height: 240px;"> <img src="
                                                                    {{ asset('/profile/images/')}}/{{$usuario->personal->foto}}" style="width: 200px;height: 200px;border-radius: 5px"> <br>{{$usuario->personal->nombres}} {{$usuario->personal->apellidos}}
                                                                    <p style="font-size: 15px">{{$usuario->name}}</p></legend>
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                                <label class="col-sm-3 col-form-label">Correo:</label>
                                                                                <div class="col-sm-9"><input type="text" class="form-control" name="correo" value="{{$usuario->email}}"></div>

                                                                                <label class="col-sm-3 col-form-label">Contraseña:</label>
                                                                                <div class="col-sm-9"><input type="password" class="form-control" name="password_new" placeholder="******" ></div>
                                                                                <div class="col-sm-12">
                                                                                    {{-- Boton 2do modal --}}
                                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#2do_modal{{$usuario->id}}">Guardar</button>
                                                                                    <div class="modal fade" id="2do_modal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel"> Confirmar Contraseña para Realizar Cambios</h5>
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                                                                    {{-- ccccccccccccccccc --}}
                                                                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                                                        <fieldset >
                                                                                                            <div>
                                                                                                                <div class="panel-body" >
                                                                                                                    <div class="row">
                                                                                                                        <label class="col-sm-3 col-form-label">Contraseña Usuario:</label>
                                                                                                                        <div class="col-sm-9">
                                                                                                                            <input required="required" type="password" class="form-control" name="contrasena_confirmar" placeholder="******">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </fieldset>
                                                                                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                                                                                        {{--   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- / Modal Create  -->


                                                                                    {{--  --}}
                                                                                    {{-- <button class="btn btn-primary" type="submit">Grabar</button> --}}
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Modal Create  -->

                        </td>
                        @else
                        <td>
                            <center><a><button type="button" class="btn btn-s-m btn-secondary">Permisos</button></a></center>
                        </td>
                        <td>
                            <center><a><button type="button" class="btn btn-s-m btn-secondary">Editar</button></a></center></td>
                            <td>
                                <center>
                                    <form action="{{ route('usuario.activar', $usuario->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-s-m btn-warning">Activar</button>
                                    </form>
                                </center>
                            </td>
                            @endif
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

<style>
    .col-sm-9{padding-bottom: 15px}
    .form-control{border-radius: 5px}
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