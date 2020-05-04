@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')

@section('content')

<form action="{{ route('garantia_guia_ingreso.actualizar',$garantia_guia_ingreso->id) }}"  enctype="multipart/form-data" method="post">
    @csrf
    @method('put')
	            		
<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">
	
    <div class="row">
            
        <fieldset class="col-sm-6">    	
					<legend>Datos<br>Generales</legend>
			
					
				<div class="panel panel-default">
					<div class="panel-body" align="left">
						<div class="row">
							<label class="col-sm-2 col-form-label">Marca:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="marca" value="{{$garantia_guia_ingreso->marcas_i->nombre}}" readonly>
                    		</div>

                    		<label class="col-sm-2 col-form-label">Motivo:</label>
                              <div class="col-sm-4">
                             	<select class="form-control m-b" name="motivo">
                             	 					<option value="{{$garantia_guia_ingreso->motivo}}">{{$garantia_guia_ingreso->motivo}}</option>
										    		<option value="Garantia">Garantia</option>
										    		<option value="Servicio">Servicio</option>
										    		<option value="Informativo">Informativo</option>
										    		<option value="Reingreso">Reingreso</option>
								</select>
								</div>
							</div>

						<div class="row">
							<label class="col-sm-2 col-form-label">Orden de servicio:</label>
                               <div class="col-sm-4">
                                  <input type="text" class="form-control" name="orden_servicio" value="{{$garantia_guia_ingreso->orden_servicio}}" readonly>
                      			</div>

                  		 	<label class="col-sm-2 col-form-label">Fecha:</label>
              					<div class="col-sm-4">
               						<input type="text" class="form-control" name="fecha" value="{{$garantia_guia_ingreso->fecha}}" readonly>
                      			</div>
						</div>


						<div class="row">
							
                      			<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
                        		 <div class="col-sm-10">
                         		<select class="form-control m-b" name="personal_lab_id">
													@foreach($personales as $personal)
												<option value="{{$personal->id}}">{{$personal->nombres}} {{$personal->apellidos}} </option>
													@endforeach
												</select>
                				</div>

						</div>

						<div class="row">
							
                      			<label class="col-sm-2 col-form-label">Cliente:</label>
                        		 <div class="col-sm-10">
                         		<select class="form-control m-b" name="cliente_id">
												   @foreach($clientes as $cliente)
												   <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
												   @endforeach
											   </select>
                				</div>

						</div>
						<div class="row">
							
                      			<label class="col-sm-2 col-form-label">Asunto:</label>
                        		 <div class="col-sm-10">
                         		<input type="text" class="form-control" name="asunto" value="{{$garantia_guia_ingreso->asunto}}" required>
                				</div>

						</div>


						
						<br>
				</div>
					
		</fieldset>		

		<fieldset class="col-sm-6">    	
					<legend> Datos del <br> Equipoo </legend>
					
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								<label class="col-sm-2 col-form-label">Modelo:</label>
                              <div class="col-sm-10"><input type="text" class="form-control" name="nombre_equipo" value="{{$garantia_guia_ingreso->nombre_equipo}}" required></div>

                    			<label class="col-sm-2 col-form-label">Nr Serie:</label>
                              <div class="col-sm-10"><input type="text" class="form-control" name="numero_serie" value="{{$garantia_guia_ingreso->numero_serie}}" required></div>
							</div>

							<div class="row">
								<label class="col-sm-2 col-form-label">Codigo Interno:</label>
                              <div class="col-sm-10">
                     					<input type="text" class="form-control" name="codigo_interno" value="{{$garantia_guia_ingreso->codigo_interno}}" required>
                              	
                              </div>

                    			<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
                              <div class="col-sm-10">
                              	
                   				<input type="date" class="form-control" name="fecha_compra" max="{{$garantia_guia_ingreso->fecha_compra}}" value="{{$garantia_guia_ingreso->fecha_compra}}" required>
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
                  					<textarea class="form-control" rows="5" id="comment" name="descripcion_problema" maxlength="630" required>{{$garantia_guia_ingreso->descripcion_problema}}</textarea>
                				</div>
                   			 </div>

                   			
							</div>
						</div>

					</div>

					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								 <label class="col-sm-2 col-form-label">Revisión y diagnóstico:</label>
                              <div class="col-sm-10">
                              	<div class="input-group m-b">
                  				<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico"  maxlength="630"required>{{$garantia_guia_ingreso->revision_diagnostico}}</textarea>
                				</div>
                   			 </div>

                   			
							</div>
						</div>

					</div>
					<div class="panel panel-default">
						<div class="panel-body" align="left">
							<div class="row">
								 <label class="col-sm-2 col-form-label">Estetica:</label>
                              <div class="col-sm-10">
                              	<div class="input-group m-b">
                  				<textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="630" required>{{$garantia_guia_ingreso->estetica}}</textarea>
                				</div>
                   			 </div>

                   			
							</div>
						</div>

					</div>

						
					
		</fieldset>	
		 <center><button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button></center>
	                       


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