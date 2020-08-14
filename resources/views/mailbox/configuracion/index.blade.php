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

					<form action="{{route('configuracion_email.store')}}"  enctype="multipart/form-data" method="post">
						@csrf
						<div class="row">

							<fieldset >
								<legend> Configuracion </legend>

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
												<input type="text" class="form-control" name="smtp" value="smtp.gmail.com">
											</div>

											<label class="col-sm-2 col-form-label">PORT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="port" value="465 " >
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">Encryption:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="encryp" value="587">
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
										<th>Email</th>
										<th>SMTP</th>
										<th>Port</th>
										<th>Encryption</th>
										<th>Editar</th>
									</tr>
								</thead>
								<tbody>
									@foreach($config_email as $config_emails)
									<tr class="gradeX">
										<td>{{$config_emails->id}}</td>
										<td>{{$config_emails->email}}</td>
										<td>{{$config_emails->smtp}}</td>
										<td>{{$config_emails->port}}</td>
										<td>{{$config_emails->encryption}}</td>
										<td>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
												Editar
											</button>
											<!-- Modal -->
											<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel"> Editar Correo</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div style="padding-left: 15px;padding-right: 15px;">
															{{-- ccccccccccccccccc --}}
															<div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

																<form action="{{route('configuracion_email.update',$config_emails->id)}}"  enctype="multipart/form-data" method="post">
																	@csrf
																	@method('PATCH')
																	<div class="row">

																		<fieldset >
																			<legend> Configuracion </legend>

																			<div>
																				<div class="panel-body" align="left">
																					<div class="row">
																						<label class="col-sm-2 col-form-label">Email:</label>
																						<div class="col-sm-10"><input type="text" class="form-control" name="email" value="{{$config_emails->email}}">
																						</div>

																						<label class="col-sm-2 col-form-label">Contraseña:</label>
																						<div class="col-sm-10"><input type="password" class="form-control" value="{{$config_emails->password}}" name="password"></div>
																					</div>

																					<div class="row">
																						<label class="col-sm-2 col-form-label">SMPT:</label>
																						<div class="col-sm-4">
																							<input type="text" class="form-control" name="smtp" value="{{$config_emails->smtp}}">
																						</div>

																						<label class="col-sm-2 col-form-label">PORT:</label>
																						<div class="col-sm-4">
																							<input type="text" class="form-control" name="port" value="{{$config_emails->port}} " >
																						</div>
																					</div>
																					<div class="row">
																						<label class="col-sm-2 col-form-label">Encryption:</label>
																						<div class="col-sm-4">
																							<input type="text" class="form-control" name="encryp" value="{{$config_emails->encryption}}">
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