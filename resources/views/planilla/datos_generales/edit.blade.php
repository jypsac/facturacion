@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Editar')
@section('breadcrumb2', 'Personal-Editar')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Datos Personales</h5>
                    
				</div>
				<div class="ibox-content">
					
						<form action="{{ route('personal.update',$personales->id) }}"  enctype="multipart/form-data" method="post">
							  @csrf
							@method('PATCH')
						<div class="row">
						<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div>
	                            <div class="panel-body">
									 
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Nombre:</label>
							                    <div class="col-sm-5">
							                     	<input type="text" class="form-control" name="nombres" value="{{$personales->nombres}}">
							                    </div>

											<label class="col-sm-1 col-form-label">Fecha Nacimiento:</label>
												<div class="col-sm-5">
													<input type="date" class="form-control" name="fecha_nacimiento" value="{{$personales->fecha_nacimiento}}">
							                    </div>


							                    
						                </div>
						                <div class="form-group row">
										<label class="col-sm-1 col-form-label">Apellidos:</label>
												<div class="col-sm-5">
													<input type="text" class="form-control" name="apellidos" value="{{$personales->apellidos}}">
							                    </div>
							                    <label class="col-sm-1 col-form-label">Genero:</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="genero">
														
														<option value="femenino">{{$personales->genero}}</option>
														@if($personales->genero == 'femenino')
													    <option value="masculino">masculino</option>
													@elseif($personales->genero == 'masculino')
													    <option value="femenino">femenino</option>
													@endif
													</select>
							                    </div>
						                </div>
						                <div class="form-group row">

											<label class="col-sm-1 col-form-label">Tipo de Documento:</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="documento_identificacion">
														<option value="{{$personales->documento_identificacion}}">{{$personales->documento_identificacion}}</option>
														@if($personales->documento_identificacion == 'DNI')
													    <option value="Pasaporte">Pasaporte</option>
													@elseif($personales->documento_identificacion == 'Pasaporte')
													    <option value="DNI">DNI</option>
													@endif
													</select>
							                    </div>

							                    <label class="col-sm-1 col-form-label">Celular:</label>
							                    <div class="col-sm-5">
							                     	<input type="number" class="form-control" name="celular"  value="{{$personales->celular}}">
							                    </div>

						                </div>
						                 <div class="form-group row">

											<label class="col-sm-1 col-form-label">N° de Documento:</label>
												<div class="col-sm-5">
												<input type="text" class="form-control" name="numero_documento" value="{{$personales->numero_documento}}">
							                    </div>


							                    <label class="col-sm-1 col-form-label">Correo:</label>
												<div class="col-sm-5">
													<input type="email" class="form-control" name="email" value="{{$personales->email}}">
							                    </div>
						                </div>

	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                               Otro Datos
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group row ">

							                <label class="col-sm-2 col-form-label">Estado civil:</label>
												<div class="col-sm-10">
												<select class="form-control m-b" name="estado_civil">
													<option value="{{$personales->estado_civil}}">{{$personales->estado_civil}}</option>
												@if($personales->estado_civil == 'Soltero')
													 <option value="Casado">Casado</option>
									  				 <option value="Viudo con hijos">Viudo con hijos</option>
									  				 <option value="Viudo sin hijos">Viudo sin hijos</option>
												@elseif($personales->estado_civil == 'Casado')
													<option value="Soltero">Soltero</option>
													<option value="Viudo con hijos">Viudo con hijos</option>
									  				<option value="Viudo sin hijos">Viudo sin hijos</option>
									  			@elseif($personales->estado_civil == 'Viudo con hijos')
									  				<option value="Viudo sin hijos">Viudo sin hijos</option>
									  				<option value="Soltero">Soltero</option>
									  				<option value="Casado">Casado</option>
									  			@elseif($personales->estado_civil == 'Viudo sin hijos')
									  				<option value="Viudo con hijos">Viudo con hijos</option>
									  				<option value="Soltero">Soltero</option>
									  				<option value="Casado">Casado</option>
												@endif
													</select>
									  				
							                    </div>

							              
						                </div>

						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label">Profesion:</label>
							                    <div class="col-sm-10">
							                     	<input type="text" class="form-control" name="profesion" value="{{$personales->profesion}}">
							                    </div>

						                </div>
						                 <div class="form-group row">
									 		

							                    <label class="col-sm-2 col-form-label">Nivel Educativo:</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" name="nivel_educativo" value="{{$personales->nivel_educativo}}">
							                    </div>
						                </div>
						                  <div class="form-group row">
									 		<label class="col-sm-2 col-form-label">Direccion:</label>
							                    <div class="col-sm-10">
							                    	<input type="text" class="form-control" name="direccion" value="{{$personales->direccion}}">
							                    </div>

							                    
						                </div>
						                 <div class="form-group row">
									 		 <label class="col-sm-2 col-form-label">Pais:</label>
												<div class="col-sm-10">
									  			<select class="form-control m-b" name="nacionalidad">
										  <option value="{{$personales->nacionalidad }}">{{$personales->nacionalidad }}</option>
										  <option disabled="disabled">------------------------</option>
										  @foreach($paises as $pais)
										<option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>
										@endforeach
										</select>
							                    </div>

							                    
						                </div>
						                 

						        </div>

	                           </div>
	                        </div>
	                        <div class="col-lg-6">

	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Foto Perfil
	                            </div>
	                            <div class="panel-body">
	                        	{{-- 
							      <label class=" col-form-label">Foto De Perfil:</label> --}}
									<div  >
										{{-- <p id="texto">Add file</p> --}}
										<input type="file" id="archivoInput"  name="foto"   onchange="return validarExt()"  />
										
											<div id="visorArchivo">
												<!--Aqui se desplegará el fichero-->
												<center ><img name="foto"  src="{{asset('/profile/images')}}/{{$personales->foto}}" width="390px" height="302px" /></center>
											</div>
													
							                    </div>

	                        </div>
	                        </div>
	                        

		                
								</div>
						<div class="col-lg-12">

                		<center><button class="btn btn-primary" type="submit">Grabar</button></center>
						</div>
					</form>

				</div>
			</div>
		</div>

	</div>
</div>
<style type="text/css">
	.foto{border: none}
</style>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
	<script type="text/javascript">
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
                '<center><img name="foto" src="'+e.target.result+'" width="390px" height="302px" /></center>';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
	</script>

	<script>
			function readURL(input) {
			  if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function(e) {
				  $('#blah').attr('src', e.target.result);
				}
				
				reader.readAsDataURL(input.files[0]);
			  }
			}
			
			$("#imgInp").change(function() {
			  readURL(this);
			});
			</script>
			<script>
		function readURL(input) {
		  if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function(e) {
			  $('#blah').attr('src', e.target.result);
			}
			
			reader.readAsDataURL(input.files[0]);
		  }
		}
		
		$("#imgInp").change(function() {
		  readURL(this);
		});
		</script>

    <script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
					// ¡Siempre permita retroceder incluso si el paso actual contiene campos no válidos!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Prohibir suprimir el paso "Advertencia" si el usuario es demasiado joven
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Limpie si el usuario retrocedió antes
                    if (currentIndex < newIndex)
                    {
                        // Para eliminar estilos de error
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Deshabilite la validación en los campos que están deshabilitados u ocultos.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Iniciar validación; Evite avanzar si es falso
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suprima (omita) el paso "Advertencia" si el usuario tiene edad suficiente.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suprima (omita) el paso "Advertencia" si el usuario tiene la edad suficiente y quiere el paso anterior.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

					// Deshabilita la validación en los campos que están deshabilitados.
                    // En este punto, se recomienda hacer una verificación general (significa ignorar solo los campos deshabilitados)
                    form.validate().settings.ignore = ":disabled";

                    // Iniciar validación; Evitar el envío del formulario si es falso
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Enviar entrada de formulario
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
    <style type="text/css">
    	img{border-radius: 40px}
	                        	
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
@stop