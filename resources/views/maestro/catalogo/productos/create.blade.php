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
					<form action="{{ route('productos.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Codigo Por Producto:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="codigo_prod"></div>
		                </div><!-- 1 -->

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Categoria:</label>
		                     <div class="col-sm-10">
		                     	<select class="form-control m-b" name="categoria">
			          			<option>Seleccione una Categoria</option>
			          			@foreach($categorias as $categoria)
					    		<option value="{{ $categoria->id }}">{{ $categoria->descripcion}}</option>
					    		@endforeach
					    		</select>
					    	</div>
		                </div><!-- 2 -->
		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Familia:</label>
		                     <div class="col-sm-10">
		                     	<select class="form-control m-b" name="familia">
			          			<option>Seleccione una Familia</option>
			          			@foreach($familias as $familia)
					    		<option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
					    		@endforeach
					    		</select>
					    	</div>
		                </div><!-- 2 -->

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Marcas:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="marca">
			          			<option>Seleccione una Marca</option>
			          			@foreach($marcas as $marca)
					    		<option value="{{ $marca->id }}">{{ $marca->nombre}}</option>
					    		@endforeach
					    		</select>
		                    </div>
		                </div><!-- 3 -->
		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombres:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="nombre"></div>
		                </div><!-- 4 -->

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descripcion:</label>
		                     <div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion"></textarea></div>
		                </div><!-- 5 -->

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Estado:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="estado">
			          			<option>Seleccione un Estado</option>
			          			@foreach($estados as $estado)
					    		<option value="{{ $estado->id }}">{{ $estado->nombre}}</option>
					    		@endforeach
					    		</select>
		                    </div>
		                </div><!-- 6 -->

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descuento:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descuento"></div>
		                </div><!-- 7 -->

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Origen:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="estado">
			          			<option>Seleccione un Estado</option>
			          			<option value="Nacional" >Producto Nacional</option>
			          			<option value="Importado">Producto Importado</option>
			          			
					    		</select>
		                    </div>
		                </div><!-- 8-->

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Utilidad:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="utilidad"></div>
		                </div><!-- 9 -->

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Unida de medida:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="unidad_medida">
			          			<option>Seleccione La Unidad de Medida</option>
			          			@foreach($unidad_medidas as $unidad_medida)
					    		<option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida}}</option>
					    		@endforeach
					    		</select>
		                    </div>
		                </div><!-- 10 -->

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Moneda:</label>
							<div class="col-sm-10">
		                    	<select class="form-control m-b" name="moneda">
			          				<option>Seleccione la Moneda</option>
			          				@foreach($monedas as $moneda)
					    			<option value="{{ $moneda->id }}">{{ $moneda->nombre}}</option>
					    			@endforeach
					    		</select>
					    	</div>
		                </div><!-- 9 -->

		                

				        

		               
		                


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