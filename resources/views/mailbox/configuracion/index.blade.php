@extends('layout')
@section('title', 'Configuracion Email')
@section('breadcrumb', 'Configuracion Email')
@section('breadcrumb2', 'Configuracion Email')

@if($user->email_creado==0)
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar Configuracion')
@elseif($user->email_creado== 1)
@endif

@section('content')
<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> Configracion de Correo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div style="padding-left: 15px;padding-right: 15px;">
				{{-- ccccccccccccccccc --}}
				<div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

					<form action=""  enctype="multipart/form-data" method="post">

						<div class="row">

							<fieldset >
								<legend> Configracion </legend>

								<div>
									<div class="panel-body" align="left">
										<div class="row">
											<label class="col-sm-2 col-form-label">Email:</label>
											<div class="col-sm-10"><input type="text" class="form-control" name="email">
											</div>

											<label class="col-sm-2 col-form-label">Contraseña:</label>
											<div class="col-sm-10"><input type="password" class="form-control" name="password"></div>
										</div>

										<div class="row">
											<label class="col-sm-2 col-form-label">SMPT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="smpt" value="smtp.gmail.com">
											</div>

											<label class="col-sm-2 col-form-label">PORT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="port" value="465 " >
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">Encryption:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="ssl" value="587">
											</div>

										</div>
										<br>
									</div>

								</fieldset>


							</div>

							<button class="btn btn-primary" type="submit">Grabar</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- / Modal Create  -->



	<div class="wrapper wrapper-content animated fadeInRight">
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
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>@foreach($config_email as $config_emails)
									<tr class="gradeX">
										<td>{{$config_emails->id}}</td>
										<td>{{$config_emails->nombre}}</td>
										<td>{{$config_emails->simbolo}}</td>
										<td>{{$config_emails->codigo}}</td>
										<td><center><a href="{{ route('configuracion_email.show', $config_emails->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
										<td><center><a href="{{ route('configuracion_email.edit', $config_emails->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td>
										<td>
											<center>
												<form action="{{ route('configuracion_email.destroy', $config_emails->id)}}" method="POST">
													@csrf
													@method('delete')
													<button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
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
	<style>
		.form-control{margin-top: 5px; border-radius: 5px}
	</style>

	<!-- Mainly scripts -->
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

	<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
	@endsection
