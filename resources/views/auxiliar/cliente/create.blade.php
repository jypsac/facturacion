@extends('layout')

@section('title', 'Crear Cliente')
@section('breadcrumb', 'Crear Cliente')
@section('breadcrumb2', 'Crear Cliente')
@section('href_accion', route('cliente.index'))
@section('value_accion', 'atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Cliente y Contacto</h5>
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
					<h2>
						Registro de Cliente
					</h2>
					<p>
						y contacto
					</p>
					<form action="{{ route('cliente.store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post">
						@csrf
						<h1>Datos Personales</h1>
						<fieldset>
							<h2>Informacion I</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Nombre *</label>
										<input type="text" class="form-control" name="nombre" class="form-control required">
									</div>

									<div class="form-group">
										<label>Direccion *</label>
										<input type="text" class="form-control" name="direccion" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">

									<div class="form-group">
										<label>correo *</label>
										<input id="email" name="email" type="text" class="form-control required email">
									</div>
									
									<div class="form-group">
										<label>Telefono *</label>
										<input type="number" class="form-control" name="telefono" class="form-control required">
									</div>
									
								</div>
								
							</div>

						</fieldset>
						<h1>Informacion</h1>
						<fieldset>
							<h2>Informacion II</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Celular *</label>
										<input type="number" class="form-control" name="celular" class="form-control required">
									</div>
									<div class="form-group">
										<label>Empresas *</label>
										<input type="text" class="form-control" name="empresa" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Documento Identificacion *</label>
										<select class="form-control m-b" name="documento_identificacion" >
											<option value="dni">DNI</option>
											<option value="pasaporte">Pasaporte</option>
											<option value="ruc">Ruc</option>
										</select>
									</div>
									<div class="form-group">
										<label>Numero de Documento *</label>
										<input type="text" class="form-control" name="numero_documento" class="form-control required">
									</div>
								</div>
							</div>
						</fieldset>

						<h1>Contactos</h1>
						<fieldset>
							<h2>Datos Extra</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Nombre *</label>
										<input id="name" name="nombre_contacto" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Cargo *</label>
										<input id="surname" name="cargo_contacto" type="text" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>	Telefono *</label>
										<input id="email" name="telefono_contacto" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Celular *</label>
										<input id="address" name="celular_contacto" type="text" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>	Correo *</label>
										<input id="email" name="email_contacto" type="text" class="form-control required email">
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

	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
	
	<!-- Jquery Validate -->
	<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

	<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>


    <script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });
       });
    </script>
@stop