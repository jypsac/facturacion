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
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
				</div>
				<div class="ibox-content">
					<form action="{{ route('productos.update',$producto->id) }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	@method('PATCH')
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">
					 	Codigo por Producto:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="cod_producto" value="{{$producto->codigo_producto}}" readonly="readonly"></div>
						</div>
						
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Codigo Original:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="codigo_original" value="{{$producto->codigo_original}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Categoria:</label>
		                     <div class="col-sm-10">
		                     	<select class="form-control m-b" name="categoria_id">
			          			<option>Seleccione una Categoria</option>
			          			@foreach($categorias as $categoria)
					    		<option value="{{ $categoria->id }}">{{ $categoria->descripcion}}</option>
					    		@endforeach
					    		</select>
					    	</div>
		                </div>
		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Familia:</label>
		                     <div class="col-sm-10">
		                     	<select class="form-control m-b" name="familia_id">
			          			<option>Seleccione una Familia</option>
			          			@foreach($familias as $familia)
					    		<option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
					    		@endforeach
					    		</select>
					    	</div>
		                </div>

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="marca_id">
			          			<option>Seleccione una Marca</option>
			          			@foreach($marcas as $marca)
					    		<option value="{{ $marca->id }}">{{ $marca->nombre}}</option>
					    		@endforeach
					    		</select>
		                    </div>
		                </div>
						<legend>Datos del Producto</legend>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="nombre" value="{{$producto->nombre}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descripcion:</label>
		                     <div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" >{{$producto->descripcion}}</textarea></div>
		                </div>

		                {{-- <div class="form-group row"><label class="col-sm-2 col-form-label">Estado:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="estado_id">
			          			<option>Seleccione un Estado</option>
			          			@foreach($estados as $estado)
					    		<option value="{{ $estado->id }}">{{ $estado->nombre}}</option>
					    		@endforeach
					    		</select>
		                    </div>
						</div> --}}
						
						<input list="browsers" name="browser" class="form-control m-b">
							<datalist id="browsers">
							<option value="Internet Explorer">
									@foreach($estados as $estado)
									<option value="{{ $estado->id }}">{{ $estado->nombre}}</option>
									@endforeach
							</datalist>

		                 <div class="form-group row"><label class="col-sm-2 col-form-label">Origen:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="origen">
			          			<option>Seleccione un Estado</option>
			          			<option value="Nacional" >Producto Nacional</option>
			          			<option value="Importado">Producto Importado</option>

					    		</select>
		                    </div>
						</div>
						
		            	<legend>Precio del Producto</legend>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descuento 1:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descuento1" value="{{$producto->descuento1}}"></div>
						</div>

						<div class="form-group  row"><label class="col-sm-2 col-form-label">Descuento 2:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descuento2" value="{{$producto->descuento2}}"></div>
						</div>

						<div class="form-group  row"><label class="col-sm-2 col-form-label">Descuento Maximo:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descuento_maximo" value="{{$producto->descuento_maximo}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Utilidad:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="utilidad" placeholder="10%"></div>
		                </div>

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Unida de medida:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="unidad_medida_id">
			          			<option>Seleccione La Unidad de Medida</option>
			          			@foreach($unidad_medidas as $unidad_medida)
					    		<option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida}}</option>
					    		@endforeach
					    		</select>
		                    </div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Moneda:</label>
							<div class="col-sm-10">
		                    	<select class="form-control m-b" name="monedas_id">
			          				<option>Seleccione la Moneda</option>
			          				@foreach($monedas as $moneda)
					    			<option value="{{ $moneda->id }}">{{ $moneda->nombre}}</option>
					    			@endforeach
					    		</select>
					    	</div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Precio:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="precio" value="{{$producto->precio}}"></div>
						</div>

						<div class="form-group  row"><label class="col-sm-2 col-form-label">Stock Minimo:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="stock_minimo" value="{{$producto->stock_minimo}}"></div>
						</div>

						<div class="form-group  row"><label class="col-sm-2 col-form-label">Stock Maximo:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="stock_maximo" value="{{$producto->stock_maximo}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Seleccionar Archivo :</label>
                     		<div class="col-sm-10"><input type="file" class="btn btn-success dim" name="foto"></div>
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