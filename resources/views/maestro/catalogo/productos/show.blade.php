@extends('layout')

@section('title', 'productos')
@section('breadcrumb', 'productos')
@section('breadcrumb2', 'productos')
@section('href_accion', route('productos.index'))
@section('value_accion', 'Atras')

@section('content')

<div class="ibox-content" style="margin-top: 5px" align="center">
	
    <div class="row">
            
        <fieldset class="col-sm-6">    	
					<legend>Fieldset Title</legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<label class="col-sm-2 col-form-label">Codigo:</label><div class="col-sm-5"><input type="text" class="form-control" name="codigo_producto" value="{{$producto->codigo_producto}}" disabled="disabled">
                    </div>
						</div>
					</div>
					
		</fieldset>		
		<fieldset class="col-sm-6">    	
					<legend>Fieldset Title</legend>
					
					<div class="panel panel-default">
						<div class="panel-body">
							<p>Fieldset content...</p>
						</div>
					</div>
					
		</fieldset>				
				
				
    </div>
</div>
                
<style>
   fieldset 
  {
    border: 1px solid #ddd !important;
    padding: 10px;       
    border-radius:4px;
    background-color:#f5f5f5;
    padding-left:10px!important;
  } 
  
    legend
    {
      font-size:14px;
      font-weight:bold;
      margin-bottom: 0px; 
      width: 35%; 
      border: 1px solid #ddd;
      border-radius: 4px; 
      padding: 5px 5px 5px 10px; 
      background-color: #ffffff;
    } 
</style>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection