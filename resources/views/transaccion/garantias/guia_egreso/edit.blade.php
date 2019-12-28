@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
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
	                                <form action="{{route('garantia_guia_egreso.store')}}"  enctype="multipart/form-data" method="post">
									 	@csrf
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Marca :</label>
							                    <div class="col-sm-4">
												<input type="text" class="form-control" name="marca" value="{{$garantias_guias_ingresos->marcas_i->nombre}}" readonly>
							                    </div>
							                    <label class="col-sm-2 col-form-label">Fecha:</label>
						                   		 <div class="col-sm-4">
													<input type="text" class="form-control" name="fecha_uno" value="{{$tiempo_actual}}" readonly>
						                    	</div>
						                </div>

									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="motivo" value="{{$garantias_guias_ingresos->motivo}}" readonly>
							                    </div>
						                    <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
							                    <div class="col-sm-4">
							                     	<input type="text" class="form-control" name="ing_asignado" value="{{$garantias_guias_ingresos->personal_laborales->personal_l->nombres}}" readonly>
							                    </div>
						                </div>

								        <div class="form-group  row">
								        	<label class="col-sm-1 col-form-label">Fecha:</label>
						                    <div class="col-sm-4">
						                     	<input type="text" class="form-control" name="fecha" value="{{$garantias_guias_ingresos->fecha}}" readonly>
						                    </div>
						                    <label class="col-sm-2 col-form-label">Orden de servicio:</label>
						                    <div class="col-sm-4">
						                    	<input type="text" class="form-control" name="orden_servicio" value="{{$garantias_guias_ingresos->orden_servicio}}" readonly>
						                    </div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1 col-form-label">Asunto:</label>
						                     <div class="col-sm-11"><input type="text" class="form-control" name="asunto" value="{{$garantias_guias_ingresos->asunto}}" readonly></div>
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

									 	<div class="form-group  row"><label class="col-sm-3 "> Empresa:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="nombre_cliente" value="{{$garantias_guias_ingresos->clientes_i->nombre}}" readonly></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Direccion:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="direccion" value="{{$garantias_guias_ingresos->clientes_i->direccion}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Telefono:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="telefono" value="{{$garantias_guias_ingresos->clientes_i->telefono}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Correo:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="correo" value="{{$garantias_guias_ingresos->clientes_i->email}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Contacto:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="contacto" value="{{$garantias_guias_ingresos->contactos->nombre}}" readonly></div>
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

	                            	<div class="form-group  row"><label class="col-sm-3"></label>
						                     <div class="col-sm-9"></div>
						                </div>

									 	<div class="form-group  row"><label class="col-sm-3">Modelo :</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="nombre_equipo" value="{{$garantias_guias_ingresos->nombre_equipo}}" readonly></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Nr Serie:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="numero_serie" value="{{$garantias_guias_ingresos->numero_serie}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Codigo Interno:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="codigo_interno" value="{{$garantias_guias_ingresos->codigo_interno}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Fecha de Compra:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="fecha_compra" value="{{$garantias_guias_ingresos->fecha_compra}}" readonly></div>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="descripcion_problema" maxlength="630" required></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Diagnostico y Solucion
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="diagnostico_solucion"  maxlength="630" required></textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Recomendaciones
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="recomendaciones"  maxlength="630" required></textarea>
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
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


@stop