@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
@section('value_accion', 'Atras')

@section('content')
	            		
 <form action="{{route('garantia_guia_egreso.store')}}"  enctype="multipart/form-data" method="post">
									 	@csrf
									 	<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">
	
    <div class="row">
            
        <fieldset class="col-sm-6">    	
					<legend>Datos<br>Generales</legend>
			
					
				<div class="panel panel-default">
					<div class="panel-body" align="left">
						<div class="row">
							<label class="col-sm-2 col-form-label">Marca:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="marca" value="{{$garantias_guias_ingresos->marcas_i->nombre}}" readonly>
                    		</div>

                    		<label class="col-sm-2 col-form-label">Motivo:</label>
                              <div class="col-sm-4">
                             	 <input type="text" class="form-control" name="motivo" value="{{$garantias_guias_ingresos->motivo}}" readonly>
								</div>
							</div>

						<div class="row">
							<label class="col-sm-2 col-form-label">Orden de servicio:</label>
                               <div class="col-sm-4">
                                 <input type="text" class="form-control" name="orden_servicio" value="{{$garantias_guias_ingresos->orden_servicio}}" readonly>
                      			</div>

                  		 	<label class="col-sm-2 col-form-label">Fecha:</label>
              					<div class="col-sm-4">
               						<input type="text" class="form-control" name="fecha_uno" value="{{$tiempo_actual}}" readonly>
                      			</div>
						</div>


						<div class="row">
							
                      			<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
                        		 <div class="col-sm-10">
                         		<input type="text" class="form-control" name="ing_asignado" value="{{$garantias_guias_ingresos->personal_laborales->personal_l->nombres}}" readonly>
                				</div>

						</div>

						<div class="row">
							
                      			<label class="col-sm-2 col-form-label">Asunto:</label>
                        		 <div class="col-sm-10">
                         		<input type="text" class="form-control" name="asunto" value="{{$garantias_guias_ingresos->asunto}}" readonly>
                				</div>

						</div>


						
						<br>
				</div>
					
		</fieldset>		
		<fieldset class="col-sm-6">    	
					<legend> Datos del <br>  Cliente </legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								<label class="col-sm-2 col-form-label">Nombre:</label>
                              <div class="col-sm-10"><input type="text" class="form-control" name="nombre_cliente" value="{{$garantias_guias_ingresos->clientes_i->nombre}}" readonly></div>

                    			<label class="col-sm-2 col-form-label"> Direccion:</label>
                              <div class="col-sm-10"><input type="text" class="form-control" name="direccion" value="{{$garantias_guias_ingresos->clientes_i->direccion}}" readonly></div>
							</div>

							<div class="row">
								<label class="col-sm-2 col-form-label">Telefono:</label>
                              <div class="col-sm-10">
                     			<input type="text" class="form-control" name="telefono" value="{{$garantias_guias_ingresos->clientes_i->telefono}}" readonly>
                              	
                              </div>

                    			<label class="col-sm-2 col-form-label">Correo:</label>
                              <div class="col-sm-10">
                              	<input type="text" class="form-control" name="correo" value="{{$garantias_guias_ingresos->clientes_i->email}}" readonly>
                              </div>
                              <label class="col-sm-2 col-form-label">Contacto:</label>
                              <div class="col-sm-10">
                              	<input type="text" class="form-control" name="contacto" value="{{$garantias_guias_ingresos->contactos->nombre}}" readonly>
                              </div>
							</div>


						</div>
					</div>
					
		</fieldset>		


		<fieldset class="col-sm-12">    	
					<legend> Datos del <br> Equipoo </legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								<label class="col-sm-2 col-form-label">Modelo:</label>
                              <div class="col-sm-4"><input type="text" class="form-control" name="nombre_equipo" value="{{$garantias_guias_ingresos->nombre_equipo}}" readonly></div>

                    			<label class="col-sm-2 col-form-label">Nr Serie:</label>
                              <div class="col-sm-4"><input type="text" class="form-control" name="numero_serie" value="{{$garantias_guias_ingresos->numero_serie}}" readonly></div>
							</div>

							<div class="row">
								<label class="col-sm-2 col-form-label">Codigo Interno:</label>
                              <div class="col-sm-4">
                     					<input type="text" class="form-control" name="codigo_interno" value="{{$garantias_guias_ingresos->codigo_interno}}" readonly>
                              	
                              </div>

                    			<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
                              <div class="col-sm-4">
                              	<input type="text" class="form-control" name="fecha_compra" value="{{$garantias_guias_ingresos->fecha_compra}}" readonly>
                              </div>
							</div>


						</div>
					</div>
					
		</fieldset>		

		<fieldset class="col-sm-12">    	
					<legend> Informe del <br>Problema</legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								 <label class="col-sm-2 col-form-label">Descripcion del Problema:</label>
                              <div class="col-sm-10">
                              	<div class="input-group m-b">
                  					<textarea class="form-control" rows="5" id="comment" name="descripcion_problema" maxlength="630" required></textarea>
                				</div>
                   			 </div>

                   			
							</div>
						</div>

					</div>

					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								 <label class="col-sm-2 col-form-label"> Diagnostico y Solucion:</label>
                              <div class="col-sm-10">
                              	<div class="input-group m-b">
                  				<textarea class="form-control" rows="5" id="comment" name="diagnostico_solucion"  maxlength="630" required></textarea>
                				</div>
                   			 </div>

                   			
							</div>
						</div>

					</div>
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								 <label class="col-sm-2 col-form-label">Recomendaciones:</label>
                              <div class="col-sm-10">
                              	<div class="input-group m-b">
                  				<textarea class="form-control" rows="5" id="comment" name="recomendaciones"  maxlength="630" required></textarea>
                				</div>
                   			 </div>

                   			
							</div>
						</div>

					</div>

						
					
		</fieldset>	
		 <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button>
	                       


    </div>

</div>
 </form>	
                
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


@stop