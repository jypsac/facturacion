@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
{{-- @section('vue_js',  asset('js/app.js') ) --}}
@section('content')
    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });


        });
    </script>
@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'garantia_guia_ingreso')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	@if($errors->any())
	<div class="alert alert-danger">
        <a class="alert-link" href="#">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</a>
    </div>
	@endif
	<div class="ibox">
		<div class="ibox-content" style=" margin-bottom: 2px;padding-bottom: 50px;padding: 30px;">
			 <div class="row" style="height: 120px">
                    <div class="col-sm-4 text-left" align="left">
                        <div class="form-control" align="center" style="height: 79%;" align="left">
                            <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" align="center" style="height: 79%;" align="center"  >
                            <img align="center" src="{{asset('archivos/imagenes/marcas/'.$marca_t->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                         </div>
                    </div>
                    <div class="col-sm-4" align="right" >
                        <div class="form-control" align="center" style="height: 79%;"align="right">
                            <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">GUIA DE INGRESO</h2>
                            <h5>{{$orden_servicio}}</h5>
                        </div>
                    </div>
                </div>
                <br>
                <form action="{{route('garantia_guia_ingreso.store')}}"  enctype="multipart/form-data" 	method="post" onsubmit="return valida(this)">
            	@csrf
            		<input type="hidden" name="orden_servicio" value="{{$orden_servicio}}">
            		<div class="row" >
            			<div class="col-sm-6" align="center" >
	                        <div class="form-control">
	                            <h3>Datos Generales </h3>
	                            <br>
	                            <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
	                        		<input type="text" class="form-control" name="marca_id" value="{{$marca_nombre}}" readonly hidden="">
	                        		<label class="col-sm-2 col-form-label">Asunto:</label>
	                        		<div class="col-sm-4">
		                         		<input type="text" class="form-control" name="asunto" required/>
	                				</div>
				          			<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
	                         		<div class="col-sm-4">
	                        		 	<input type="text" class="form-control m-b" value="{{Auth::user()->personal->nombres}}"  name="personal_lab_id" id="" readonly="">
	                				</div>
	                				<label class="col-sm-2 col-form-label">Motivo:</label>
		                            <div class="col-sm-4">
		                            	<select class="form-control m-b" name="motivo">
								    		<option value="Garantia">Garantia</option>
								    		<option value="Servicio">Servicio</option>
								    		<option value="Informativo">Informativo</option>
								    		<option value="Reingreso">Reingreso</option>
										</select>
	                            	</div>
		                            <label class="col-sm-2 col-form-label">Fecha:</label>
		          					<div class="col-sm-4">
				   						<input type="text" class="form-control" name="fecha" value="{{$tiempo_actual}}" readonly>
				          			</div>

				          			<label class="col-sm-2 col-form-label">Cliente:</label>
	                        		<div class="col-sm-10">
		                         		<input list="browsersc1" class="form-control m-b" name="cliente_id" id="cliente_id" required autocomplete="off" >
										<datalist id="browsersc1" >
											@foreach($clientes as $cliente)
												<option id="{{$cliente->id}}">{{$cliente->numero_documento}}- {{$cliente->nombre}}</option>
											@endforeach
										 </datalist>
	                				</div>
	                				<label class="col-sm-2 col-form-label">Contacto:</label>
	                        		 <div class="col-sm-10">
	                        		 	<input list="contacto_cliente" type="text" class="form-control m-b" name="contacto_cliente"   id=""    autocomplete="off"  >
	                         			<datalist id="contacto_cliente" ></datalist>
	                				</div>
	                        	</div>
	                    	</div>
                    	</div>
	                	<div class="col-sm-6" align="center">
	                        <div class="form-control">
	                            <h3>Datos del Equipo</h3>
	                            <br>
	                            <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
                        		{{-- <strong>Marca</strong><input type="text" class="form-control" name="marca_id" value="{{$marca_nombre}}" readonly> --}}
	                        		<label class="col-sm-2 col-form-label">Modelo:</label>
		                            <div class="col-sm-10">
		                              	<input name="nombre_equipos" list="browserprod"   class="form-control" autocomplete="off" />
		                              	<datalist id="browserprod">
			                              	@foreach($productos as $producto)
				                              	<option  id="{{$producto->nombre}}">{{$producto->nombre}}</option>
			                              	@endforeach
		                              	</datalist>
		                            </div>
	                    			<label class="col-sm-2 col-form-label">Nr Serie:</label>
	                        	    <div class="col-sm-10">
	                        	     	<input type="text" class="form-control" name="numero_serie" required>
		                            </div>
									<label class="col-sm-2 col-form-label">Codigo Interno:</label>
	                            	<div class="col-sm-10">
                     					<input type="text" class="form-control" name="codigo_interno" required>
	                             	</div>
	                    			<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
	                              	<div class="col-sm-10">
		                   					<input type="date" class="form-control" name="fecha_compra" max="{{$orden_servicio}}" required>
	                              	</div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                        	<div class="form-control">
                        		<center><h3>Informe del Problema</h3></center>
                        		<br>
	                            <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
	                        		<div class="col-sm-4">
	                        			<center><h4>Descripcion del Problema</h4></center>
	                        			<div class="input-group m-b">
			                  				<textarea class="form-control" rows="5" id="comment" name="descripcion_problema" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
		                				</div>
	                        		</div>
	                        		<div class="col-sm-4">
	                        			<center><h4>Revisión y diganostico</h4></center>
	                        			<div class="input-group m-b">
			                  				<textarea class="form-control" rows="5" id="comment" name="revision_diagnostico" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
		                				</div>
	                        		</div>
	                        		<div class="col-sm-4">
	                        			<center><h4>Estética</h4></center>
	                        			<div class="input-group m-b">
		                  					<textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
		                				</div>
	                        		</div>
	                        	</div>
                        	</div>
                        	{{-- <div align="ibox" align="right"> --}}
                        		<button style="align: left" class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" id="boton"><strong>Grabar</strong></button>
                        	{{-- </div> --}}
                        </div>
            		</div>
                </form>
		</div>
	</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript">
	$('#cliente_id').on('keyup',function(){
		$value = $(this).val();
	$.ajax({
		type: 'get',
		url: '{{URL::to('contacto_cliente')}}',
		data: {'cliente_id':$value},
		success:function(data){
			$('#contacto_cliente').html(data);
		}
	})
	})
</script>
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
{{-- <script type="text/javascript">
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script> --}}
<style>
    .form-control{border-radius: 10px; border: 1px solid #e5e6e7;}
    .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
    .check{-webkit-appearance: none;height: 34px;background-color: #ffffff00;-moz-appearance: none;border: none;appearance: none;width: 80px;border-radius: 10px;}
    .div_check{position: relative;top: -33px;left: 0px;background-color: #ffffff00;  top: -35;}
    .check:checked {background: #0375bd6b;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    input[type=number] { -moz-appearance:textfield; }
</style>

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

        <!-- Jquery Validate -->
        <script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

        <!-- Steps -->
        <script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>


@stop