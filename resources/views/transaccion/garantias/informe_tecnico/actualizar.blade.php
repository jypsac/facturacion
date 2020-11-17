@extends('layout')

@section('title', ' Actualizar - Informe Tecnico')
@section('breadcrumb', 'Actualizar Informe')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.index'))
@section('value_accion', 'Atras')

@section('content')
<form action="{{route('garantia_informe_tecnico.update', $garantia_informe_tecnico->id)}}"  enctype="multipart/form-data" method="post">
   @csrf
  @method('put')
  <div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">
    <div class="row">
      <fieldset class="col-sm-6" style="align-items: center;">
       <legend>Datos<br>Generales</legend>
        <div class="panel panel-default">
          <div class="panel-body" align="left">
            <div class="row">
                <label class="col-sm-2 col-form-label">Marca:</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" name="marca" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}}" readonly>
                  </div>
                  <label class="col-sm-2 col-form-label">Motivo:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="motivo" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}" readonly>
                    </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">Orden de servicio:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="orden_servicio" value="{{$garantia_informe_tecnico->orden_servicio}}" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Fecha:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="fecha_uno" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha}}" readonly>
                </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="ing_asignado" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}}" readonly>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">Asunto:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="asunto" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}" readonly>
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
                <div class="col-sm-10"><input type="text" class="form-control" name="nombre_cliente" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}" readonly></div>
              <label class="col-sm-2 col-form-label"> Direccion:</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="direccion" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}" readonly></div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">Telefono:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="telefono" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}" readonly>
              </div>
              <label class="col-sm-2 col-form-label">Correo:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="correo" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Contacto:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="contacto" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre}}" readonly>
                </div>
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
                <input type="text" class="form-control" name="nombre_equipo" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}" readonly>
              </div>
              <label class="col-sm-2 col-form-label">Nr Serie:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="numero_serie" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}" readonly>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">Codigo Interno:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="codigo_interno" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}" readonly>
              </div>
              <label class="col-sm-2 col-form-label">Fecha de Compra:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="fecha_compra" value="{{$garantia_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}" readonly>
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
                  <textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="630" required>{{$garantia_informe_tecnico->estetica}}</textarea>
                </div>
              </div>
              <label class="col-sm-1 col-form-label">  Revision y Diagnostico:</label>
              <div class="col-sm-5">
                <div class="input-group m-b">
                  <textarea class="form-control" rows="5" id="comment" name="revision_diagnostico"  maxlength="630" required>{{$garantia_informe_tecnico->revision_diagnostico}}</textarea>
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
                  <textarea class="form-control" rows="5" id="comment" name="causas_del_problema"  maxlength="630" required>{{$garantia_informe_tecnico->causas_del_problema}}</textarea>
                </div>
              </div>
              <label class="col-sm-1 col-form-label">Solucion:</label>
              <div class="col-sm-5">
                <div class="input-group m-b">
                  <textarea class="form-control" rows="5" id="comment" name="solucion"  maxlength="630" required>{{$garantia_informe_tecnico->solucion}}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body" align="left">
            <div class="field" align="left">
              <h3>Imagenes<h5>(Click a la imagen para editar)</h5></h3>
               {{-- <input  type="file" name="files[]" id="files"  multiple="" value=" "  accept="image/jpeg/svg/png/jpg" /> --}}
               <div class="row">
               	@foreach($archivo_informe_tecnico as $archivo)
                 	<div class="col-sm-2">
                 		<div class="input-group m-b">
                      <input type="text" name="original" hidden="hidden" value="{{$archivo->archivos}}"/>
                      <input type="text" name="id" hidden="hidden" value="{{$archivo->id}}">
			                <!--Aqui se desplegará el fichero-->
                       <input type="file" name="nombre{{$archivo->id}}" style="position: absolute ;top:0px;left:0px;right:0px;bottom:0px;opacity:0;width: 200px;padding: 15px ;height: 200px" id="archivoInput{{$archivo->id}}" onchange="return validarExt{{$archivo->id}}()"/>
                       <span id="visorArchivo{{$archivo->id}}">
			                   <img src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width: 200px;height:200px;padding: 15px ;"/>
                      </span>
		               	 <script type="text/javascript">
                      function validarExt{{$archivo->id}}(){
                        var archivoInput{{$archivo->id}} = document.getElementById('archivoInput{{$archivo->id}}');
                        var archivoRuta = archivoInput{{$archivo->id}}.value;
                        var extPermitidas = /(.jpg|.png|.jfif)$/i;
                        if(!extPermitidas.exec(archivoRuta)){
                            alert('Asegurese de haber seleccionado una Imagen');
                            archivoInput{{$archivo->id}}.value = '';
                            return false;
                        }
                        else
                        {
                        //PRevio del PDF
                          if (archivoInput{{$archivo->id}}.files && archivoInput{{$archivo->id}}.files[0])
                          {
                              var visor = new FileReader();
                              visor.onload = function(e)
                                {
                                    document.getElementById('visorArchivo{{$archivo->id}}').innerHTML =
                                    '<img name="file" src="'+e.target.result+'"  style="width: 200px;padding: 15px ;height: 200px"  />';
                                };
                              visor.readAsDataURL(archivoInput{{$archivo->id}}.files[0]);
                          }
                        }
                      }
                    </script>
  	                </div>
                  </div>
               @endforeach
               </div>
               <br/>
               <h3>Agregar Nuevas Imagenes</h3>
               <input  type="file" name="files[]" id="files"  multiple=""  accept="image/jpeg/svg/png/jpg" />
            </div>
          </div>
        </div>
      </fieldset>
      <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit">
        <strong>Grabar</strong>
      </button>
    </div>
  </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
<style>
p#texto{
	text-align: center;
	color:black;
}
/*input.archivoInput{
	position:absolute;
	top:0px;
	left:60px;
	right:0px;
	bottom:0px;

	opacity: 0	;
}*/
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


@stop