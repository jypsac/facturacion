@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Agregar')
@section('breadcrumb2', 'Personal-Agregar')
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
				
					<form action="{{ route('personal.store') }}"  enctype="multipart/form-data" method="post">
						@csrf
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
							                     	<input type="text" class="form-control" name="nombres">
							                    </div>

											<label class="col-sm-1 col-form-label">Fecha Nacimiento:</label>
												<div class="col-sm-5">
													<input type="date" class="form-control" name="nombres">
							                    </div>


							                    
						                </div>
						                <div class="form-group row">
										<label class="col-sm-1 col-form-label">Apellidos:</label>
												<div class="col-sm-5">
													<input type="text" class="form-control" name="apellidos">
							                    </div>
							                    <label class="col-sm-1 col-form-label">Genero:</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="genero">
														<option value="masculino">masculino</option>
														<option value="femenino">femenino</option>
													</select>
							                    </div>
						                </div>
						                <div class="form-group row">

											<label class="col-sm-1 col-form-label">Tipo de Documento:</label>
												<div class="col-sm-5">
												<select class="form-control m-b" name="documento_identificacion">
										 				<option>Seleccione</option>
									  					<option value="dni">DNI</option>
									  					<option value="pasaporte">Pasaporte</option>
									  				</select>
							                    </div>

							                    <label class="col-sm-1 col-form-label">Celular:</label>
							                    <div class="col-sm-5">
							                     	<input type="telefono" class="form-control" name="celular">
							                    </div>

						                </div>
						                 <div class="form-group row">

											<label class="col-sm-1 col-form-label">N° de Documento:</label>
												<div class="col-sm-5">
												<input type="text" class="form-control" name="numero_documento">
							                    </div>


							                    <label class="col-sm-1 col-form-label">Correo:</label>
												<div class="col-sm-5">
													<input type="email" class="form-control" name="email">
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
										 				<option>Seleccione</option>
									  					<option value="Soltero">Soltero</option>
									  					<option value="Casado">Casado</option>
									  					<option value="Casado">Viudo con hijos</option>
									  					<option value="Casado">Viudo sin hijos</option>

									  				</select>
							                    </div>

							              
						                </div>

						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label">Profesion:</label>
							                    <div class="col-sm-10">
							                     	<input type="text" class="form-control" name="profesion">
							                    </div>

						                </div>
						                 <div class="form-group row">
									 		

							                    <label class="col-sm-2 col-form-label">Nivel Educativo:</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" name="nivel_educativo">
							                    </div>
						                </div>
						                  <div class="form-group row">
									 		<label class="col-sm-2 col-form-label">Direccion:</label>
							                    <div class="col-sm-10">
							                    	<input type="text" class="form-control" name="direccion">
							                    </div>

							                    
						                </div>
						                 <div class="form-group row">
									 		 <label class="col-sm-2 col-form-label">Pais:</label>
												<div class="col-sm-10">
									  			<select class="form-control m-b" name="nacionalidad">
										  <option>Seleccione</option>
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
									 
									 <div  >
										{{-- <p id="texto">Add file</p> --}}
										<input type="file" id="archivoInput"  onchange="return validarExt()"  />
										
											<div id="visorArchivo">
												<!--Aqui se desplegará el fichero-->
												<center ><img name="foto"  src="https://planetared.com/wp-content/uploads/2018/02/Como-abrir-chrome-siempre-en-incognito-1.png" width="390px" height="302px" /></center>
											</div>
													
							                    </div>
	                        </div>
	                        </div>

		                

                		<button class="btn btn-primary" type="submit">Grabar</button>
</div>
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
                '<center><img name="foto" src="'+e.target.result+'"width="390px" height="302px" /></center>';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
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