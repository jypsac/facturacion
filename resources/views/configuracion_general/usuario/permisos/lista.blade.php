@extends('layout')

@section('title', 'Usuario Permiso')
@section('breadcrumb', 'Permiso de Usuarios')
@section('breadcrumb2', 'Permiso de Usuarios')
@section('href_accion', route('usuario.index'))
@section('value_accion', 'Atras')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
		<div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Permisos</h5>
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
                                                <th><input type="checkbox" name=""id="select_all" ></th>
                                                <th>Nombre del Permiso</th>
                                                <th >Estado</th>
                                                <th ></th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($permisos as $permiso)
                                            <tr class="gradeX">
                                                <td><input type="checkbox" id="" name="select[]"></td>
                                                <td>{{$permiso->name}}</td>
                                                <td>
                                                    <center>
                                                    <form method="POST" action="{{route('usuario.asignar_permiso',$usuario->id)}}">
                                                        @csrf
                                                        <input type="hidden" name="permisos" id="" value="{{$permiso->name}}">
                                                        <input type="submit" class="btn btn-s-m btn-success" value="Activar" />
                                                    </form>

                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                    <form method="POST" action="{{route('usuario.delegar_permiso',$usuario->id)}}">
                                                        @csrf
                                                        <input type="hidden" name="permisos" id="" value="{{$permiso->name}}">
                                                        <input type="submit" class="btn btn-s-m btn-danger" value="Desactivar" />
                                                    </form>

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
        $('#select_all').click(function() {
  var c = this.checked;
  $(':checkbox').prop('checked', c);
});
    </script>


@endsection