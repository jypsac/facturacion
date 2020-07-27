@extends('layout')

@section('title', 'Enviar - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('vue_js',  asset('js/app.js') )
@section('content')
<div>
  <div class="container">
        <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <br>
  	<div class="card-deck">
  		<div class="card" >
    		  <div class="card-body">
            <form action="{{route('garantia_ingreso.enviar')}}" method="POST" enctype="multipart/form-data">
              @csrf
               <div class="container">
                <div class=" row mb-2 ">
                  <div class="  col-sm-6">
                  Remitente: <input type="text"  class="form-control" value="{{ Auth::user()->email}}" readonly="">
                  </div>
                  <div class=" col-sm-6">
                    Destinatario<input type="text" name="sendto" class="form-control" placeholder="¿A quien vas a enviar?">               
                  </div>
                  </div>  
      	    </div>
      	    <div class="col-sm-12">Titulo:<input type="text" name="titulo" class="form-control" placeholder="Titulo"></div> 
            <div class="col-sm-12">Descripcion: 
              <textarea  name="mensaje" class="form-control" placeholder="¿Que quieres enviar?" maxlength="855"></textarea>
            </div>
            <br>
            <div>Vista previa del pdf {{$id}} :
              	<iframe width="100%" height="20px" src=""     frameborder="1"></iframe>
                <input type="text" value="{{$id}}" name="id">
            </div>
              <br>
            <div class="container">
                <div class="col-sm-2">
                  <button type="submit" class="btn btn-success btn-block">Enviar</button>
                </div>
            </div>
          </form>
   
        </div>           
      </div>
    </div>
  </div>
</div>
@stop