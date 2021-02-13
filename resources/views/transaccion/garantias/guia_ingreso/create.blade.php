@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('vue_js',  asset('js/app.js') )
@section('content')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1"><i class="fa fa-user-o" aria-hidden="true"></i><span style="font-size:15px;padding-left:4px"> cliente</span></a>
    <a class="icon icon-twitter" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg2"><i style="padding-left: 5px" class="fa fa-male" aria-hidden="true"></i><span style="font-size:15px;padding-left:4px">personal</span></a>
</div>
 <!-- MODAL CLIENTE -->
<div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content" style="width: 100%">
		<form action="{{ route('agregado_rapido.cliente_store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post" style="margin:0 20px 20px 20px">
		@csrf
			<h1 ><i class="fa fa-user-o" aria-hidden="true"></i></h1>
		 	<div class="form-group row ">
		 		<label class="col-sm-2 col-form-label" >Tipo Documento:</label>
                <div class="col-sm-4">
                 	<select class="form-control m-b" name="documento_identificacion" >
						<option value="dni">DNI</option>
						<option value="pasaporte">Pasaporte</option>
						<option value="ruc">Ruc</option>
					</select>
                </div>
                <label class="col-sm-2 col-form-label">Numero de Documento:</label>
				<div class="col-sm-4">
					<input list="browserdoc" class="form-control m-b" name="numero_documento" required value="{{ old('numero_documento')}}"/>
					<datalist id="browserdoc" >
						@foreach($clientes as $cliente)
							<option id="a">{{$cliente->numero_documento}} - existente</option>
						@endforeach
			 		</datalist>
                </div>
			</div>
            <div class="form-group row" >
		 		<label class="col-sm-2 col-form-label" >Cliente:</label>
                <div class="col-sm-4">
					<input list="browsersc" class="form-control m-b" name="nombre" required value="{{ old('nombre')}}"/>
					<datalist id="browsersc" >
						@foreach($clientes as $cliente)
							<option id="a">{{$cliente->nombre}} - existente</option>
						@endforeach
			 		</datalist>
                </div>
                <label class="col-sm-2 col-form-label">Direccion:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="direccion" class="form-control" required value="{{ old('direccion')}}">
                </div>
            </div>
            <div class="form-group row">
		 		<label class="col-sm-2 col-form-label" >Celular:</label>
                    <div class="col-sm-4">
                    	<input type="telefono" class="form-control" name="celular" class="form-control" required value="{{ old('celular')}}">							        </div>

                    <label class="col-sm-2 col-form-label">Telefono:</label>
					<div class="col-sm-4">
							<input type="telefono" class="form-control" name="telefono" class="form-control"required value="{{ old('telefono')}}">
                    </div>
            </div>
            <div class="form-group row">
		 		<label class="col-sm-2 col-form-label" >correo:</label>
                <div class="col-sm-4">
                	<input type="email" class="form-control" name="email" class="form-control" required value="{{ old('email')}}">
            	 </div>
            </div>
			<h1><i class="fa fa-address-book-o" aria-hidden="true"></i></h1>
            <div class="form-group row">
		 		<label class="col-sm-2 col-form-label" >Nombre Contacto:</label>
            	<div class="col-sm-4">
						<input id="name" name="nombre_contacto" type="text" class="form-control" required value="{{ old('nombre_contacto')}}">
                </div>
                <label class="col-sm-2 col-form-label">Cargo Contacto:</label>
				<div class="col-sm-4">
					<input id="surname" name="cargo_contacto" type="text" class="form-control" required value="{{ old('cargo_contacto')}}">
                </div>
            </div>
            <div class="form-group row" style="">
		 		<label class="col-sm-2 col-form-label" >Telefono Contacto:</label>
                    <div class="col-sm-4">
						<input id="email" name="telefono_contacto" type="text" class="form-control" required value="{{ old('telefono_contacto')}}">
                     </div>
                    <label class="col-sm-2 col-form-label">Celular Contacto:</label>
					<div class="col-sm-4">
						<input id="address" name="celular_contacto" type="text" class="form-control" required value="{{ old('celular_contacto')}}">
                    </div>
            </div>
            <div class="form-group row">
		 		<label class="col-sm-2 col-form-label" >Correo Contacto:</label>
                <div class="col-sm-4">
					<input id="email" name="email_contacto" type="text" class="form-control email" 	required value="{{ old('email_contacto')}}">
                 </div>
            </div>
			<input type="submit"class="btn btn-primary" value="Grabar">
		</form>
	  </div>
	</div>
</div>
<br>
  <!-- MODAL Personal -->
<div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  	aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  	<div class="modal-content" style="width: 100%">
			<form action="{{ route('agregado_rapido.personal_store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post" style="margin:20px">
			@csrf
			<h1 ><i class="fa fa-user-o" aria-hidden="true"></i></h1>
			<style type="text/css">
				.xd{    margin-bottom: 0px;}
				h1{margin-bottom: 0px;}
			</style>
		 	<div class="form-group row">
		 		<label class="col-sm-2 col-form-label" >Nombre:</label>
                <div class="col-sm-4">
                 	<input type="text" class="form-control" name="nombres" required>
                </div>
                 <label class="col-sm-2 col-form-label">Apellidos:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="apellidos" required>
                </div>
            	<label class="col-sm-2 col-form-label">Fecha Nacimiento:</label>
				<div class="col-sm-4">
					<input type="date" class="form-control" name="fecha_nacimiento" required>
                </div>
                <label class="col-sm-2 col-form-label">Genero:</label>
				<div class="col-sm-4">
					<select class="form-control m-b" name="genero">
						<option value="masculino">masculino</option>
						<option value="femenino">femenino</option>
					</select>
                </div>
		                <label class="col-sm-2 col-form-label">Estado Civil:</label>
				<div class="col-sm-4">
					<select class="form-control m-b" name="estado_civil">
						<option value="Soltero">Soltero</option>
						<option value="Casado">Casado</option>
						<option value="Viudo con hijos">Viudo con hijos</option>
						<option value="Viudo sin hijos">Viudo sin hijos</option>
					</select>
                </div>
            </div>
            <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></h1>
            <div class="form-group row xd">
		 		<label class="col-sm-2 col-form-label" >Tipo Documento:</label>
                <div class="col-sm-4"><select class="form-control m-b" name="documento_identificacion">
					<option value="dni">DNI</option>
					<option value="pasaporte">Pasaporte</option>
					<option value="ruc">RUC</option>
				</select>
				</div>
                <label class="col-sm-2 col-form-label">N° de Doc:</label>
				<div class="col-sm-4">
						<input type="text" class="form-control" name="numero_documento" required>
                </div>
            </div>
            <div class="form-group row xd">
                <label class="col-sm-2 col-form-label" >Direccion:</label>
                <div class="col-sm-4">
						<input type="text" class="form-control" name="direccion" required>
                 </div>
                <label class="col-sm-2 col-form-label">Pais:</label>
				<div class="col-sm-4">
					<select class="form-control m-b" name="nacionalidad" required>
						<option>Seleccione</option>
						@foreach($paises as $pais)
							<option value="{{ $pais->nombre }}" >{{ $pais->nombre }}</option>
						@endforeach
					</select>
                </div>
            </div>
			<h1><i class="fa fa-graduation-cap" aria-hidden="true"></i></h1>
            <div class="form-group row">
	            <label class="col-sm-2 col-form-label" >Nivel Educativo:</label>
                <div class="col-sm-4">
					<input type="text" class="form-control" name="nivel_educativo" required>
                </div>
	 			<label class="col-sm-2 col-form-label" >Profesion:</label>
                <div class="col-sm-4">
                	<input type="text" class="form-control" name="profesion" required>
              	</div>
            </div>
			<h1><i class="fa fa-phone" aria-hidden="true"></i></h1>
            <div class="form-group row">
            	<label class="col-sm-2 col-form-label" >Telefono:</label>
            	<div class="col-sm-4">
					<input type="telefono" class="form-control" name="telefono" required>
                </div>
		 		<label class="col-sm-2 col-form-label" >Celular:</label>
                <div class="col-sm-4">
					<input type="telefono" class="form-control" name="celular" required>
                 </div>
            </div>
            <div class="form-group row" style="">
                <label class="col-sm-2 col-form-label">Correo:</label>
				<div class="col-sm-4">
						<input type="email" class="form-control" name="email" required>
                </div>
            </div>
			<input type="submit"class="btn btn-primary" value="Grabar"/>
			</form>
  		</div>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	@if($errors->any())
	<div class="alert alert-danger">
        <a class="alert-link" href="#">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</a>
    </div>
	@endif
	<div class="row">
		<div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-title">
					<h5>Crear</h5>
		        </div>
	            <div class="ibox-content" style="padding-bottom: 0px">
	            	<div class="row">
						<div class="col-lg-12">
   							<form action="{{route('garantia_guia_ingreso.store')}}"  enctype="multipart/form-data" 	method="post" onsubmit="return valida(this)">
							@csrf
								<div class="ibox-content" style="" align="center">
								    <div class="row">
								        <fieldset class="col-sm-6">
											<legend>Datos<br>Generales</legend>
											<div class="panel panel-default">
												<div class="panel-body" align="left">
													<div class="row">
														<label class="col-sm-2 col-form-label">Marca:</label>
														<div class="col-sm-4">
															<input type="text" class="form-control" name="marca_id" value="{{$marca_nombre}}" readonly>
							                    		</div>
							                    		<label class="col-sm-2 col-form-label">Motivo:</label>
							                            <div class="col-sm-4">
							                            	<select class="form-control m-b" name="motivo">
													    		<option value="Garantia">Garantia</option>
													    		<option value="Servicio">Servicio</option>
													    		<option value="Informativo">Informativo</option>
													    		<option value="Reingreso">Reingreso</option>
															</select>
														</div>
													</div>
													<div class="row">
														<label class="col-sm-2 col-form-label">Orden de servicio:</label>
						                               <div class="col-sm-4">
						    	                            <input type="text" class="form-control" name="orden_servicio" value="{{$orden_servicio}}" readonly>
						                      			</div>
							                  		 	<label class="col-sm-2 col-form-label">Fecha:</label>
							              					<div class="col-sm-4">
							               						 <input type="text" class="form-control" name="fecha" value="{{$tiempo_actual}}" readonly>
							                      			</div>
													</div>
													<div class="row">
						                      			<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
						                         		<div class="col-sm-10">
						                        		 	<input type="text" class="form-control m-b" value="{{Auth::user()->personal->nombres}}"  name="personal_lab_id" id="" readonly="">
						                				</div>
													</div>
													<div class="row">
						                      			<label class="col-sm-2 col-form-label">Cliente:</label>
						                        		<div class="col-sm-10">
							                         		<input list="browsersc1" class="form-control m-b" name="cliente_id" id="cliente_id" required autocomplete="off" >
															<datalist id="browsersc1" >
																@foreach($clientes as $cliente)
																	<option id="{{$cliente->id}}">{{$cliente->numero_documento}}- {{$cliente->nombre}}</option>
																@endforeach
															 </datalist>
						                				</div>
													</div>
													<div class="row">
						                      			<label class="col-sm-2 col-form-label">Contacto:</label>
						                        		 <div class="col-sm-10">
						                        		 	<input list="contacto_cliente" type="text" class="form-control m-b" name="contacto_cliente"   id=""    autocomplete="off"  >
						                         			<datalist id="contacto_cliente" ></datalist>
						                				</div>
													</div>
													<div class="row">
						                      			<label class="col-sm-2 col-form-label">Asunto:</label>
						                        		<div class="col-sm-10">
							                         		<input type="text" class="form-control" name="asunto" required/>
						                				</div>
													</div>
													<br/>
											</div>
										</fieldset>
										<fieldset class="col-sm-6">
											<legend> Datos del <br> Equipo </legend>
											<div class="panel panel-default">
												<div class="panel-body" align="left">
													<div class="row">
														<label class="col-sm-2 col-form-label">Modelo:</label>
							                            <div class="col-sm-10">
							                              	<input name="nombre_equipos" list="browserprod"   class="form-control" autocomplete="off" />
							                              	<datalist id="browserprod">
								                              	@foreach($productos as $producto)
									                              	<option  id="{{$producto->nombre}}">{{$producto->nombre}}</option>
								                              	@endforeach
							                              	</datalist>
							                            </div>
						                    			<label class="col-sm-2 col-form-label">Nr Serie:</label>
						                        	    <div class="col-sm-10">
						                        	     	<input type="text" class="form-control" name="numero_serie" required>
							                            </div>
													</div>
													<div class="row">
														<label class="col-sm-2 col-form-label">Codigo Interno:</label>
						                            	<div class="col-sm-10">
					                     					<input type="text" class="form-control" name="codigo_interno" required>
						                             	</div>
						                    			<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
						                              	<div class="col-sm-10">
 						                   					<input type="date" class="form-control" name="fecha_compra" max="{{$orden_servicio}}" required>
						                              	</div>
													</div>
												</div>
											</div>
										</fieldset>
										<fieldset class="col-sm-12">
											<legend> Informe del <br>Problema</legend>
											<div class="panel panel-default">
												<div class="panel-body" align="left">
													<div class="row">
														<label class="col-sm-2 col-form-label">Descripcion del Problema:</label>
							                            <div class="col-sm-10">
							                              	<div class="input-group m-b">
							                  					<textarea class="form-control" rows="5" id="comment" name="descripcion_problema"  maxlength="1230" required></textarea>
							                				</div>
							                   			 </div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-body" align="left">
													<div class="row">
														<label class="col-sm-2 col-form-label">Revisión y diagnóstico:</label>
							                            <div class="col-sm-10">
							                             	<div class="input-group m-b">
							                  				<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico" maxlength="1230" required></textarea>
							                				</div>
							                   			</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-body" align="left">
													<div class="row">
														<label class="col-sm-2 col-form-label">Estetica:</label>
						                            	<div class="col-sm-10">
							                              	<div class="input-group m-b">
							                  					<textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="1230" required></textarea>
							                				</div>
						                   				</div>
													</div>
												</div>
											</div>
										</fieldset>
										<br>
									 	<button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" id="boton"><strong>Grabar</strong></button>
							    	</div>
								</div>
							 </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript">
	$('#cliente_id').on('keyup',function(){
		$value = $(this).val();
	$.ajax({
		type: 'get',
		url: '{{URL::to('contacto_cliente')}}',
		data: {'cliente_id':$value},
		success:function(data){
			$('#contacto_cliente').html(data);
		}
	})
	})
</script>
{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
           { alert(incompleto); }
       else{boton.type = 'button';}
   }
</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
{{-- <script type="text/javascript">
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script> --}}
<style>
	.form-control{    margin-bottom: 15px;
}
   fieldset
  {
    /*border: 1px solid #ddd !important;*/
    padding: 10px;
    /*border-radius:4px ;*/
    background-color:#f5f5f5;
    padding-left:10px!important;
    padding-right:10px!important;
    margin-bottom: 10px;
    border-left: 1px solid #ddd !important;

  }

    legend
    {
      font-size:14px;
      font-weight:bold;
      margin-bottom: 0px;
      width: 35%;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px 5px 5px 10px;
      background-color: #ffffff;
    }
</style>

	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


@stop