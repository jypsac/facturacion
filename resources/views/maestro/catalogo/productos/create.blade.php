@extends('layout')

@section('title', 'Productos')
@section('breadcrumb', 'Productos-Agregar')
@section('breadcrumb2', 'Productos-Agregar')
@section('href_accion', route('productos.index') )
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nuevo Producto</h5>
				</div>
				<div class="ibox-content">
					
<form action="{{ route('productos.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
				<div class="row">

						<div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
								Clasificacion del Producto
	                            </div>
	                            <div class="panel-body">
									 
								<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Codigo del Producto:</label><div class="col-sm-10"><input type="text" class="form-control" name="codigo_producto" value="EPS-00123XR">
									 	</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Codigo Original:</label>
		                     			<div class="col-sm-10"><input type="text" class="form-control" name="codigo_original" placeholder="EPS-00001"></div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Categoria:</label>
		                    			 <div class="col-sm-10">
		                    			 	<select class="form-control m-b" name="categoria_id">
			          						<option>Seleccione una Categoria</option>
			          						@foreach($categorias as $categoria)
					    					<option value="{{ $categoria->id }}">{{ $categoria->descripcion}}</option>
					    					@endforeach
					    					</select>
					    				</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Familia:</label>
		                     <div class="col-sm-10">
		                     	<select class="form-control m-b" name="familia_id">
			          			<option>Seleccione una Familia</option>
			          			@foreach($familias as $familia)
					    		<option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
					    		@endforeach
					    		</select>
					    	</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Marca:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="marca_id">
			          			<option>Seleccione una Marca</option>
			          			@foreach($marcas as $marca)
					    		<option value="{{ $marca->id }}">{{ $marca->nombre}}</option>
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
	                                Datos del Producto
	                            </div>
	                            <div class="panel-body">
									 
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Nombre:</label>
		                     			<div class="col-sm-10"><input type="text" class="form-control" name="nombre" placeholder="Nombre del Producto"></div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Descripcion:</label>
		                     			<div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" placeholder="" style="height: 150px"></textarea></div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Estado:</label>
										<div class="col-sm-10">
											<select class="form-control m-b" name="estado_id">
			          							<option>Seleccione un Estado</option>
			          								@foreach($estados as $estado)
					    							<option value="{{ $estado->id }}">{{ $estado->nombre}}</option>
					    							@endforeach
					    					</select>
		                    			</div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Origen:</label>
											<div class="col-sm-10">
												<select class="form-control m-b" name="origen">
			          							<option>Seleccione un Estado</option>
			          							<option value="Nacional" >Producto Nacional</option>
			          							<option value="Importado">Producto Importado</option>

					    						</select>
		                    				</div>

	                        		</div>	

	                        	</div>
	                 
		

						</div>
					
					</div>		
					<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                               Precio del Producto
	                            </div>
	                            <div class="panel-body">
									 {{--  --}}
									<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Descuento 1:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="descuento1" >
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Descuento 2:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="descuento2" >
							   	</div>
									</div>
									
	                        		</div>	
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Descuento Maximo:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="descuento_maximo" >
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Utilidad:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="utilidad" >
								</div>
									</div>
									
	                        		</div>	
	                        		
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Unida de medida:</label>
		                     			<div class="col-sm-5">
								<select class="form-control m-b" name="unidad_medida_id">
			          			<option>Seleccione La Unidad de Medida</option>
			          			@foreach($unidad_medidas as $unidad_medida)
					    		<option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida}}</option>
					    		@endforeach
					    		</select>
									</div>

		                     			<label class="col-sm-1 col-form-label">Moneda:</label>
		                     			<div class="col-sm-5">
								<select class="form-control m-b" name="monedas_id">
			          				<option>Seleccione la Moneda</option>
			          				@foreach($monedas as $moneda)
					    			<option value="{{ $moneda->id }}">{{ $moneda->nombre}}</option>
					    			@endforeach
					    		</select>
									</div>
									
	                        		</div>	
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Precio:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="precio" placeholder="S/.100.00">
										</div>
										

		                     			<label class="col-sm-1 col-form-label">Stok Minimo:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="stock_minimo" >
										</div>
									
	                        		</div>
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Stock Maximo:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="stock_maximo" >
										</div>
										

		                     			<label class="col-sm-1 col-form-label">Seleccionar Archivo:</label>
		                     			<div class="col-sm-5"><input type="file" class="btn btn-success dim" name="foto">
										</div>
									
	                        		</div>
	                        		</div>

	                        	</div>
	                 
		

						</div>
					
	</div>								
	<button class="btn btn-primary" type="submit">Guardar</button>

                		
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
@endsection