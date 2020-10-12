@extends('layout')

@section('title', ' Actualizar - Informe Tecnico')
@section('breadcrumb', 'Actualizar Informe')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.index'))
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-title">
	        <h5>Modificar</h5>
	        </div>
	            <div class="ibox-content">
	            	<div class="row">
	            		<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div>
	                            <div class="panel-body">
                                    <form action="{{route('garantia_informe_tecnico.update', $garantia_informe_tecnico->id)}}"  enctype="multipart/form-data" method="post">
                                            @csrf
                                            @method('put')
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Marca :</label>
							                    <div class="col-sm-11">
												<input type="text" class="form-control" name="marca" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}}" readonly>
							                    </div>
						                </div>

									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Motivo :</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="motivo" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}" readonly>
							                    </div>
						                    <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
							                    <div class="col-sm-4">
							                     	<input type="text" class="form-control" name="ing_asignado" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}}" readonly>
							                    </div>
						                </div>

								        <div class="form-group  row">
								        	<label class="col-sm-1 col-form-label">Fecha:</label>
						                    <div class="col-sm-4">
						                     	<input type="text" class="form-control" name="fecha" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha}}" readonly>
						                    </div>
						                    <label class="col-sm-2 col-form-label">Orden de servicio:</label>
						                    <div class="col-sm-4">
						                    	<input type="text" class="form-control" name="orden_servicio" value="{{$garantia_informe_tecnico->orden_servicio}}" readonly>
						                    </div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-1 col-form-label">Asunto:</label>
						                     <div class="col-sm-11"><input type="text" class="form-control" name="asunto" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}" readonly></div>
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
						                     <div class="col-sm-9"><input type="text" class="form-control" name="nombre_cliente" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}" readonly></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Direccion:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="direccion" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Telefono:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="telefono" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Correo:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="correo" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3 ">Contacto:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="contacto" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre}}" readonly></div>
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

									 	<div class="form-group  row"><label class="col-sm-3">Modelo :</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="nombre_equipo" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}" readonly></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Nr Serie:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="numero_serie" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Codigo Interno:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="codigo_interno" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}" readonly></div>
						                </div>

						                <div class="form-group  row"><label class="col-sm-3">Fecha de Compra:</label>
						                     <div class="col-sm-9"><input type="text" class="form-control" name="fecha_compra" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}" readonly></div>
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
	                             Datos y Diagnostico
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group  row"><label class="col-sm-3">Descripcion Del Problema :</label>
						                     <div class="col-sm-9">
						                     	<textarea class="form-control" rows="5" id="comment" name="" readonly>{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema}}</textarea></div>
						                </div>

								        <div class="form-group  row"><label class="col-sm-3">Revision y diagnostico:</label>
						                     <div class="col-sm-9">
						                     	<textarea class="form-control" rows="5" id="comment" name="" readonly>{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico}}</textarea></div>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="estetica" required>{{$garantia_informe_tecnico->estetica}}</textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Revision Y diagnostico
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico" required>{{$garantia_informe_tecnico->revision_diagnostico}}</textarea>
						                     </div>
						                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Causas Del Problema
	                            </div>
	                            <div class="panel-body">
						                <div class="form-group  row">
						                     <div class="col-sm-12">
						                     	<textarea class="form-control" rows="5" id="comment" name="causas_del_problema" required>{{$garantia_informe_tecnico->causas_del_problema}}</textarea>
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
						                     	<textarea class="form-control" rows="5" id="comment" name="solucion" required>{{$garantia_informe_tecnico->solucion}}</textarea>
						                     </div>
						                </div>
	                            </div>

	                        </div>
						</div>

						<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Fotos
	                            </div>
	                            <div class="panel-body" align="center">
                             @if($garantia_informe_tecnico->image1<>"sin_foto")
		                         <div class="col-sm-3">
		                          	<input class="archivoInput" type="file" id="archivoInput{{$garantia_informe_tecnico->image1}}" name="image1" onchange="return validarExt{{$garantia_informe_tecnico->id}}()" style="position:absolute;top:27px;left:35px;right:-100px;bottom:0px;width:250px;height:65%;opacity:0;"  />
										<span id="visorArchivo{{$garantia_informe_tecnico->image1}}">
											<!--Aqui se desplegará el fichero-->
											<center> <img name="image1" src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image1}}" style="width: 250px;"></center>
                      					</span>
                              	</div>
                              	<script type="text/javascript">
											{{-- Fotooos --}}
								function validarExt{{$garantia_informe_tecnico->id}}()
								{
									var archivoInput{{$garantia_informe_tecnico->id}} = document.getElementById('archivoInput{{$garantia_informe_tecnico->id}}');
									var archivoRuta = archivoInput{{$garantia_informe_tecnico->id}}.value;
									var extPermitidas = /(.jpg|.png|.jfif)$/i;
									if(!extPermitidas.exec(archivoRuta)){
										alert('Asegurese de haber seleccionado una Imagen');
										archivoInput{{$garantia_informe_tecnico->id}}.value = '';
										return false;
									}

									else
									{
//PRevio del PDF
								        if (archivoInput{{$garantia_informe_tecnico->id}}.files && archivoInput{{$garantia_informe_tecnico->id}}.files[0]){
									        	var visor = new FileReader();
									        	visor.onload = function(e)
									        	{
									        		document.getElementById('visorArchivo{{$garantia_informe_tecnico->id}}').innerHTML =
									        		'<img name="image1" src="'+e.target.result+'"width="250px"   />';
									        	};
									        	visor.readAsDataURL(archivoInput{{$garantia_informe_tecnico->id}}.files[0]);
									        }
									    }
									}
								</script>
                            @endif

                            @if($garantia_informe_tecnico->image2<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image2}}" style="width: 250px;">
                            @endif

                            @if($garantia_informe_tecnico->image3<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image3}}" style="width: 250px;">
                            @endif

                            @if($garantia_informe_tecnico->image4<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image4}}" style="width: 250px;">
                            @endif

                            @if($garantia_informe_tecnico->image5<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image5}}" style="width: 250px;">
                            @endif

                            @if($garantia_informe_tecnico->image6<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image6}}" style="width: 250px;">
                            @endif

                            @if($garantia_informe_tecnico->image7<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image7}}" style="width: 250px;">
                            @endif

                            @if($garantia_informe_tecnico->image8<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantia_informe_tecnico->image8}}" style="width: 250px;">
                            @endif
                    </div>
	                        </div>
						</div>

						{{-- <div class="col-lg-6">
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
						</div> --}}

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
<style type="text/css">
input#archivoInput{
		position:absolute;
		top:27px;
		left:35px;
		right:-100px;
		bottom:0px;
		width:73%;
		height:65%;
		opacity: 0	;
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