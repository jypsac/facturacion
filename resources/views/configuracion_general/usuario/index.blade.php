@extends('layout')

@section('title', 'Usuario')
@section('breadcrumb', 'Usuario')
@section('breadcrumb2', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    @if($errors->any())

    <div style="padding-top: 20px;">
       <div class="alert alert-danger">
        <a class="alert-link" href="#">
          @foreach ($errors->all() as $error)
          <li class="error">{{ $error }}</li>
          @endforeach
      </a>
  </div>
</div>
@endif
@if(isset($errores))
<div>
  <div class="alert alert-danger">
    <div class="alert-link" href="#">
      <li style="color: red;">{{ $errores }}</li>
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
                                <th>Cargo</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Almacen Asignado</th>
                                <th>Activo/desactivo</th>
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
                                <td>{{$usuario->celular}}</td>
                                <td>{{$usuario->almacen->nombre}}</td>
                                @if($usuario->estado == 1)
                                <td>Activo</td>
                                @elseif($usuario->estado == 0)
                                <td>Desactivo</td>
                                @endif
                                <td>
                                    <center><a {{-- href="{{ route('usuario.permiso', $usuario->id) }}" --}} ><button type="button" class="btn btn-s-m btn-info">Permisos</button></a></center>
                                </td>
                                @if($usuario->estado_validacion == 1)
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$usuario->id}}">Editar</button> <i class="fa fa-check" aria-hidden="true"></i>
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
                                                                                <label class="col-sm-3 col-form-label">Celular:</label>
                                                                                <div class="col-sm-9"><input type="text" class="form-control" name="celular" value="{{$usuario->celular}}"></div>
                                                                                <label class="col-sm-3 col-form-label">Almacen Asignado:</label>
                                                                                <div class="col-sm-4">
                                                                                    <select class="form-control" name="almacen_id">
                                                                                        <option value="{{$usuario->almacen->id}}">{{$usuario->almacen->nombre}}</option>
                                                                                        <option value="" disabled="">-------------</option>
                                                                                        @foreach($almacen as $almacens)
                                                                                        <option value="{{$almacens->id}}">{{$almacens->nombre}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <label class="col-sm-3 col-form-label">Activo/desactivo:</label>
                                                                                <div class="col-sm-2">
                                                                                    @if($usuario->estado == 1)
                                                                                    <div class="switch-button">
                                                                                        <input type="checkbox" name="estado" id="switch-label{{$usuario->id}}" class="switch-button__checkbox" checked="">
                                                                                        <label for="switch-label{{$usuario->id}}" class="switch-button__label"></label>
                                                                                    </div>
                                                                                    @else
                                                                                    <div class="switch-button">
                                                                                        <input type="checkbox" name="estado" id="aswitch-label{{$usuario->id}}" class="switch-button__checkbox" >
                                                                                        <label for="aswitch-label{{$usuario->id}}" class="switch-button__label"></label>
                                                                                    </div>
                                                                                    @endif

                                                                                </div>

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
                                                                                                                            <input type="text" name="contrasena_adm" value="{{auth()->user()->password}}" hidden="">
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
                        @elseif($usuario->estado_validacion == 0)
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$usuario->id}}">Editar</button> <i class="fa fa-times" aria-hidden="true"></i>
                            <div class="modal fade" id="exampleModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="width: 550px">
                                        <div style="padding-left: 15px;padding-right: 15px;">
                                            {{-- ccccccccccccccccc --}}
                                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                <form action="{{ route('usuario.envio_codigo',$usuario->id) }}"  enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <fieldset >
                                                        <legend style="height: 240px;"> <img src="
                                                            {{ asset('/profile/images/')}}/{{$usuario->personal->foto}}" style="width: 200px;height: 200px;border-radius: 5px"> <br>{{$usuario->personal->nombres}} {{$usuario->personal->apellidos}}
                                                            <p style="font-size: 15px">{{$usuario->name}}</p></legend>
                                                            <div>
                                                                <div class="panel-body" >
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Correo:</label>
                                                                        <div class="col-sm-6"><input type="text" class="form-control" name="correo" value="{{$usuario->email}}"></div>
                                                                        <div class="col-sm-3" style="padding-bottom: 15px"> <input type="submit" name="accion" class="btn btn-s-m btn-info" value="Cambiar Correo"></div>
                                                                        <label class="col-sm-3 col-form-label">Codigo de Confirmacion:</label>
                                                                        <div class="col-sm-3"><input type="text" class="form-control" name="cod_1" maxlength="3"></div>
                                                                        <div class="col-sm-3"><input type="text" class="form-control" name="cod_2"  maxlength="3"></div>
                                                                        <div class="col-sm-3"><input type="text" class="form-control" name="cod_3"  maxlength="3"></div>

                                                                        <div class="col-sm-12">
                                                                            <p>No me ha llegado el Codigo de confirmacion<input type="submit" name="accion" class="reenviar"  value="Reenviar Codigo" style="border: none;background: #ff000000;"> </p>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                           <input type="submit" name="accion" class="btn btn-s-m btn-info" value="Validar">
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
    .reenviar{transition: 0.2s;color: #f72f2f}
    .reenviar:hover{color: #676a6c}
    .col-sm-9{padding-bottom: 15px}
    .form-control{border-radius: 5px}
    :root {
        --color-button: #fdffff;
    }
    .switch-button {
        display: inline-block;
        padding-top: 9px;
        padding-right: 30px;
    }
    .switch-button .switch-button__checkbox {
        display: none;
    }
    .switch-button .switch-button__label {
        background-color:#1f1f1f66;
        width: 2rem;
        height: 1rem;
        border-radius: 3rem;
        display: inline-block;
        position: relative;
    }
    .switch-button .switch-button__label:before {
        transition: .6s;
        display: block;
        position: absolute;
        width: 1rem;
        height: 1rem;
        background-color: var(--color-button);
        content: '';
        border-radius: 50%;
        box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
        background-color: #1c84c6;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
        transform: translateX(1rem);
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