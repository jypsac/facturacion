@extends('layout')

@section('title', 'vendedores')
@section('breadcrumb', 'vendedores-Agregar')
@section('breadcrumb2', 'vendedores-Agregar')
@section('href_accion', route('vendedores.index') )
@section('value_accion', 'Atras')

@section('content')

<form action="{{ route('vendedores.store') }}"  enctype="multipart/form-data" method="post">
						@csrf
<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
     

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Codigo Vendedor</h4>
          <p><input type="text" class="form-control" name="cod_vendedor" value="VE00{{$suma}}" readonly='readonly'></p>
        </div>

        <div class="col-lg-6">
          <h4>Nombre Vendedor:</h4>
          <p>
            <select class="form-control" name="id_personal" required="required">
                <option value="">Seleccione Trabajador</option>
               @foreach($personal as $personals)
                            <option value="{{ $personals->id }}">{{ $personals->nombres }}</option>
                            @endforeach
            </select></p>  

        </div>
       
        <div class="col-lg-6">
         
          <h4>Tipo de Comision</h4>
          <p>
          <select class="form-control" name="tipo_comision" required="required">
                <option value="Porcentaje de Venta">Porcentaje de Venta</option>
                <option value="Monto Fijo">Monto Fijo</option>
            </select></p>   

         
          
        </div>
         <div class="col-lg-6">
         

          <h4> Comision</h4>
          <p><input type="text" class="form-control" name="comision" value="" required="required"></p> 
          
        </div>


        <div class="col-lg-6">
        <button class="btn btn-primary" type="submit">Grabar</button>
      </div>
      </div>


    </div> 
    </div> 
    </form> 
                              
        	<!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <style type="text/css">
    	img{border-radius: 40px}
	    p#texto{text-align: center;
				color:black;
				}
								
	input#archivoInput{
		position:absolute;
		top:25%;
		left:80%;
		right:0px;
		bottom:58%;
		width:15%;
		opacity: 0	;
	}
</style>
@stop
  
