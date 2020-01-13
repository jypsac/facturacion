@extends('layout')

@section('title', 'productos')
@section('breadcrumb', 'productos')
@section('breadcrumb2', 'productos')
@section('href_accion', route('productos.index'))
@section('value_accion', 'Atras')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nuevo Producto</h5>
                    <a  class="btn btn-sm btn-success" href="{{ route('productos.edit', $producto->id) }}" style="background-color: #1ab394; border-color: #1ab394;padding: 2px 4px"> <i style="font-size: 15px" class="fa fa-edit"></i></a>
				</div>
				<div class="ibox-content">
					
<form action="{{ route('productos.index') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
				<div class="row">

						<div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
								Clasificacion del Producto
	                            </div>
	                            <div class="panel-body">
									 
								<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Codigo:</label><div class="col-sm-10"><input type="text" class="form-control" name="codigo_producto" value="{{$producto->codigo_producto}}" disabled="disabled">
									 	</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Codigo Alernativo:</label>
		                     			<div class="col-sm-10"><input type="text" class="form-control" name="codigo_original" value="{{$producto->codigo_original}}" disabled="disabled"></div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Categoria:</label>
		                    			 <div class="col-sm-10">
		                    			 	<input type="text" class="form-control" value="{{$producto->categoria_i_producto->descripcion}}" disabled="disabled">
					    				</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Familia:</label>
		                     <div class="col-sm-10">
		                     	<input type="text" class="form-control" value="{{$producto->familia_i_producto->descripcion}}" disabled="disabled">
					    	</div>
						        </div>
						        <div class="form-group row">
										<label class="col-sm-2 col-form-label">Marca:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" value="{{$producto->marcas_i_producto->nombre}}" disabled="disabled">
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
		                     			<div class="col-sm-10"><input type="text" class="form-control" value="{{$producto->nombre}}" disabled="disabled"></div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Descripcion:</label>
		                     			<div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" rows="5" disabled="disabled">{{$producto->descripcion}}</textarea ></div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Estado:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="{{$producto->estado_i_producto->nombre}}" disabled="disabled">
		                    			</div>
									</div>
									<div class="form-group row">
									 	<label class="col-sm-2 col-form-label">Origen:</label>
											<div class="col-sm-10">
												
					    						<input type="text" class="form-control" value="{{$producto->origen}}" disabled="disabled">
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
									<input type="text" class="form-control" name="descuento1" value="{{$producto->descuento1}}" disabled="disabled">
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Descuento 2:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" value="{{$producto->descuento2}}" disabled="disabled">
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
									<input type="text" class="form-control" name="descuento_maximo" value="{{$producto->descuento_maximo}}" disabled="disabled" >
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Utilidad:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										<span class="input-group-addon">%</span>
									</div>
									<input type="text" class="form-control" name="utilidad" value="{{$producto->utilidad}}"  disabled="disabled">
								</div>
									</div>
									
	                        		</div>	
	                        		
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Unida de medida:</label>
		                     			<div class="col-sm-5"><div class="input-group m-b">
									<div class="input-group-prepend">
										{{-- <span class="input-group-addon">%</span> --}}
									</div>
									<input type="text" class="form-control" name="unidad_medida" value="{{$producto->unidad_i_producto->medida}}"  disabled="disabled">
								</div>
										</div>

		                     			<label class="col-sm-1 col-form-label">Moneda:</label>
		                     			<div class="col-sm-5">
		                     				<input type="text" class="form-control" value="{{$producto->moneda_i_producto->nombre}}"  disabled="disabled">
									</div>
									
	                        		</div>	
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Precio:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="precio"  value="{{$producto->precio}}"  disabled="disabled">
										</div>
										

		                     			<label class="col-sm-1 col-form-label">Stok Minimo:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="stock_minimo" value="{{$producto->stock_minimo}}"  disabled="disabled" >
										</div>
									
	                        		</div>
	                        		{{--  --}}
	                        		<div class="form-group row">
									 	<label class="col-sm-1 col-form-label">Stock Maximo:</label>
		                     			<div class="col-sm-5"><input type="text" class="form-control" name="stock_maximo"  value="{{$producto->stock_maximo}}"  disabled="disabled">
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
	<button class="btn btn-primary" type="submit">Aceptar</button>

                		
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