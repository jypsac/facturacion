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
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Codigo por Producto:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="cod_producto" value="{{$producto->cod_producto}}"></div>
		                </div>
		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombres:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="nombre" value="{{$producto->nombre}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Utilidad:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="utilidad" value="{{$producto->utilidad}}"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descuento 1:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descuento" value="{{$producto->descuento}}%"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descuento 2:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descuento2" value="{{$producto->descuento2}}%"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Categoria:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="categoria" value="{{$producto->categoria_i_producto->descripcion}}"></div>
		                </div>

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Marcas:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="marca">
			          			<option value="{{$producto->marcas_i_producto->nombre}}">{{$producto->marcas_i_producto->nombre}}</option>


					    		</select>
		                    </div>
		                </div>


		                <div class="form-group row"><label class="col-sm-2 col-form-label">Unida de medida:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="unidad_medida">
			          			<option>Seleccione</option>
			          			@foreach($unidad_medidas as $unidad_medida)
					    		<option value="{{ $unidad_medida->medida }}">{{ $unidad_medida->simbolo}}</option>
					    		@endforeach
					    		</select>
		                    </div>
		                </div>



						<div class="form-group row"><label class="col-sm-2 col-form-label">Estado:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="activo">
			          			<option value="0">Desactivado</option>
			          			<option value="1">activo</option>
					    		</select>
		                    </div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Seleccionar Archivo :</label>
                     		<div class="col-sm-10"><input type="file" class="btn btn-success dim" name="foto"></div>
                		</div>


		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descripcion:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="descripcion" value="{{$producto->descripcion}}"></div>
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