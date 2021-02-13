	@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_informe_tecnico.index'))
@section('value_accion', 'Atras')
@section('content')

 <form action="{{route('garantia_informe_tecnico.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
 	@csrf
 	<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">
    <div class="row">
      <fieldset class="col-sm-6" style="align-items: center;">
			 <legend>Datos<br>Generales</legend>
				<div class="panel panel-default">
    			<div class="panel-body" align="left">
		    		<div class="row">
					      <label class="col-sm-2 col-form-label">Marca:</label>
					        <div class="col-sm-4">
						          <input type="text" class="form-control" name="marca" value="{{$garantia_guia_egreso->garantia_ingreso_i->marcas_i->nombre}}" readonly>
                	</div>
              		<label class="col-sm-2 col-form-label">Motivo:</label>
                    <div class="col-sm-4">
                     	<input type="text" class="form-control" name="motivo" value="{{$garantia_guia_egreso->garantia_ingreso_i->motivo}}" readonly>
						        </div>
					  </div>
				    <div class="row">
					    <label class="col-sm-2 col-form-label">Orden de servicio:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="orden_servicio" value="{{$garantia_guia_egreso->garantia_ingreso_i->orden_servicio}}" readonly>
                </div>
              	<label class="col-sm-2 col-form-label">Fecha:</label>
          			<div class="col-sm-4">
           			  <input type="text" class="form-control" name="fecha_uno" value="{{$tiempo_actual}}" readonly>
                </div>
				    </div>
				    <div class="row">
              <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
              <div class="col-sm-10">
              	<input type="text" class="form-control" name="ing_asignado" value="{{$garantia_guia_egreso->garantia_ingreso_i->personal_laborales->nombres}}" readonly>
            	</div>
				    </div>
				    <div class="row">
        			<label class="col-sm-2 col-form-label">Asunto:</label>
        		  <div class="col-sm-10">
             		<input type="text" class="form-control" name="asunto" value="{{$garantia_guia_egreso->garantia_ingreso_i->asunto}}" readonly>
      				</div>
				    </div>
					<br>
			    </div>
        </div>
	    </fieldset>
	    <fieldset class="col-sm-6">
			<legend> Datos del <br>  Cliente </legend>
				<div class="panel panel-default">
					<div class="panel-body" align="left">
						<div class="row">
							<label class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="nombre_cliente" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->nombre}}" readonly></div>
              <label class="col-sm-2 col-form-label"> Direccion:</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="direccion" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->direccion}}" readonly></div>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">Telefono:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="telefono" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->telefono}}" readonly>
              </div>
              <label class="col-sm-2 col-form-label">Correo:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="correo" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->email}}" readonly>
                </div>
{{--                 <label class="col-sm-2 col-form-label">Contacto:</label>
                <div class="col-sm-10">
                	<input type="text" class="form-control" name="contacto" value="{{$garantia_guia_egreso->garantia_ingreso_i->contactos->nombre}}" readonly>
                </div> --}}
						</div>
				  </div>
			  </div>
      </fieldset>
	    <fieldset class="col-sm-12">
	    <legend> Datos del <br> Equipo </legend>
  			<div class="panel panel-default">
  				<div class="panel-body" align="left">
  					<div class="row">
  						<label class="col-sm-2 col-form-label">Modelo:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="nombre_equipo" value="{{$garantia_guia_egreso->garantia_ingreso_i->nombre_equipo}}" readonly>
              </div>
              <label class="col-sm-2 col-form-label">Nr Serie:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="numero_serie" value="{{$garantia_guia_egreso->garantia_ingreso_i->numero_serie}}" readonly>
              </div>
  					</div>
  					<div class="row">
  						<label class="col-sm-2 col-form-label">Codigo Interno:</label>
              <div class="col-sm-4">
          			<input type="text" class="form-control" name="codigo_interno" value="{{$garantia_guia_egreso->garantia_ingreso_i->codigo_interno}}" readonly>
              </div>
              <label class="col-sm-2 col-form-label">Fecha de Compra:</label>
              <div class="col-sm-4">
               	<input type="text" class="form-control" name="fecha_compra" value="{{$garantia_guia_egreso->garantia_ingreso_i->fecha_compra}}" readonly>
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
            <label class="col-sm-1 col-form-label"> Estetica:</label>
              <div class="col-sm-5">
                <div class="input-group m-b">
                  <textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="630" required></textarea>
                </div>
              </div>
              <label class="col-sm-1 col-form-label">  Revision y Diagnostico:</label>
              <div class="col-sm-5">
                <div class="input-group m-b">
                  <textarea class="form-control" rows="5" id="comment" name="revision_diagnostico"  maxlength="630" required></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body" align="left">
            <div class="row">
              <label class="col-sm-1 col-form-label">Causas de problema:</label>
              <div class="col-sm-5">
                <div class="input-group m-b">
                  <textarea class="form-control" rows="5" id="comment" name="causas_del_problema"  maxlength="630" required></textarea>
                </div>
              </div>
              <label class="col-sm-1 col-form-label">Solucion:</label>
              <div class="col-sm-5">
                <div class="input-group m-b">
                  <textarea class="form-control" rows="5" id="comment" name="solucion"  maxlength="630" required></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body" align="left">
            <div class="field" align="left">
              <h3>Imagenes</h3>
               <input  type="file" name="files[]" id="files"  multiple=""  accept="image/jpeg/svg/png/jpg" />
            </div>

          </div>
        </div>
      </fieldset>
	    <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" id="boton">
        <strong>Grabar</strong>
      </button>
    </div>
  </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<br><br><br><br><br>
<style type="text/css">
  input[type="file"] {
     display: block;
}
.imageThumb {
     max-height: 75px;
     border: 2px solid;
     padding: 1px;
     cursor: pointer;
}
.pip {
     display: inline-block;
     margin: 10px 10px 0 0;
}
.remove {
     display: block;
     background: #444;
     border: 1px solid black;
     color: white;
     text-align: center;
     cursor: pointer;
}
.remove:hover {
     background: white;
     color: black;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
     if (window.File && window.FileList && window.FileReader) {
       $("#files").on("change", function(e) {
         var files = e.target.files,
           filesLength = files.length;
         for (var i = 0; i < filesLength; i++) {
           var f = files[i]
           var fileReader = new FileReader();
           fileReader.onload = (function(e) {
             var file = e.target;
             $("<span class=\"pip\">" +
               "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
               "<br/><span class=\"remove\">Remove image</span>" +
               "</span>").insertAfter("#files");
             $(".remove").click(function(){
               $(this).parent(".pip").remove();
             });
           });
           fileReader.readAsDataURL(f);
         }
       });
     } else {
       alert("Your browser doesn't support to File API")
     }
});
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
<style>
p#texto{
	text-align: center;
	color:black;
}
input.archivoInput{
	position:absolute;
	top:0px;
	left:60px;
	right:0px;
	bottom:0px;
	width:55%;
	height:100%;
	opacity: 0	;
}
.form-control{
  margin-bottom: 15px;
}
fieldset{
  /*border: 1px solid #ddd !important;*/
  padding: 10px;
  /*border-radius:4px ;*/
  background-color:#f5f5f5;
  padding-left:10px!important;
  padding-right:10px!important;
  margin-bottom: 10px;
  border-left: 1px solid #ddd !important;
}
legend{
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

<link href="{{asset('css/plugins/dropzone/basic.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/dropzone/dropzone.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script type="text/javascript">
  function validarExt(){
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegurese de haber seleccionado una Imagen');
      archivoInput.value = '';
      return false;
    }else{
      //PRevio del PDF
      if (archivoInput.files && archivoInput.files[0]){
        var visor = new FileReader();
        visor.onload = function(e){
          document.getElementById('visorArchivo').innerHTML =
          '<center><img name="image1" src="'+e.target.result+'"width="150px" height="100px" /></center>';
          };
        visor.readAsDataURL(archivoInput.files[0]);
      }
    }
  }
  function validarExt2(){
    var archivoInput2 = document.getElementById('archivoInput2');
    var archivoRuta = archivoInput2.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegurese de haber seleccionado una Imagen');
      archivoInput2.value = '';
      return false;
    }else{
      //PRevio del PDF
      if (archivoInput2.files && archivoInput2.files[0]){
        var visor = new FileReader();
        visor.onload = function(i){
          document.getElementById('visorArchivo2').innerHTML = '<center><img name="image2" src="'+i.target.result+'"width="150px" height="100px" /></center>';
        };
        visor.readAsDataURL(archivoInput2.files[0]);
      }
    }
  }
  function validarExt3(){
    var archivoInput3 = document.getElementById('archivoInput3');
    var archivoRuta = archivoInput3.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegurese de haber seleccionado una Imagen');
      archivoInput3.value = '';
      return false;
    }else{
      //PRevio del PDF
      if (archivoInput3.files && archivoInput3.files[0]){
        var visor = new FileReader();
        visor.onload = function(i){
          document.getElementById('visorArchivo3').innerHTML ='<center><img name="image3" src="'+i.target.result+'"width="150px" height="100px" /></center>';
        };
        visor.readAsDataURL(archivoInput3.files[0]);
      }
    }
  }
  function validarExt4(){
    var archivoInput4 = document.getElementById('archivoInput4');
    var archivoRuta = archivoInput4.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegurese de haber seleccionado una Imagen');
      archivoInput4.value = '';
      return false;
    }else{
      //PRevio del PDF
      if (archivoInput4.files && archivoInput4.files[0]){
        var visor = new FileReader();
        visor.onload = function(i){
          document.getElementById('visorArchivo4').innerHTML = '<center><img name="image4" src="'+i.target.result+'"width="150px" height="100px" /></center>';
        };
        visor.readAsDataURL(archivoInput4.files[0]);
      }
    }
  }
</script>


@stop