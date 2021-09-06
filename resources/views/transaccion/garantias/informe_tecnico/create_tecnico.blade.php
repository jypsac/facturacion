	@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_informe_tecnico.index'))
@section('value_accion', 'Atras')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
  <form action="{{route('garantia_informe_tecnico.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
  @csrf
  <br>
  <div class="ibox-content p-xl" style=" margin-bottom: 2px;padding-bottom: 50px;">
    <div class="row" >
      <div class="col-sm-4 text-left" align="left">
        <div class="form-control" align="center" style="height: 79%;" align="left">
          <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
        </div>
      </div>
      <div class="col-sm-4" align="center">
        <div class="form-control" align="center" style="height: 79%;" align="center">
          <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantia_guia_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
        </div>
      </div>
      <div class="col-sm-4" align="right" >
        <div class="form-control" align="center" style="height: 79%;" align="right">
          <h3 style="">R.U.C {{$empresa->ruc}}</h3>
          <h2 style="font-size: 19px">GUIA DE INFORME TECNICO</h2>
          <h5>{{$garantia_guia_egreso->garantia_ingreso_i->orden_servicio}}</h5>
        </div>
      </div>
      <br>
      <div class="col-sm-6" align="center" >
          <div class="form-control">
              <h3>Datos Generales </h3>
              <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
                <label class="col-sm-2 col-form-label">Asunto:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" value="{{$garantia_guia_egreso->garantia_ingreso_i->asunto}}" disabled="disabled">
                </div>
                  <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="{{$garantia_guia_egreso->garantia_ingreso_i->personal_laborales->nombres}}" disabled="disabled">
                </div>
                <label class="col-sm-2 col-form-label">Motivo:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control"  value="{{$garantia_guia_egreso->garantia_ingreso_i->motivo}}" disabled="disabled">
                </div>
                <label class="col-sm-2 col-form-label">Fecha:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control"  value="{{$tiempo_actual}}" disabled="disabled">
                </div>
              </div>
          </div>
      </div>
      <div class="col-sm-6" align="center">
        <div class="form-control">
          <h3>Datos del Cliente</h3>
          <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
            <label class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->nombre}}"  disabled="disabled">
                    </div>
                    <label class="col-sm-2 col-form-label">Telefono:</label>
                  <div class="col-sm-4">
                <input type="text" class="form-control" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->telefono}}"  disabled="disabled">
                    </div>
                    <label class="col-sm-2 col-form-label">Correo:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$garantia_guia_egreso->garantia_ingreso_i->clientes_i->email}}" disabled="disabled">
                </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12" align="center">
        <br>
        <div class="form-control">
          <h3>Datos del Equipo</h3>
          {{-- <br> --}}
          <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
            <label class="col-sm-2 col-form-label">Modelo:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control"value="{{$garantia_guia_egreso->garantia_ingreso_i->nombre_equipo}}" disabled="disabled">
                    </div>
                    <label class="col-sm-2 col-form-label"> Nr Serie:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control"  value="{{$garantia_guia_egreso->garantia_ingreso_i->numero_serie}}" disabled="disabled">
                    </div>
                    <label class="col-sm-2 col-form-label">Codigo Interno:</label>
                  <div class="col-sm-4">
                <input type="text" class="form-control"  value="{{$garantia_guia_egreso->garantia_ingreso_i->codigo_interno}}" disabled="disabled">
                    </div>
                    <label class="col-sm-2 col-form-label">Fecha Compra:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" value="{{$garantia_guia_egreso->garantia_ingreso_i->fecha_compra}}" disabled="disabled">
                </div>
          </div>
          {{-- <br> --}}
        </div>
      </div>
      <div class="col-sm-12" align="center">
        <div class="form-control">
          <h3>Informe del Problema</h3>
          <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
            <div class="col-sm-6">
              <center><h4>Estética</h4></center>
              <div class="input-group m-b">
                <textarea class="form-control" rows="5" id="comment" name="estetica" maxlength="1230" required style="resize: none;height: 200px;"></textarea>
              </div>
            </div>
            <div class="col-sm-6">
              <center><h4>Revision y Diagnostico</h4></center>
              <div class="input-group m-b">
                <textarea class="form-control" rows="5" id="comment" name="revision_diagnostico"  maxlength="1230" required style="resize: none;height: 200px;"></textarea>
              </div>
            </div>
            <div class="col-sm-6">
              <center><h4>Causas del problema</h4></center>
              <div class="input-group m-b">
                <textarea class="form-control" rows="5" id="comment" name="causas_del_problema"  maxlength="1230" required style="resize: none;height: 200px;"></textarea>
              </div>
            </div>
            <div class="col-sm-6">
              <center><h4>Solucion</h4></center>
              <div class="input-group m-b">
                <textarea class="form-control" rows="5" id="comment" name="solucion"  maxlength="1230" required style="resize: none;height: 200px;"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-control">
          <h4>Imagenes</h4>
          {{-- <div class="panel panel-default"> --}}
            <div class="panel-body" align="left">
              <div class="field" align="left">
                 <input  type="file" name="files[]" id="files"  multiple=""  accept="image/jpeg/svg/png/jpg" />
              </div>
            </div>
          {{-- </div> --}}
        </div>
      </div>
    </div>
    <br>
    <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" id="boton"><strong>Grabar</strong></button>
  </div>
  </form>
</div>
{{-- </div> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


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