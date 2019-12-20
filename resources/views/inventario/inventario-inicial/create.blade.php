@extends('layout')

@section('title', 'Crear Inventario')
@section('breadcrumb', 'Crear Inventario')
@section('breadcrumb2', 'Crear Inventario')
@section('href_accion', route('inventario-inicial.index'))
@section('value_accion', 'atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Inventario Inicial</h5>
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
					
					
					<form action="{{route('inventario-inicial.store')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Codigo:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="codigo"></div>
                        </div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Articulo:</label>
                            <div class="col-sm-10">
								<select class="form-control m-b" name="articulo">
									@foreach($productos as $producto)
									<option value="{{$producto->id}}" >{{$producto->nombre}}</option>
									@endforeach
								</select>
							</div>
                        </div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Saldo:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="saldo"></div>
						</div>
						
						<input type="hidden" class="form-control" name="almacen" value="{{$almacen}}">
					
						
						<input type="hidden" class="form-control" name="categorias" value="{{$clasificaciones}}">
                        
                       
                       <button class="btn btn-primary" type="submit" name="action">Guardar</button>

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
@stop








