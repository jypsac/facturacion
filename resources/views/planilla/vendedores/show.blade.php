@extends('layout')

@section('title', 'vendedores')
@section('breadcrumb', 'vendedores-Ver')
@section('breadcrumb2', 'vendedores-Ver')
@section('href_accion', route('vendedores.index') )
@section('value_accion', 'Atras')

@section('content')

<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
     

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Codigo Vendedor</h4>
          
          <p class="form-control" >
          {{ $personal->cod_vendedor }}</p>
        </div>

        <div class="col-lg-6">
          <h4>Nombre Vendedor:</h4>
          <p class="form-control" >
          {{ $personal->personal->nombres }}</p>
           

        </div>
       
        <div class="col-lg-6">
         
          <h4>Tipo de Comision</h4>
           <p class="form-control" >
          {{ $personal->tipo_comision }}</p> 

         
          
        </div>
         <div class="col-lg-6">
         

          <h4> Comision</h4>
         
           <p class="form-control" >
          {{ $personal->comision }}</p> 
        </div>

      </div>


    </div> 
    </div> 
                              
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
    opacity: 0  ;
  }
</style>
@stop
  
