@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('content')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg">C</a>
    <a class="icon icon-twitter" target="_blank">M</a>
    <a class="icon icon-youtube" target="_blank">P</a>
    <a class="icon icon-instagram" target="_blank">#</a>
</div>
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
                            {{-- <div class="text-center">
                            <!-- MODAL CLIENTE -->

								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Agregar-Cliente</button>
							</div> --}}
							<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
								  <div class="modal-content">

									<form action="{{ route('agregado_rapido.cliente_store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post" style="margin:20px">

										@csrf
										<h1 >Datos Personales</h1>
										<fieldset>
											
											<div class="row">
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


											</div>

										</fieldset>
										
										<fieldset>
											
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
										<h1>Contacto</h1>
										<fieldset>
											
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
										<input type="submit"class="btn btn-primary" value="Enviar">



									</form>

								  </div>
								</div>
							</div>
							<br>


                    </div>
                </div>
	            		<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div>
	                            <div class="panel-body">
	                                <form action="{{route('garantia_guia_ingreso.store')}}"  enctype="multipart/form-data" method="post">
									 	@csrf
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Marca :</label>
							                    <div class="col-sm-5">
							                     	<input type="text" class="form-control" name="marca_id" value="{{$marca_nombre}}" readonly>
							                    </div>

							                    <label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="motivo">
										    		<option value="Tecnico">Tecnico</option>
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