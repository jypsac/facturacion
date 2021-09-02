@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
<form action="{{route('garantia_guia_egreso.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
	@csrf

	 <div class="ibox-content p-xl" style=" margin-bottom: 2px;padding-bottom: 50px;">
		<br>
		<div class="row" style="height: 120px">
            <div class="col-sm-4 text-left" align="left">
                <div class="form-control" align="center" style="height: 79%;" align="left">
                    <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
                </div>
            </div>
            <div class="col-sm-4" align="center">
                <div class="form-control" align="center" style="height: 79%;" align="center"  >
                    <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantias_guias_ingresos->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                 </div>
            </div>
            <div class="col-sm-4" align="right" >
                <div class="form-control" align="center" style="height: 79%;"align="right">
                    <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                    <h2 style="font-size: 19px">GUIA DE EGRESO</h2>
                    <h5>{{$garantias_guias_ingresos->orden_servicio}}<input type="hidden" name="orden_servicio" value="{{$garantias_guias_ingresos->orden_servicio}}">
</h5>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
        	<div class="col-sm-6" align="center" >
                <div class="form-control">
                    <h3>Datos Generales </h3>
                    <br>
                    <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
                		{{-- <input type="text" class="form-control" name="marca_id" value="{{$marca_nombre}}" readonly hidden=""> --}}
                		<label class="col-sm-2 col-form-label">Asunto:</label>
                		<div class="col-sm-4">
                     		<input type="text" class="form-control" name="asunto" value="{{$garantias_guias_ingresos->asunto}}" readonly>
        				</div>
	          			<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
                 		<div class="col-sm-4">
                		 	<input type="text" class="form-control" name="ing_asignado" value="{{$garantias_guias_ingresos->personal_laborales->nombres}}" readonly>
        				</div>
        				<label class="col-sm-2 col-form-label">Motivo:</label>
                        <div class="col-sm-4">
                        	<input type="text" class="form-control" name="motivo" value="{{$garantias_guias_ingresos->motivo}}" readonly>
                    	</div>
                        <label class="col-sm-2 col-form-label">Fecha:</label>
      					<div class="col-sm-4">
	   						<input type="text" class="form-control" name="fecha_uno" value="{{$tiempo_actual}}" readonly>
	          			</div>
    				</div>
    				<br>
            	</div>
        	</div>
        	<div class="col-sm-6" align="center">
        		<div class="form-control">
        			<h3>Datos del Cliente</h3>
        			<br>
        			<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
        				<label class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-4">
                        	<input type="text" class="form-control" name="nombre_cliente" value="{{$garantias_guias_ingresos->clientes_i->nombre}}" readonly>
                        </div>
                        {{-- <label class="col-sm-2 col-form-label"> Direccion:</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="direccion" value="{{$garantias_guias_ingresos->clientes_i->direccion}}" readonly>
                        </div> --}}
                        <label class="col-sm-2 col-form-label">Telefono:</label>
                    	<div class="col-sm-4">
             				<input type="text" class="form-control" name="telefono" value="{{$garantias_guias_ingresos->clientes_i->telefono}}" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Correo:</label>
                    	<div class="col-sm-10">
                     		<input type="text" class="form-control" name="correo" value="{{$garantias_guias_ingresos->clientes_i->email}}" readonly>
                		</div>
        			</div>
        			<br>
        		</div>
        	</div>
        	<div class="col-sm-12" align="center">
        		<br>
        		<div class="form-control">
        			<h3>Datos del Equipo</h3>
        			<br>
        			<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
        				<label class="col-sm-2 col-form-label">Modelo:</label>
                        <div class="col-sm-4">
                        	<input type="text" class="form-control" name="nombre_equipo" value="{{$garantias_guias_ingresos->nombre_equipo}}" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label"> Nr Serie:</label>
                        <div class="col-sm-4">
                        	<input type="text" class="form-control" name="numero_serie" value="{{$garantias_guias_ingresos->numero_serie}}" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Codigo Interno:</label>
                    	<div class="col-sm-4">
             				<input type="text" class="form-control" name="codigo_interno" value="{{$garantias_guias_ingresos->codigo_interno}}" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Fecha Compra:</label>
                    	<div class="col-sm-4">
                     		<input type="text" class="form-control" name="fecha_compra" value="{{$garantias_guias_ingresos->fecha_compra}}" readonly>
                		</div>
        			</div>
        			<br>
        		</div>
        	</div>
        	<div class="col-sm-12" align="center">
        		<br>
        		<div class="form-control">
					<h3>Informe del Problema</h3>
					<br>
					<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
	            		<div class="col-sm-4">
	            			<center><h4>Descripcion del Problema</h4></center>
	            			<div class="input-group m-b">
	            				<textarea class="form-control" rows="5" id="comment" name="descripcion_problema" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
	        				</div>
	            		</div>
	            		<div class="col-sm-4">
	            			<center><h4>Diagnostico y Solucion</h4></center>
	            			<div class="input-group m-b">
	            				<textarea class="form-control" rows="5" id="comment" name="diagnostico_solucion"  maxlength="1230" required style="resize: none;height: 300px;"></textarea>
	        				</div>
	            		</div>
	            		<div class="col-sm-4">
	            			<center><h4>Recomendaciones</h4></center>
	            			<div class="input-group m-b">
								<textarea class="form-control" rows="5" id="comment" name="recomendaciones"  maxlength="1230" required style="resize: none;height: 300px;"></textarea>
	        				</div>
	            		</div>
	            	</div>
        		</div>
        		<br>
        		<button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" id="boton"><strong>Grabar</strong></button>
        	</div>
    	</div>
    </div>
 </form>
</div>
<style>
	.form-control{margin-top: 5px; border-radius: 5px}
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

 {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
        <script>
            function valida(f) {
                var boton=document.getElementById("boton");
                var completo = true;
                var incompleto = false;
                if( f.elements[0].value == "" )
                   { alert(incompleto); }
               else{boton.type = 'button';}
           }
       </script>
       {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
@stop