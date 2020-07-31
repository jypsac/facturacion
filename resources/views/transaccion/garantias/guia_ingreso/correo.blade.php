@extends('layout')

@section('title', 'Enviar - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('vue_js',  asset('js/app.js') )

@section('content')
<div>
  <form action="{{route('garantia_ingreso.enviar')}}" method="POST" enctype="multipart/form-data">
    <div class="container">
          <div class="content-header"><!-- /.container-fluid -->
        </div>
        <br>
    	<div class="card-deck">
    		<div class="card" >
      		  <div class="card-body">
              
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
                <textarea  rows="4"  name="mensaje" class="form-control" placeholder="¿Que quieres enviar?" maxlength="855"></textarea>
              </div>
              <br>
              <div>Vista previa del pdf {{$id}} :
                	<!-- <iframe width="100%" height="110px" src="file:///C:/laragon/www/facturacion/storage/app/public/{{$id}}.pdf"     frameborder="1"></iframe>-->
                  <input type="hidden" value="{{$id}}" name="id">
              </div>
                <br>
              <div class="container">
                  <div class="col-sm-2">
                    <button type="submit" class="btn btn-success btn-block">Enviar</button>
                  </div>
              </div>
            
     
          </div>           
        </div>
      </div>
    </div>
  </form>
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