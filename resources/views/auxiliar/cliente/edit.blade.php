@extends('layout')

@section('title', 'cliente editar')
@section('breadcrumb', 'cliente editar')
@section('breadcrumb2', 'cliente editar')
@section('href_accion', route('cliente.index'))
@section('value_accion', 'atras')

@section('content')

<div style="padding-top: 20px">
<div class="container" style="height:1000px ; padding-top: 30px; background: white;">
<form action="{{ route('cliente.update',$cliente->id) }}"  enctype="multipart/form-data" method="post">
  @csrf
@method('PATCH')

      <div class="jumbotron" style="height: 60px;padding:10px">
       <center><input style="width: 250px;font-size: 18px;" type="text" class="form-control" name="nombre" value="{{$cliente->nombre}}"></center>
      </div>

<h1><i class="fa fa-user-o" aria-hidden="true"></i></h1>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Direccion:</h4>
         <p><input type="text" class="form-control" name="direccion" value="{{$cliente->direccion}}"></p>

          <h4>Telefono:</h4>
          <p><input type="number" class="form-control" name="telefono" value="{{$cliente->telefono}}"></p>

          <h4>Email:</h4>
          <p><input type="email" class="form-control" name="email" value="{{$cliente->email}}"></p>
        </div>

        <div class="col-lg-6">
          <h4>Tipo de Documento:</h4>
          <select class="form-control m-b" name="documento_identificacion">
														
				<option value="{{$cliente->documento_identificacion}}">{{$cliente->documento_identificacion}}</option>
					@if($cliente->documento_identificacion == 'DNI')
						<option value="Pasaporte"> Pasaporte</option>
					@elseif($cliente->documento_identificacion == 'Pasaporte')
						<option value="DNI">DNI</option>
					@endif
			</select>
		

          <h4>Numero de Documento:</h4>
          <p><input type="text" class="form-control" name="numero_documento" value="{{$cliente->numero_documento}}"></p>

          <h4>Celular:</h4>
          <p><input type="number" class="form-control" name="celular" value="{{$cliente->celular}}"></p>

        </div>

    </div> {{-- 
    @foreach($contacto_show as $contacto)
  <h1><i class="fa fa-address-book-o" aria-hidden="true"></i>  </h1>
    <div class="row marketing">
    	<div class="col-lg-6">
    	  <h4>Nombre del Contacto:</h4>
          <p>{{$contacto->nombre}}</p><hr>
    	  <h4>Cargo:</h4>
          <p>{{$contacto->cargo}}</p><hr>
    	</div>
    	<div class="col-lg-6">
    	  <h4>Telefono/Celular:</h4>
          <p>{{$contacto->telefono}} / {{$contacto->celular}}</p><hr>
    	  <h4>Email:</h4>
          <p>{{$contacto->email}}</p><hr>
    	</div>
    	
    </div>
    @endforeach --}}
                           

<button class="btn btn-primary" type="submit">Guardar</button>
</form>
</div>
</div>
@endsection
	