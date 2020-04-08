@extends('layout')

@section('title', 'vendedores')
@section('breadcrumb', 'vendedores-Editar')
@section('breadcrumb2', 'vendedores-Editar')
@section('href_accion', route('vendedores.index') )
@section('value_accion', 'Atras')

@section('content')


<form action="{{ route('vendedores.update',$personal->id) }}"  enctype="multipart/form-data" method="post">
            @csrf
              @method('PATCH')
            
<div style="padding-top: 20px;">
<div class="container" style=" padding-top: 30px; background: white;">
     
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Codigo Vendedor</h4>
          
          <p>
         <input type="text" name="cod_vendedor" class="form-control" value="{{ $personal->cod_vendedor }}" disabled="disabled"> </p>
        </div>

        <div class="col-lg-6">
          <h4>Nombre Vendedor:</h4>
          <p>
          <input type="text" name="nombre" class="form-control" value=" {{ $personal->personal->personal_l->nombres}} - {{ $personal->personal->tipo_trabajador}}" readonly="readonly"></p>
           

        </div>
       
        <div class="col-lg-6">
         
          <h4>Tipo de Comision</h4>
           <p>
          <select class="form-control" name="tipo_comision" required="required">
                <option value="{{$personal->tipo_comision }}"> {{$personal->tipo_comision }}</option>
                @if($personal->tipo_comision == 'Porcentaje de Venta' )
                <option value="Monto Fijo">Monto Fijo</option>
                @elseif($personal->tipo_comision == 'Monto Fijo')
                <option value="Porcentaje de Venta">Porcentaje de Venta</option>
                @endif
            </select></p> 

         
          
        </div>
         <div class="col-lg-6">
         

          <h4> Comision</h4>
         
           <p>
         <input type="text" class="form-control" name="comision" value="{{ $personal->comision }}"> </p> 
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

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
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
  
