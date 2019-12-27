@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('content')

<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1"><i class="fa fa-user-o" aria-hidden="true"></i><span> cliente</span></a>
    <a class="icon icon-twitter" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg2"><i style="padding-left: 5px" class="fa fa-male" aria-hidden="true"></i></i><span> personal</span></a>
    
</div><style type="text/css">span{font-size:15px;padding-left:4px}</style>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-title">
	        <h5>Crear</h5>
	        </div>
	            <div class="ibox-content">
	            	<div class="row">
						<div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content" style="border-top-width: 0px;padding: 0;height: 20px">
                           

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
													<input type="text" class="form-control" name="numero_documento" class="form-control required">
							                    </div>

						                </div>
						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >Cliente:</label>
							                    <div class="col-sm-4">
														<input type="text" class="form-control" name="nombre" class="form-control required">
							                    </div>

							                    <label class="col-sm-2 col-form-label">Direccion:</label>
												<div class="col-sm-4">
														<input type="text" class="form-control" name="direccion" class="form-control required">
							                    </div>
							                    
						                </div>

						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >Celular:</label>
							                    <div class="col-sm-4">
							                    	<input type="telefono" class="form-control" name="celular" class="form-control required">							        </div>

							                    <label class="col-sm-2 col-form-label">Telefono:</label>
												<div class="col-sm-4">
														<input type="telefono" class="form-control" name="telefono" class="form-control required">
							                    </div>
						                </div>
										
						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >correo:</label>
							                    <div class="col-sm-4">
							                    	<input type="email" class="form-control" name="email" class="form-control required">							                  
							                    	 </div>

							                    
						                </div>
										<h1><i class="fa fa-address-book-o" aria-hidden="true"></i></h1>
										
						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >Nombre Contacto:</label>
							                    <div class="col-sm-4">
														<input id="name" name="nombre_contacto" type="text" class="form-control required">
							                     </div>

							                    <label class="col-sm-2 col-form-label">Cargo Contacto:</label>
												<div class="col-sm-4">
														<input id="surname" name="cargo_contacto" type="text" class="form-control required">
							                    </div>
							                    
						                </div>

						                <div class="form-group row" style="">
									 		<label class="col-sm-2 col-form-label" >Telefono Contacto:</label>
							                    <div class="col-sm-4">
														<input id="email" name="telefono_contacto" type="text" class="form-control required">
							                     </div>

							                    <label class="col-sm-2 col-form-label">Celular Contacto:</label>
												<div class="col-sm-4">
														<input id="address" name="celular_contacto" type="text" class="form-control required">
							                    </div>
							                    
						                </div>
						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >Correo Contacto:</label>
							                    <div class="col-sm-4">
														<input id="email" name="email_contacto" type="text" class="form-control required email">
							                     </div>

						                </div>

										<input type="submit"class="btn btn-primary" value="Grabar">

									</form>

								  </div>
								</div>
							</div>
							<br>
							  <!-- MODAL Personal -->

							<div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
								  <div class="modal-content" style="width: 100%">

									<form action="{{ route('agregado_rapido.cliente_store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post" style="margin:20px">

										@csrf
										<h1 ><i class="fa fa-user-o" aria-hidden="true"></i></h1>

									<style type="text/css">
										.xd{    margin-bottom: 0px;}
										h1{margin-bottom: 0px;}
									</style>
									 	<div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >Nombre:</label>
							                    <div class="col-sm-4">
							                     	<input type="text" class="form-control" name="nombres">
							                    </div>

							                 <label class="col-sm-2 col-form-label">Apellidos:</label>
												<div class="col-sm-4">
														<input type="text" class="form-control" name="apellidos">
							                    </div>
						                </div>

						                <div class="form-group row xd">
						                	<label class="col-sm-2 col-form-label">Fecha Nacimiento:</label>
												<div class="col-sm-4">
													<input type="date" class="form-control" name="fecha_nacimiento">
							                    </div>

							                <label class="col-sm-2 col-form-label">Genero:</label>
												<div class="col-sm-4">
														<select class="form-control m-b" name="genero">
													<option value="masculino">masculino</option>
													<option value="femenino">femenino</option>
													</select>
							                    </div>

						                </div>
						                <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></h1>

						                <div class="form-group row xd">

									 		<label class="col-sm-2 col-form-label" >Tipo Documento:</label>
							                    <div class="col-sm-4"><select class="form-control m-b" name="documento_identificacion">
												<option value="dni">DNI</option>
												<option value="pasaporte">Pasaporte</option>
												<option value="pasaporte">RUC</option>
												</select>						                    
												</div>

							                    <label class="col-sm-2 col-form-label">N° de Doc:</label>
												<div class="col-sm-4">
														<input type="text" class="form-control" name="numero_documento">
							                    </div>

						                </div>

						                <div class="form-group row xd">
									 		
							                     <label class="col-sm-2 col-form-label" >Direccion:</label>
							                    <div class="col-sm-4">
														<input type="text" class="form-control" name="direccion">
							                     </div>

							                    <label class="col-sm-2 col-form-label">Pais:</label>
												<div class="col-sm-4">
														<select class="form-control m-b" name="nacionalidad">
										  <option>Seleccione</option>
										 {{--  @foreach($paises as $pais)
										<option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>
										@endforeach --}}
										</select>
							                    </div>

						                </div>

										<h1><i class="fa fa-graduation-cap" aria-hidden="true"></i></h1>

						                <div class="form-group row">
										
							            <label class="col-sm-2 col-form-label" >Nivel Educativo:</label>
							                    <div class="col-sm-4">
														<input type="text" class="form-control" name="nivel_educativo">
							                     </div>

									 	<label class="col-sm-2 col-form-label" >Profesion:</label>
							                    <div class="col-sm-4">
							                    	<input type="text" class="form-control" name="profesion">							                  
							                    	 </div>

							                    
						                </div>
										<h1><i class="fa fa-phone" aria-hidden="true"></i></h1>
						                <div class="form-group row">


						                	<label class="col-sm-2 col-form-label" >Telefono:</label>
							                    <div class="col-sm-4">
														<input type="telefono" class="form-control" name="telefono">
							                    </div>
									 		<label class="col-sm-2 col-form-label" >Celular:</label>
							                    <div class="col-sm-4">
														<input type="telefono" class="form-control" name="celular">
							                     </div>

						                </div>

						                <div class="form-group row" style="">

							                    <label class="col-sm-2 col-form-label">Correo:</label>
												<div class="col-sm-4">
														<input type="email" class="form-control" name="email">
							                    </div>
							                    {{-- 
									 		<label class="col-sm-2 col-form-label" >Estado civil:</label>
							                    <div class="col-sm-4">
														 <select class="form-control m-b" name="estado_civil">
										 <option>Seleccione</option>
									   <option value="Soltero">Soltero</option>
									   <option value="Casado">casado</option>
									   </select>
							                     </div> --}}

							                    
						                </div>

										<input type="submit"class="btn btn-primary" value="Grabar">

									</form>

								  </div>
								</div>
							</div>


                    </div>
                </div>
	            		<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div> 
	                            <form action="{{route('garantia_guia_ingreso.store')}}"  enctype="multipart/form-data" method="post">

	                            <div class="panel-body">
	                                
									 	@csrf
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Marca :</label>
							                    <div class="col-sm-5">
							                     	<input type="text" class="form-control" name="marca_id" value="{{$marca_nombre}}" readonly>
							                    </div>

							                    <label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="motivo">
										    		<option value="Garantia">Garantia</option>
										    		<option value="Servicio">Servicio</option>
										    		<option value="Informativo">Informativo</option>
										    		<option value="Reingreso">Reingreso</option>
										    		</select>
							                    </div>
						                </div>

									 	<div class="form-group row">
									 		
						                    <label class="col-sm-1 col-form-label">Ing. Asignado:</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="personal_lab_id">
														@foreach($personales as $personal)
													<option value="{{$personal->id}}">{{$personal->nombres}} {{$personal->apellidos}} </option>
														@endforeach
													</select>
												</div>
												<label class="col-sm-1 col-form-label">Fecha:</label>
						                   		 <div class="col-sm-5">
													<input type="text" class="form-control" name="fecha" value="{{$tiempo_actual}}" readonly>
						                    	</div>
						                </div>
								        <div class="form-group  row">
								        	
						                    <label class="col-sm-1 col-form-label">Orden de servicio:</label>
						                    <div class="col-sm-5">
						                    	<input type="text" class="form-control" name="orden_servicio" value="{{$orden_servicio}}" readonly>
						                    </div>
						                    <label class="col-sm-1 col-form-label">Cliente:</label>
						                     <div class="col-sm-5"><select class="form-control m-b" name="cliente_id">
													@foreach($clientes as $cliente)
													<option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
													@endforeach
										    	</select></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1 col-form-label">Asunto:</label>
						                     <div class="col-sm-11"><input type="text" class="form-control" name="asunto"></div>
										</div>

										<div class="form-group  row">
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Datos del Equipo
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group  row">
									 		<label class="col-sm-1">Modelo :</label>
						                     <div class="col-sm-5"><input type="text" class="form-control" name="nombre_equipo"></div>
						                     <label class="col-sm-1">Nr Serie:</label>
						                     <div class="col-sm-5"><input type="text" class="form-control" name="numero_serie"></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1">Codigo Interno:</label>
						                     <div class="col-sm-5"><input type="text" class="form-control" name="codigo_interno"></div>
						                     <label class="col-sm-1">Fecha de Compra:</label>
										<div class="col-sm-5"><input type="date" class="form-control" name="fecha_compra" max="{{$orden_servicio}}"></div>
						                </div>

	                            </div>
	                        </div>
	                    </div>
						<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Descripcion del Problema
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="descripcion_problema"  maxlength="630"></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Revision Y Diagnostico
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico" maxlength="630"></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Estetica
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="650"></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button>
	                        </form>
	                    </div>
                    </div>
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


@stop