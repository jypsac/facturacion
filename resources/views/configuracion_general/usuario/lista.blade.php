@extends('layout')

@section('title', 'Usuario Creacion')
@section('breadcrumb', 'Usuario Creacion')
@section('breadcrumb2', 'Usuario Creacion')
@section('href_accion', route('usuario.index'))
@section('value_accion', 'Atras')

@section('content')
@if($errors->any())
<div style="padding-top: 20px;">
      <div class="alert alert-danger">
                <a class="alert-link" href="#">
          @foreach ($errors->all() as $error)
          <li style="color: red">{{ $error }}</li>
          @endforeach
        </a>
            </div>
 </div>
@endif

<div class="wrapper wrapper-content animated fadeInRight">
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Activar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($personales as $personal)
                                <tr class="gradeX">
                                    <td>{{$i++}}</td>
                                    <td>{{$personal->nombres}}</td>
                                    <td>{{$personal->apellidos}}</td>
                                    <td>{{$personal->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$personal->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$personal->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('usuario.creacion',$personal->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                <fieldset >
                                                                    <legend style="height: 250px;"> <img src="
                                                                        {{ asset('/profile/images/')}}/{{$personal->foto}}" style="width: 200px;height: 200px;border-radius: 5px"> <br>{{$personal->nombres}} {{$personal->apellidos}}
                                                                        <p style="font-size: 15px;width: 200px">
                                                                            <select name="name" class="form-control" required="required">
                                                                                <option value="Administrador">Administrador</option>
                                                                                <option value="Colaborador">Colaborador</option>
                                                                            </select>
                                                                        </p>
                                                                    </legend>
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                                <label class="col-sm-2 col-form-label">Correo:</label>
                                                                                <div class="col-sm-10" style="padding-bottom: 10px"><input type="text" class="form-control" name="correo" value="{{$personal->email}}" required="required" autocomplete="off"></div>

                                                                                <label class="col-sm-2 col-form-label">Contraseña:</label>
                                                                                <div class="col-sm-10" style="padding-bottom: 10px"><input type="password" class="form-control" name="password"  autocomplete="off" placeholder="******" required="required"></div>

                                                                                <label class="col-sm-2 col-form-label">Confirmar Contraseña:</label>
                                                                                <div class="col-sm-10" style="padding-bottom: 10px"><input type="password" class="form-control" name="password_2"  autocomplete="off" placeholder="******" required="required"></div>
                                                                                <label class="col-sm-2 col-form-label">Almacen Asignado:</label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-control" name="almacen_id">
                                                                                        @foreach($almacen as $almacens)
                                                                                        <option value="{{$almacens->id}}">{{$almacens->nombre}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <button class="btn btn-primary" type="submit">Registrar</button>
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