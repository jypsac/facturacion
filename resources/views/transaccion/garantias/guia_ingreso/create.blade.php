@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')

@section('content')



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
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div>
	                            <div class="panel-body">
	                                <form action=""  enctype="multipart/form-data" method="post">
									 	@csrf

									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-4">
													<select class="form-control m-b" name="">
										    		<option value="Tecnico">Tecnico</option>
										    		<option value="Servicio">Servicio</option>
										    		<option value="Informativo">Informativo</option>
										    		<option value="Reingreso">Reingreso</option>
										    		</select>
							                    </div>
						                    <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
							                    <div class="col-sm-4">
							                     	<input type="text" class="form-control" name="">
							                    </div>
						                </div>

								        <div class="form-group  row">
								        	<label class="col-sm-1 col-form-label">Fecha:</label>
						                    <div class="col-sm-4">
						                     	<input type="text" class="form-control" name="">
						                    </div>
						                    <label class="col-sm-2 col-form-label">Orden de servicio:</label>
						                    <div class="col-sm-4">
						                    	<input type="text" class="form-control" name="">
						                    </div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1 col-form-label">Asunto:</label>
						                     <div class="col-sm-11"><input type="text" class="form-control" name=""></div>
						                </div>
									</form>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Datos del Cliente
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group  row"><label class="col-sm-3 ">Nombre o Empresa:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="abrev"></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Direccion:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="name"></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Telefono:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="direccion"></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Contacto:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="direccion"></div>
						                </div>

	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Datos del Equipo
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group  row"><label class="col-sm-3">Modelo :</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name=""></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Nr Serie:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name=""></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Codigo Interno:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name=""></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Fecha de Compra:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name=""></div>
						                </div>
									</form>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div>
	                            <div class="panel-body">
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-4">
													<select class="form-control m-b" name="">
										    		<option value="Tecnico">Tecnico</option>
										    		<option value="Servicio">Servicio</option>
										    		<option value="Informativo">Informativo</option>
										    		<option value="Reingreso">Reingreso</option>
										    		</select>
							                    </div>
						                    <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
							                    <div class="col-sm-4">
							                     	<input type="text" class="form-control" name="">
							                    </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Descripción del Problema
	                            </div>
	                            <div class="panel-body">
									 	<div class="form-group row">
									 		<div class="ibox-content no-padding">
							                    <div class="summernote">
							                        <h3>Falla Reportada</h3>
							                        dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
							                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
							                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
							                        <br/>
							                        <br/>
							                        <ul>
							                            <li>Remaining essentially unchanged</li>
							                            <li>Make a type specimen book</li>
							                            <li>Unknown printer</li>
							                        </ul>
							                    </div>
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
									 	<div class="form-group row">
									 		<div class="ibox-content no-padding">
							                    <div class="summernote">
							                        <h3>Falla Detectada</h3>
							                        dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
							                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
							                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
							                        <br/>
							                        <br/>
							                        <ul>
							                            <li>Remaining essentially unchanged</li>
							                            <li>Make a type specimen book</li>
							                            <li>Unknown printer</li>
							                        </ul>
							                    </div>
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
									 	<div class="form-group row">
									 		<div class="ibox-content no-padding">
							                    <div class="summernote">
							                        <h3>Lorem</h3>
							                        dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
							                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
							                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
							                        <br/>
							                        <br/>
							                        <ul>
							                            <li>Remaining essentially unchanged</li>
							                            <li>Make a type specimen book</li>
							                            <li>Unknown printer</li>
							                        </ul>
							                    </div>
							                </div>
						                </div>
	                            </div>
	                        </div>
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

    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

       });
    </script>
@stop