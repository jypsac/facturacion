	@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_informe_tecnico.index'))
@section('value_accion', 'Atras')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-title">
	        <h5>Creaaar</h5>
	        </div>
	            <div class="ibox-content">
	            	<div class="row">
	            		<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Generals
	                            </div>
	                            <div class="panel-body">
	                                <form action="{{route('garantia_informe_tecnico.store')}}"  enctype="multipart/form-data" method="post">
									 	@csrf
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Marca :</label>
							                    <div class="col-sm-4">
												<input type="text" class="form-control" name="marca" value="{{$garantia_guia_egreso->garantia_ingreso_i->marcas_i->nombre}}" readonly>
							                    </div>
							                    <label class="col-sm-2 col-form-label">Fecha:</label>
						                   		 <div class="col-sm-4">
													<input type="text" class="form-control" name="fecha_uno" value="{{$tiempo_actual}}" readonly>
						                    	</div>
						                </div>

									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="motivo" value="{{$garantia_guia_egreso->garantia_ingreso_i->motivo}}" readonly>
							                    </div>
						                    <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
							                    <div class="col-sm-4">
							                     	<input type="text" class="form-control" name="ing_asignado" value="{{$garantia_guia_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}}" readonly>
							                    </div>
						                </div>

								        <div class="form-group  row">
								        	<label class="col-sm-1 col-form-label">Fecha:</label>
						                    <div class="col-sm-4">
						                     	<input type="text" class="form-control" name="fecha" value="{{$garantia_guia_egreso->garantia_ingreso_i->fecha}}" readonly>
						                    </div>
						                    <label class="col-sm-2 col-form-label">Orden de servicio:</label>
						                    <div class="col-sm-4">
						                    	<input type="text" class="form-control" name="orden_servicio" value="{{$garantia_guia_egreso->garantia_ingreso_i->orden_servicio}}" readonly>
						                    </div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1 col-form-label">Asunto:</label>
						                     <div class="col-sm-11"><input type="text" class="form-control" name="asunto" value="{{$garantia_guia_egreso->garantia_ingreso_i->asunto}}" readonly></div>
						                </div>

	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Datos del Cliente
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group  row"><label class="col-sm-3 ">Empresa:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="nombre_cliente" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->nombre}}" readonly></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Direccion:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="direccion" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->direccion}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Telefono:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="telefono" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->telefono}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Correo:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="correo" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->email}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Contacto:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="contacto" value="{{$garantia_guia_egreso->garantia_ingreso_i->contactos->nombre}}" readonly></div>
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

						                <div class="form-group  row"><label class="col-sm-3 "></label>
						                     <div class="col-sm-9"></div>
						                </div>

									 	<div class="form-group  row"><label class="col-sm-3">  Modelo:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="nombre_equipo" value="{{$garantia_guia_egreso->garantia_ingreso_i->nombre_equipo}}" readonly></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">N° Serie:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="numero_serie" value="{{$garantia_guia_egreso->garantia_ingreso_i->numero_serie}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Codigo Interno:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="codigo_interno" value="{{$garantia_guia_egreso->garantia_ingreso_i->codigo_interno}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Fecha de Compra:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="fecha_compra" value="{{$garantia_guia_egreso->garantia_ingreso_i->fecha_compra}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 "></label>
						                     <div class="col-sm-9"></div>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="630" required></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Revision y Diagnostico
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico"  maxlength="630" required></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Causas de problema
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="causas_del_problema"  maxlength="630" required></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Solucion
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="solucion"  maxlength="630" required></textarea>
						                     </div>
						                </div>
	                            </div>

	                        </div>
						</div>
				<!-- xd -->



            {{-- <div class="form-1-2">
              <label for="">Archivo a subir:</label>
              <input type="file" class="btn btn-info dim" name="file1" required>
            </div> --}}


           				<!--  <div class="col-lg-6">
           					                        <div class="panel panel-primary">
           					                            <div class="panel-heading">
           					                                Fotos
           					                            </div>
           					                            <div class="panel-body">
           										                <div class="form-group  row">
           																<div class="col-sm-12">


           																 <div class="dropzone">

           				              									</div>
           																</div>
           										                </div>
           					                            </div>
           					                        </div>
           										</div>  -->





				<!-- xd -->

						<div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Fotos
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
												<div class="col-sm-12">
													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 1 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image1"></div>
													</div>

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 2 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image2"></div>
													</div>

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 3 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image3"></div>
													</div>

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 4 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image4"></div>
													</div>


												</div>
						                </div>
	                            </div>
	                        </div>
						</div>

						<div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Fotos
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
												<div class="col-sm-12">

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 5 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image5"></div>
													</div>

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 6 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image6"></div>
													</div>

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 7 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image7"></div>
													</div>

													<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto 8 :</label>
														<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="image8"></div>
													</div>
												</div>
						                </div>
	                            </div>
	                        </div>
						</div>





	                    <div class="col-lg-12">
	                        <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit"><strong>Enviar</strong></button>
	                        </form>
	                    </div>
                    </div>
	            </div>
	        </div>
        </div>


	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>

  new Dropzone('.dropzone', {

    url: '{{route('garantia_informe_tecnico.store')}}' ,
    dictDefaultMessage: 'Arrastra las fotos aqui para subirlas'
    });

    Dropzone.autoDiscover = false;

  </script>
  {{-- FOTOS --}}

	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


@stop