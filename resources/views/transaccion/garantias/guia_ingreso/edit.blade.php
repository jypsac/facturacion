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
	                                <form action="{{ route('garantia_guia_ingreso.actualizar',$garantia_guia_ingreso->id) }}"  enctype="multipart/form-data" method="post">
                                         @csrf
                                         @method('put')
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Marca :</label>
							                    <div class="col-sm-11">
							                     	<input type="text" class="form-control" name="marca" value="{{$garantia_guia_ingreso->marcas_i->nombre}}" readonly>
							                    </div>
						                </div>

									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-4">
													<select class="form-control m-b" name="motivo">
										    		<option value="Garantia">Garantia</option>
										    		<option value="Servicio">Servicio</option>
										    		<option value="Informativo">Informativo</option>
										    		<option value="Reingreso">Reingreso</option>
										    		</select>
							                    </div>
						                    <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
											<div class="col-sm-4">
												<select class="form-control m-b" name="personal_lab_id">
													@foreach($personales as $personal)
												<option value="{{$personal->id}}">{{$personal->nombres}} {{$personal->apellidos}} </option>
													@endforeach
												</select>
											</div>
						                </div>

								        <div class="form-group  row">
								        	<label class="col-sm-1 col-form-label">Fecha:</label>
						                    <div class="col-sm-4">
											<input type="text" class="form-control" name="fecha" value="{{$garantia_guia_ingreso->fecha}}" readonly>
						                    </div>
						                    <label class="col-sm-2 col-form-label">Orden de servicio:</label>
						                    <div class="col-sm-4">
						                    	<input type="text" class="form-control" name="orden_servicio" value="{{$garantia_guia_ingreso->orden_servicio}}" readonly>
						                    </div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1 col-form-label">Asunto:</label>
						                     <div class="col-sm-11"><input type="text" class="form-control" name="asunto" value="{{$garantia_guia_ingreso->asunto}}"></div>
										</div>
										
										<div class="form-group  row"><label class="col-sm-1 col-form-label">Cliente:</label>
											<div class="col-sm-11"><select class="form-control m-b" name="cliente_id">
												   @foreach($clientes as $cliente)
												   <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
												   @endforeach
											   </select></div>
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

									 	<div class="form-group  row"><label class="col-sm-2">Modelo :</label>
						                     <div class="col-sm-10"><input type="text" class="form-control" name="nombre_equipo" value="{{$garantia_guia_ingreso->nombre_equipo}}"></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-2">Nr Serie:</label>
						                     <div class="col-sm-10"><input type="text" class="form-control" name="numero_serie" value="{{$garantia_guia_ingreso->numero_serie}}"></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-2">Codigo Interno:</label>
						                     <div class="col-sm-10"><input type="text" class="form-control" name="codigo_interno" value="{{$garantia_guia_ingreso->codigo_interno}}"></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-2">Fecha de Compra:</label>
										<div class="col-sm-10"><input type="date" class="form-control" name="fecha_compra" max="{{$garantia_guia_ingreso->fecha_compra}}" value="{{$garantia_guia_ingreso->fecha_compra}}"></div>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="descripcion_problema" >{{$garantia_guia_ingreso->descripcion_problema}}</textarea>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico">{{$garantia_guia_ingreso->revision_diagnostico}}</textarea>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="estetica">{{$garantia_guia_ingreso->estetica}}</textarea>
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