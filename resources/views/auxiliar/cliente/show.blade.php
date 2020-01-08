@extends('layout')

@section('title', 'cliente ver')
@section('breadcrumb', 'cliente ver')
@section('breadcrumb2', 'ver cliente')
@section('href_accion', route('cliente.index'))
@section('value_accion', 'atras')

@section('content')

<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
      <div class="jumbotron" style="height: 50px;padding:10px">
       <center><h1>{{$cliente_show->nombre}}</h1> </center>
      </div>
<h1><i class="fa fa-user-o" aria-hidden="true"></i></h1>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Direccion:</h4>
          <p>{{$cliente_show->direccion}}</p><hr>

          <h4>Telefono:</h4>
          <p>{{$cliente_show->telefono}}</p><hr>

          <h4>Email:</h4>
          <p>{{$cliente_show->email}}</p><hr>
        </div>

        <div class="col-lg-6">
          <h4>Tipo de Documento:</h4>
          <p>{{$cliente_show->documento_identificacion}}</p><hr>

          <h4>Numero de Documento:</h4>
          <p>{{$cliente_show->numero_documento}}</p><hr>

          <h4>Celular:</h4>
          <p>{{$cliente_show->celular}}</p><hr>

        </div>

    </div> 
    <div style="padding-bottom: 10px">
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
    @endforeach
    </div>
                           
</div>
</div>
@endsection