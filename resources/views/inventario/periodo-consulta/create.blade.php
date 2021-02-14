@extends('layout')

@section('title', 'periodo consulta')
@section('breadcrumb', 'periodo consulta-Agregar')
@section('breadcrumb2', 'periodo consulta-Agregar')
@section('href_accion', route('periodo-consulta.index') )
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nueva Entrada</h5>
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
					<form action="{{ route('periodo-consulta.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                         @csrf



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                            <div class="row">
                                            <label class="col-sm-2 col-form-label" >Nombre:</label>
                                             <div class="col-sm-10">
                                                 <input type="text" class="form-control" name="nombre" readonly="readonly" value="{{auth()->user()->name}}">
                                             </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                            <div class="row">
                                            <label class="col-sm-2 col-form-label" >Fecha:</label>
                                             <div class="col-sm-10">
                                                 <input type="date" class="form-control" name="fecha" value="{{date("Y-m-d")}}">
                                             </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-6" style="margin-top: 5px">
                                            <div class="row">
                                             <label class="col-sm-2 col-form-label" >Almacen:</label>
                                             <div class="col-sm-10">
                                             <select class="form-control" name="almacen">
                                                 @foreach($almacenes as $almacen)
                                                <option value="{{$almacen->id}}">{{$almacen->nombre}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-6" style="margin-top: 5px">
                                            <div class="row">
                                             <label class="col-sm-2 col-form-label" >Categoria:</label>
                                             <div class="col-sm-10">
                                             <select class="form-control" name="categoria">
                                                @foreach($categorias as $categoria)
                                                <option value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
                                                 @endforeach
                                            </select>
                                            </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-12" style="margin-top: 5px">
                                            <div class="row">
                                             <label class="col-sm-2 col-form-label">Informacion:</label>
                                             <div class="col-sm-10">
                                             <textarea class="form-control" name="informacion"></textarea>
                                             </div>
                                             </div>
                                    </div>
                                
                                </div>
                             
                            </div>
                        </div>

						<button class="btn btn-primary" type="submit" id="boton">Guardar</button>

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

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
     {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
    <script>
        function valida(f) {
            var boton=document.getElementById("boton");
            var completo = true;
            var incompleto = false;
            if( f.elements[0].value == "" )
               { alert(incompleto); }
           else{boton.type = 'button';}
       }
   </script>
   {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}



@endsection
