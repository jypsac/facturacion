@extends('layout')

@section('title', 'Productos')
@section('breadcrumb', 'Productos-Editar')
@section('breadcrumb2', 'Productos-Editar')
@section('href_accion', route('productos.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Editar Producto</h5>
                    
				</div>
				<div class="ibox-content">
				<form action="{{ route('productos.update',$producto->id) }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	@method('PATCH')
				<div class="row">

						<div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
								Clasificacion del Producto
	                            </div>
	                            <div class="panel-body">
									 
								<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Codigo:</label><div class="col-sm-10"><input type="text" class="form-control" name="codigo_producto" value="{{$producto->codigo_producto}}" >
									 	</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Codigo Alernativo:</label>
		                     			<div class="col-sm-10"><input type="text" class="form-control" name="codigo_original" value="{{$producto->codigo_original}}" ></div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Categoria:</label>
		                    			 <div class="col-sm-10">
		                    			 	<input type="text" name="categoria_id" class="form-control" value="{{$producto->categoria_i_producto->descripcion}}" >
					    				</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Familia:</label>
		                     <div class="col-sm-10">
		                     	<input type="text" class="form-control" name="familia_id" value="{{$producto->familia_i_producto->descripcion}}" >
					    	</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Marca:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="marca_id" value="{{$producto->marcas_i_producto->nombre}}" >
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
		                     			<div class="col-sm-10"><input type="text" name="nombre" class="form-control" value="{{$producto->nombre}}" ></div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Descripcion:</label>
		                     			<div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" rows="5" >{{$producto->descripcion}}</textarea ></div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Estado:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="estado_id" value="{{$producto->estado_i_producto->nombre}}" >
		                    			</div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Origen:</label>
											<div class="col-sm-10">
												
					    						<input type="text" class="form-control" name="origen" value="{{$producto->origen}}" >
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
									<input type="text" class="form-control" name="descuento1" value="{{$producto->descuento1}}" >
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Descuento 2:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="descuento2" value="{{$producto->descuento2}}" >
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
									<input type="text" class="form-control" name="descuento_maximo" value="{{$producto->descuento_maximo}}"  >
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Utilidad:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="utilidad" value="{{$producto->utilidad}}"  >
								</div>
									</div>
									
	                        		</div>	
	                        		
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Unida de medida:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										{{-- <span class="input-group-addon">%</span> --}}
									</div>
									<input type="text" class="form-control" name="unidad_medida" value="{{$producto->unidad_i_producto->medida}}"  >
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Moneda:</label>
		                     			<div class="col-sm-5">
		                     				<input type="text" class="form-control" name="moneda_id" value="{{$producto->moneda_i_producto->nombre}}"  >
									</div>
									
	                        		</div>	
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Precio:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="precio"  value="{{$producto->precio}}"  >
										</div>
										

		                     			<label class="col-sm-1 col-form-label">Stok Minimo:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="stock_minimo" value="{{$producto->stock_minimo}}"   >
										</div>
									
	                        		</div>
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Stock Maximo:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="stock_maximo"  value="{{$producto->stock_maximo}}"  >
										</div>
										

		                     			<label class="col-sm-1 col-form-label">Foto:</label>
		                     			<div class="col-sm-5"><center>	<img src="
                                    {{ asset('/archivos/imagenes/productos/')}}/{{$producto->foto}}" style="width:150px;"></center>
										</div>
									
	                        		</div>
	                        		</div>

	                        	</div>
	                 
		

						</div>
					
	</div>								
	<button class="btn btn-primary" type="submit">Grabar</button>

                		
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