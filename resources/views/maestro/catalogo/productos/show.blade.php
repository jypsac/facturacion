@extends('layout')

@section('title', 'productos')
@section('breadcrumb', 'productos')
@section('breadcrumb2', 'productos')
@section('href_accion', route('productos.index'))
@section('value_accion', 'Atras')

@section('content')

<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">
	 <div class="ibox-title" align="left">
                    <h5>Vista Producto :</h5>
                     @if($producto->estado_anular == '1')
             <a  class="btn btn-sm btn-success" href="{{ route('productos.edit', $producto->id) }}" style="background-color: #1ab394; border-color: #1ab394;padding: 2px 4px"> <i style="font-size: 15px" class="fa fa-edit"></i></a>
           @elseif($producto->estado_anular == '0')
                                     @endif
        </div>
    <div class="row">
            
        <fieldset class="col-sm-6">    	
					<legend>Clasificacion del <br>Producto</legend>
					
				<div class="panel panel-default">
					<div class="panel-body" align="left">
						<div class="row">
							<label class="col-sm-2 col-form-label">Codigo:</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="codigo_producto" value="{{$producto->codigo_producto}}" disabled="disabled">
                    		</div>

                    		<label class="col-sm-2 col-form-label">Codigo Alernativo:</label>
                              <div class="col-sm-4"><input type="text" class="form-control" name="codigo_original" value="{{$producto->codigo_original}}" disabled="disabled"></div>
							</div>

						<div class="row">
							<label class="col-sm-2 col-form-label">Categoria:</label>
                               <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$producto->categoria_i_producto->descripcion}}" disabled="disabled">
                      			</div>

                  		 	<label class="col-sm-2 col-form-label">Marca:</label>
              					<div class="col-sm-4">
               						 <input type="text" class="form-control" value="{{$producto->marcas_i_producto->nombre}}" disabled="disabled">
                      			</div>
						</div>
						<div class="row">
							
                      			<label class="col-sm-2 col-form-label">Familia:</label>
                        		 <div class="col-sm-10">
                         		 <input type="text" class="form-control" value="{{$producto->familia_i_producto->descripcion}}" disabled="disabled">
                				</div>

						</div>
						<br>
				</div>
					
		</fieldset>		

		<fieldset class="col-sm-6">    	
					<legend>Datos del <br>Producto </legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								<label class="col-sm-2 col-form-label">Nombre:</label>
                              <div class="col-sm-10"><input type="text" class="form-control" value="{{$producto->nombre}}" disabled="disabled"></div>

                    			<label class="col-sm-2 col-form-label">Descripcion:</label>
                              <div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" rows="2" disabled="disabled">{{$producto->descripcion}}</textarea ></div>
							</div>
							<div class="row">
								<label class="col-sm-2 col-form-label">Estado:</label>
                    				<div class="col-sm-4">
                     					 <input type="text" class="form-control" value="{{$producto->estado_i_producto->nombre}}" disabled="disabled"> 
                     				</div>

                    			<label class="col-sm-2 col-form-label">Origen:</label>
                   				   <div class="col-sm-4">
                   				   	<input type="text" class="form-control" value="{{$producto->origen}}" disabled="disabled">
                   				   </div>

							</div>

						</div>
					</div>
					
		</fieldset>		

		<fieldset class="col-sm-6">    	
					<legend>Precio del <br>Producto</legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								 <label class="col-sm-2 col-form-label">Descuento1:</label>
                              <div class="col-sm-4">
                              	<div class="input-group m-b">
                  						<div class="input-group-prepend">
                    						<span class="input-group-addon">%</span>
                  						</div>
                  					<input type="number" class="form-control" name="descuento1" value="{{$producto->descuento1}}" disabled="disabled">
                				</div>
                   			 </div>

                   			 <label class="col-sm-2 col-form-label">Descuento2:</label>
                              <div class="col-sm-4">
                              	<div class="input-group m-b">
                  					<div class="input-group-prepend">
                    					<span class="input-group-addon">%</span>
                 					 </div>
                  					<input type="number" class="form-control" value="{{$producto->descuento2}}" disabled="disabled">
                 				</div>
                  			  </div>
                    			
						</div>
						<div class="row">
								 <label class="col-sm-2 col-form-label">Descuento Maximo:</label>
                              <div class="col-sm-4"><div class="input-group m-b">
                  <div class="input-group-prepend">
                    <span class="input-group-addon">%</span>
                  </div>
                  <input type="text" class="form-control" name="descuento_maximo" value="{{$producto->descuento_maximo}}" disabled="disabled" >
                </div>
                    </div>

                   			<label class="col-sm-2 col-form-label">Utilidad:</label>
                              <div class="col-sm-4"><div class="input-group m-b">
                  <div class="input-group-prepend">
                    <span class="input-group-addon">%</span>
                  </div>
                  <input type="text" class="form-control" name="utilidad" value="{{$producto->utilidad}}"  disabled="disabled">
                </div>
                    			
						</div>
					</div>
					<div class="row">
								 <label class="col-sm-2 col-form-label">Unida de medida:</label>
                              <div class="col-sm-4">
                              	<div class="input-group m-b">
	                  				 <input type="text" class="form-control" name="unidad_medida" value="{{$producto->unidad_i_producto->medida}}"  disabled="disabled">
               					 </div>
                  			  </div>
                          <label class="col-sm-2 col-form-label">Peso:</label>
                              <div class="col-sm-4">
                                <div class="input-group m-b">
                             <input type="text" class="form-control" name="peso" value="{{$producto->peso}}"  disabled="disabled">
                         </div>
                          </div>

                   			
                    			
						</div>
						<div class="row">
								 <label class="col-sm-2 col-form-label">garantia:</label>
                              <div class="col-sm-2"><input type="text" class="form-control" name="garantia"  value="{{$producto->garantia}}"  disabled="disabled">
                    		</div>

                   			<label class="col-sm-2 col-form-label">Stok Minimo:</label>
                              <div class="col-sm-2"><input type="text" class="form-control" name="stock_minimo" value="{{$producto->stock_minimo}}"  disabled="disabled" >
                    		</div>
                    		<label class="col-sm-2 col-form-label">Stock Maximo:</label>
                              <div class="col-sm-2"><input type="text" class="form-control" name="stock_maximo"  value="{{$producto->stock_maximo}}"  disabled="disabled">
                    </div>
                    			
						</div>
						


					</div>

						
					
		</fieldset>		
		<fieldset class="col-sm-6">    	
					<legend>Foto del <br>Producto </legend>
					
					<div class="panel panel-default">
						<div class="panel-body">
                              <div class="col-sm-12"><center>  <img src="
                                    {{ asset('/archivos/imagenes/productos/')}}/{{$producto->foto}}" style="width:390px; height: 205px;border-radius: 5px"></center></div>
						</div>
							
		</fieldset>		


    </div>

</div>

                
<style>
	.form-control{    margin-bottom: 15px;
}
   fieldset 
  {
    /*border: 1px solid #ddd !important;*/
    padding: 10px;       
    /*border-radius:4px ;*/
    background-color:#f5f5f5;
    padding-left:10px!important;
    padding-right:10px!important;
    margin-bottom: 10px;
    border-left: 1px solid #ddd !important;

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