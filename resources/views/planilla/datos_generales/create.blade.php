@extends('layout')
@section('title', 'Personal')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')
@section('content')

<style>
  .show{border-radius:5px;border:1px solid #e5e6e700;background: #ffffff61;color: white;font-size: 25px}
  .form-control{ border-radius:5px; text-align: center }
  .fondo_perfil{margin: 10px 40px;padding:20px 0 0 40px; background-image: url('https://cdn.pixabay.com/photo/2016/10/30/20/22/astronaut-1784245_960_720.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;}
  .fh-column{width: 50%;border-right: 2px #c7c7c7b3 solid; padding: 10px;text-align: center;}
  .full-height{background: white;padding: 10px;text-align: center;}
  .rounded-circle{width: 150px}
  img{border-radius: 40px}
  p#texto{text-align: center; color:black;}
  #boton_datos_generales img{width: 40px; height: 40px; border-radius: 0px !important;  }
  #boton_datos_generales{margin-top: 30px}
  #boton_datos_laborables{margin-top: 30px}
  #boton_datos_laborables img{width: 40px; height: 40px; border-radius: 0px !important;}
  .client-avatar img {width:70px; height: 100px;}
</style>


<div>
  <div class="jumbotron fondo_perfil">
   {{-- Cabecera formulario --}}
   <div class="row justify-content-md-center" id="superior_form_dg">
    <div class="col-lg-3">
      <div id="visorArchivo">
        <img name="foto" class="rounded-circle circle-border m-b-md" src="{{asset('/profile/images/perfil.svg')}}" style="width: 150px;height: 150px;" >

      </div>
    </div>
    <div class="col-lg-7" style="padding-top:10px">
      <div class="row justify-content-md-center" align="center" >
        <div class="col-lg-6" style="padding-top:10px"> <input class="form-control show" type="text" id="nombre1" placeholder="Nombres" onkeyup="PasarValor();"></div>
        <div class="col-lg-6" style="padding-top:10px"> <input class="form-control show" type="text" id="apellido1" placeholder="Apellidos" onkeyup="PasarValor();"></div>
        <div class="col col-lg-6" style="padding-top:10px"><input type="text" list="paises" id="nacionalidad1" class="form-control show" value="Perú" id="nacionalidad1" onkeyup="PasarValor();">
          <datalist id="paises">
           @foreach($paises as $pais)
           <option >{{ $pais->nombre }}</option>
           @endforeach
         </datalist>
       </div>
     </div>
   </div>
 </div>
 {{--Fin Cabecera formulario --}}
</div>

<div class="fh-column" >
  {{-- Titulo D. Generales --}}
  <div align="left">
    <div class="row">
      <div class="col-lg-2"><div class="client-avatar"><img src="{{ asset('/archivos/imagenes/personal/2620463.svg')}}"></div></div>
      <div class="col-lg-10" style="margin-top: 10px"><h2>Datos Generales</h2></div>
    </div>
    <hr style="margin-top: -10px;">
  </div>
  {{--Fin Titulo D. Generales --}}
  {{--  Datos Generales Formulario --}}
  <form action="{{ route('personal.store') }}"  enctype="multipart/form-data" method="post">
    @csrf
    <div class="row"  id="form_datos_generales">
      <input type="text" name="nombres" class="form-control" id="nombre2"  hidden="">{{-- recibido de scrips arriba --}}
      <input type="text" name="apellidos" class="form-control"  id="apellido2"  hidden="">{{-- recibido de scrips arriba --}}
      <input type="text" name="nacionalidad" class="form-control"  id="nacionalidad2"  hidden="">{{-- recibido de scrips arriba --}}
      <div class="col-lg-4">
        <h4>Documento </h4>
        <select class="form-control m-b" name="documento_identificacion">
          <option value="DNI">DNI</option>
          <option value="Pasaporte">Pasaporte</option>
        </select>
        <hr>
      </div>
      <div class="col-lg-4"><h4>Numero Documento</h4><input type="text" name="numero_documento" class="form-control" ><hr></div>
      <div class="col-lg-4"> <h4>Fecha Nacimiento</h4><input type="date" value="{{ date('Y-m-d') }}" name="fecha_nacimiento" class="form-control" ><hr></div>
      <div class="col-lg-4">
        <h4>Genero</h4>
        <select class="form-control m-b" name="genero">
          <option value="masculino">masculino</option>
          <option value="femenino">femenino</option>
        </select>
        <hr>
      </div>

      <div class="col-lg-4"><h4>Celular</h4> <input type="text" name="celular" class="form-control" ><hr></div>
      <div class="col-lg-4"><h4>Telefono</h4> <input type="text" name="telefono" value="0000000" class="form-control" ><hr></div>
      <div class="col-lg-4"><h4>Correo</h4> <input type="text" name="email" value="sincorreo@gmmail.com" class="form-control" ><hr></div>
      <div class="col-lg-4"><h4>Direccion</h4> <input type="text" name="direccion" class="form-control" ><hr></div>

      <div class="col-lg-4">
        <h4>Nivel Educativo</h4>
        <select class="form-control" name="nivel_educativo">
          <option value="Primaria">Primaria</option>
          <option value="Secundaria">Secundaria</option>
          <option value="Tecnico">Tecnico</option>
          <option value="universitaria">universitaria</option>
        </select>
        <hr>
      </div>
      <div class="col-lg-4"><h4>Carrera Profesional</h4>
        <select class="form-control" name="profesion">
          <option value="sin carrera">sin carrera</option>
          <option value="Contabilidad">Contabilidad</option>
          <option value="Administracion">Administracion</option>
          <option value="Ingenieria">Ingenieria</option>
          <option value="Ciencias de la comunicación">Ciencias de la comunicación</option>
          <option value="Marketing y Mercadotecnia">Marketing y Mercadotecnia</option>
          <option value="Economia">Economia</option>
          <option value="Derecho">Derecho</option>
          <option value="Medicina">Medicina</option>
        </select>
        <hr></div>
        <div class="col-lg-4"><h4>Estado Civil</h4>
          <select class="form-control m-b" name="estado_civil">
           <option value="Soltero">Soltero</option>
           <option value="Casado">Casado</option>
           <option value="Viudo con hijos">Viudo con hijos</option>
           <option value="Viudo sin hijos">Viudo sin hijos</option>
         </select><hr></div>
         <div class="col-lg-4"><h4>Foto Perfil</h4><input style="display: none;"  type="file" id="archivoInput"  name="foto" onchange="return validarExt()"  /><label for="archivoInput" class="btn btn-info " style="display: inline-block;  cursor: pointer; ">Seleccionar Foto</label><hr></div>
       </div>
       {{-- Fin  Datos Generales Formulario --}}
     </div>

     <div class="full-height">
      {{-- Titulo --}}
      <div align="left">
        <div class="row">
          <div class="col-lg-2">
            <div class="client-avatar"><img src="{{ asset('/archivos/imagenes/personal/laborable.svg')}}"> </div>
          </div>
          <div class="col-lg-10" style="margin-top: 10px"><h2>Datos Laborables</h2> </div>
        </div>
        <hr style="margin-top: -10px;">
      </div>
      {{--Fin Titulo --}}

      {{--Formulario de Datos Laborables --}}
      <input type="hidden" name="id_personal" >
      <div class="row" style="margin-bottom: 50px;"   id="form_datos_laborables">
        <div class="col-lg-4"> <h4>Area </h4>
          <select class="form-control" name="departamento_area" required="">
            <option value="Aministracion">Administracion</option>
            <option value="Almacen">Almacen</option>
            <option value="Compras">Compras</option>
            <option value="Recursos Humanos">Recursos Humanos</option>
            <option value="otros">otros</option>
          </select>
          <hr>
        </div>
        <div class="col-lg-4"><h4>Cargo </h4>
          <select class="form-control" name="cargo" required="">
            <option value="vendedor">vendedor</option>
            <option value="Obrero">Obrero</option>
            <option value="Empleado">Empleado</option>
          </select>
          <hr>
        </div>
        <div class="col-lg-4"> <h4>Tipo Trbajador </h4>
          <select class="form-control" name="tipo_trabajador" required="">
            <option value="Interno">Interno</option>
            <option value="Externo">Externo</option>
            <option value="Temporal">Temporal</option>
          </select>
          <hr>
        </div>
        <div class="col-lg-4"> <h4>Sede</h4> <input type="text" name="sede" value="Sin sede" class="form-control"><hr></div>

        <div class="col-lg-4"><h4>Turno</h4>
          <select class="form-control" name="turno" required="">
            <option value="Mañana">Mañana</option>
            <option value="Tarde">Tarde</option>
            <option value="Noche">Noche</option>
          </select>
          <hr></div>
          <div class="col-lg-4"><h4>Salario</h4> <input type="text" name="salario" value="Sin salario" class="form-control"><hr></div>
          <div class="col-lg-4"><h4>Fecha Viculacion</h4> <input type="date" name="fecha_vinculacion"  class="form-control"><hr></div>
          <div class="col-lg-4"><h4>Fecha Retiro</h4> <input type="date" name="fecha_retiro"  class="form-control"><hr></div>

          <div class="col-lg-4"><h4>Forma Pago</h4>
           <select class="form-control" name="forma_pago" required="">
            <option value="Semanal">Semanal</option>
            <option value="Quincenal">Quincenal</option>
            <option value="Mensual">Mensual</option>
          </select>
          <hr></div>
          <div class="col-lg-4"><h4>Banco Abonado</h4>
            <select class="form-control" name="banco_renumeracion" required="">
              <option value="BCP">BCP</option>
              <option value="BN">BN</option>
              <option value="Interbank">Interbank</option>
              <option value="Continental">Continental</option>
              <option value="Scotiabank">Scotiabank</option>
            </select>
            <hr>
          </div>
          <div class="col-lg-4"><h4>Numero Cuenta</h4> <input type="text" name="numero_cuenta" value="Sin numero_cuenta" class="form-control"><hr></div>
          <div class="col-lg-4"><h4>Seguro de Salud</h4>
            <select class="form-control" name="afiliacion_salud" required="">
              <option value="Sin Seguro">Sin Seguro</option>
              <option value="AFP Integra">AFP Integra</option>
              <option value="AFP Horizonte">AFP Horizonte</option>
              <option value="ONP">ONP</option>
            </select>
            <hr>
          </div>

          <div class="col-lg-4"><h4>Tipo Contrato</h4>
            <select class="form-control" name="tipo_contrato" required="">
              <option value="Idefinido">Indefinido</option>
              <option value="Fijo">Fijo</option>
              <option value="Temporal">Temporal</option>
            </select>
            <hr>
          </div>
          <div class="col-lg-4"><h4>Regimen Pensionario</h4>
            <select class="form-control" name="regimen_pensionario" required="">
              <option value="Sin Regimen">Sin Regimen</option>
              <option value="Privado">Privado</option>
              <option value="Nacional">Nacional</option>
            </select>
            <hr>
          </div>
          <input type="text" name="estado_trabajador" class="form-control" value="Activo"  hidden="">
          <div class="col-lg-4"><h4>Guardar</h4> <input type="submit" name="" class="btn btn-success"  value="Guardar"><hr></div>
        </div>
      </form>
      {{-- Fin Formulario de Datos Laborables --}}
    </div>
  </div>

  <!-- Mainly scripts -->
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
  <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

  <!-- Custom and plugin javascript -->
  <script src="{{ asset('js/inspinia.js') }}"></script>
  <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

  <!-- blueimp gallery -->
  <script src="{{ asset('js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
  <script>
   function validarExt()
   {
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var vista = document.getElementById('visorArchivo');
    var visor = new FileReader();
    visor.onload = function(e)
    {vista.innerHTML ='<img name="foto" class="rounded-circle circle-border m-b-md"  src="'+e.target.result+'" style="width: 150px;height: 150px;" >';
  };
  visor.readAsDataURL(archivoInput.files[0]);
}

function PasarValor()
{
  document.getElementById("nombre2").value = document.getElementById("nombre1").value;
  document.getElementById("apellido2").value = document.getElementById("apellido1").value;
  document.getElementById("nacionalidad2").value = document.getElementById("nacionalidad1").value;
}
</script>
@endsection