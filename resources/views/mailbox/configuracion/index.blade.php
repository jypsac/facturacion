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
@if($errors->any())
<div style="padding-top: 10px">
      <div class="alert alert-danger">
            <a class="alert-link" href="#">
	          @foreach ($errors->all() as $error)
	          <li style="color: red">{{ $error }}</li>
	          @endforeach
        	</a>
      </div>
 </div>
@endif
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
											<div class="col-sm-10">
												<div class="input-group m-b">
													<input type="password" class="form-control" name="password" id="txtPassword" required="">
													<div class="input-group-prepend">
														<span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
															<i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i></span>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-2 col-form-label">SMPT:</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="">
												</div>

												<label class="col-sm-2 col-form-label">PORT:</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="port" value="110 " >
												</div>
											</div>
											<div class="row">
												<label class="col-sm-2 col-form-label">Encryption:</label>
												<div class="col-sm-4">
													<select class="form-control" name="encryp" required="">
														<option value="">Ninguno</option>
														<option value="SSL">SSL</option>
														<option value="TLS">TLS</option>
													</select>
												</div>
											</div><br>
											<div class="row">
												<label class="col-sm-2 col-form-label">Firma (opcional):</label>
												<div class="col-sm-10">
													<input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
													<span id="visorArchivo">
														<!--Aqui se desplegará el fichero-->
														<img name="firma"  src="" width="390px" height="200px" />
													</span>



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
		<div class="wrapper wrapper-content animated fadeInRight" >
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
											<th>Firma</th>
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
											<td><img name="firma" style=" transition: width 1.5s;" src="{{asset('/archivos/imagenes/firmas/')}}/{{$config_emails->firma}}" width="100px" height="auto" class='firma' /></td>
											<td><style>.firma:hover{width: 200px}</style>
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edits{{$config_emails->id}}">
													Editar
												</button>
												<!-- Modal -->
												<div class="modal fade" id="edits{{$config_emails->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
																							<div class="col-sm-10">
																								<div class="input-group m-b">
																									<input type="password" class="form-control" value="{{$config_emails->password}}" name="password" id="txtPassword{{$config_emails->id}}">
																									<div class="input-group-prepend">
																										<span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
																											<i class="fa fa-eye-slash "  id="ojo{{$config_emails->id}}" onclick="mostrarPassword{{$config_emails->id}}()"></i>
																										</span>
																									</div>
																								</div>
																							</div>

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
																								<select class="form-control" name="encryp">
																									<option value="{{$config_emails->encryption}}">{{$config_emails->encryption}}</option>
																									<option value="">Ninguno</option>
																									<option value="SSL">SSL</option>
																									<option value="TLS">TLS</option>
																								</select>
																							</div>
																						</div><br>
																						<div class="row">
																							<label class="col-sm-2 col-form-label">Firma (opcional):</label>
																							<div class="col-sm-10">
																								<input type="file" style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;opacity: 0	;" id="archivoInput{{$config_emails->id}}" name="firma" onchange="return validarExt{{$config_emails->id}}()"  />
																								<span id="visorArchivo{{$config_emails->id}}">
																									<!--Aqui se desplegará el fichero-->
																									<img name="firma" src="{{asset('/archivos/imagenes/firmas/')}}/{{$config_emails->firma}}" width="390px" height="200px" />
																									<input type="text" name="firma_nombre" hidden="hidden" value="{{$config_emails->firma}}">
																								</span>
																							</span>



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
										<script type="text/javascript">
											{{-- Fotooos --}}
											function validarExt{{$config_emails->id}}()
											{
												var archivoInput{{$config_emails->id}} = document.getElementById('archivoInput{{$config_emails->id}}');
												var archivoRuta = archivoInput{{$config_emails->id}}.value;
												var extPermitidas = /(.jpg|.png|.jfif)$/i;
												if(!extPermitidas.exec(archivoRuta)){
													alert('Asegurese de haber seleccionado una Imagen');
													archivoInput{{$config_emails->id}}.value = '';
													return false;
												}

												else
												{
        //PRevio del PDF
        if (archivoInput{{$config_emails->id}}.files && archivoInput{{$config_emails->id}}.files[0])
        {
        	var visor = new FileReader();
        	visor.onload = function(e)
        	{
        		document.getElementById('visorArchivo{{$config_emails->id}}').innerHTML =
        		'<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
        	};
        	visor.readAsDataURL(archivoInput{{$config_emails->id}}.files[0]);
        }
    }
}
</script>

<script type="text/javascript">
	{{-- scrpti de ver y ocultar contraseña del Foreach --}}
	function mostrarPassword{{$config_emails->id}}(){
		var cambio = document.getElementById("txtPassword{{$config_emails->id}}");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#ojo{{$config_emails->id}}').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#ojo{{$config_emails->id}}').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}

</script>
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
	p#texto{
		text-align: center;
		color:black;
	}

	input#archivoInput{
		position:absolute;
		top:0px;
		left:0px;
		right:0px;
		bottom:0px;
		width:100%;
		height:100%;
		opacity: 0	;
	}
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
<script type="text/javascript">
												// <div class="col-sm-10">
												// <div class="input-group m-b">
												// <input type="password" class="form-control" name="password" id="txtPassword">
												// <div class="input-group-prepend">
												// <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
												// <i class="fa fa-eye " id="ojo" onclick="mostrarPassword()"></i></span>
												// </div>
												// </div>
												// </div>
												function mostrarPassword(){
													var cambio = document.getElementById("txtPassword");
													if(cambio.type == "password"){
														cambio.type = "text";
														$('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
													}else{
														cambio.type = "password";
														$('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
													}
												}

											</script>
											<script type="text/javascript">
												{{-- Fotooos --}}
												function validarExt()
												{
													var archivoInput = document.getElementById('archivoInput');
													var archivoRuta = archivoInput.value;
													var extPermitidas = /(.jpg|.png|.jfif)$/i;
													if(!extPermitidas.exec(archivoRuta)){
														alert('Asegurese de haber seleccionado una Imagen');
														archivoInput.value = '';
														return false;
													}

													else
													{
        //PRevio del PDF
        if (archivoInput.files && archivoInput.files[0])
        {
        	var visor = new FileReader();
        	visor.onload = function(e)
        	{
        		document.getElementById('visorArchivo').innerHTML =
        		'<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
        	};
        	visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
</script>

@endsection