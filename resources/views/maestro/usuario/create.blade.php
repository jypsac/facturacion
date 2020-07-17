@extends('layout')

@section('title', 'Usuario Creacion')
@section('breadcrumb', 'Usuario Creacion')
@section('breadcrumb2', 'Usuario Creacion')
@section('href_accion', route('usuario.index'))
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Datos del Personal</h5>
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
					<form action="{{ route('usuario.creacion',$personal->id) }}"  enctype="multipart/form-data" method="post">
					 	@csrf

					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Nombres del personal:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="nombre" disabled value="{{$personal->nombres}}"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Apellidos del personal:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="apellido" disabled value="{{$personal->apellidos}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre de usuario:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="name"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="correo"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contraseña:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="password"></div>
		                </div>

                		<button class="btn btn-primary" type="submit">Crear Usuario</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection