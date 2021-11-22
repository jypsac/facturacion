@extends('layout')
@section('title', 'Personal')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Inicio')
@section('button2', 'Nuevo Personal')
@section('config',route('personal.create'))
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
    {{-- Cabecera Vista --}}
    <div class="row justify-content-md-center"  id="superior_vista_dg">
      <div class="col-lg-3"><img src="{{ asset('/profile/images/')}}/{{$personales->foto}}" class="rounded-circle circle-border m-b-md" style="width: 150px;height: 150px;"></div>
      <div class="col-lg-7" style="padding-top:10px">
        <div class="row justify-content-md-center" align="center" id="">
         <div class="col-lg-6" style="padding-top:10px"><div class="form-control show"> {{$personales->nombres}}</div></div>
         <div class="col-lg-6" style="padding-top:10px"><div class="form-control show"> {{$personales->apellidos}}</div></div>
         <div class="col col-lg-6" style="padding-top:10px"> <div class="form-control show">  {{$personales->nacionalidad}}</div></div>
       </div>
     </div>
   </div>
   {{--Fin Cabecera Vista --}}
   {{-- Cabecera formulario --}}
   <div class="row justify-content-md-center" id="superior_form_dg" hidden="">
    <div class="col-lg-3">
      <div id="visorArchivo">
        <img name="foto" class="rounded-circle circle-border m-b-md" src="{{asset('/profile/images')}}/{{$personales->foto}}" style="width: 150px;height: 150px;" >
      </div>
    </div>
    <div class="col-lg-7" style="padding-top:10px">
      <div class="row justify-content-md-center" align="center" >
        <div class="col-lg-6" style="padding-top:10px"> <input class="form-control show" type="text" id="nombre1" value="{{$personales->nombres}}"  onkeyup="PasarValor();"></div>
        <div class="col-lg-6" style="padding-top:10px"> <input class="form-control show" type="text" id="apellido1" value="{{$personales->apellidos}}"  onkeyup="PasarValor();"></div>
        <div class="col col-lg-6" style="padding-top:10px"><input type="text" list="paises" id="nacionalidad1" class="form-control show" value="{{$personales->nacionalidad}}"  id="nacionalidad1" onkeyup="PasarValor();">
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
      <div class="col-lg-2">
        <div class="client-avatar"><img src="{{ asset('/archivos/imagenes/personal/2620463.svg')}}"></div>
      </div>
      <div class="col-lg-4" style="margin-top: 10px"><h2>Datos Generales</h2></div>
      <div class="col-lg-6" align="right">
        <div class="client-avatar" onclick="editar_datos_generales()" id="boton_datos_generales" style="cursor: pointer;"><img  src="{{ asset('/archivos/imagenes/personal/editar.svg')}}"></div>
      </div>
    </div>
    <hr style="margin-top: -10px;">
  </div>
  {{--Fin Titulo D. Generales --}}
  {{-- Datos Generales vista --}}
  <div class="row" id="datos_generales_vista"  style="margin-bottom: 50px;">
    <div class="col-lg-4"> <h4>Documento </h4>{{$personales->documento_identificacion}}<hr></div>
    <div class="col-lg-4"><h4>Numero Documento</h4>{{$personales->numero_documento}}<hr></div>
    <div class="col-lg-4"> <h4>Fecha Nacimiento</h4>{{$personales->fecha_nacimiento}}<hr></div>
    <div class="col-lg-4"> <h4>Genero</h4>{{$personales->genero}}<hr></div>

    <div class="col-lg-4"><h4>Celular</h4>{{$personales->celular}}<hr></div>
    <div class="col-lg-4"><h4>Telefono</h4>{{$personales->telefono}}<hr></div>
    <div class="col-lg-4"><h4>Correo</h4>{{$personales->email}}<hr></div>
    <div class="col-lg-4"><h4>Direccion</h4>{{$personales->direccion}}<hr></div>

    <div class="col-lg-4"><h4>Nivel Educativo</h4>{{$personales->nivel_educativo}}<hr></div>
    <div class="col-lg-4"><h4>Carrera Profesional</h4>{{$personales->profesion}}<hr></div>
    <div class="col-lg-4"><h4>Estado Civil</h4>{{$personales->estado_civil}}<hr></div>
  </div>
  {{-- Fin Datos Generales vista --}}

  {{--  Datos Generales Formulario --}}
  <form action="{{ route('personal.update',$personales->id) }}"  enctype="multipart/form-data" method="post">
    @csrf
    @method('PATCH')
    <div class="row"  id="form_datos_generales" hidden="">
      <input type="text" name="nombres" class="form-control" id="nombre2" value="{{$personales->nombres}}" hidden="">{{-- recibido de scrips arriba --}}
      <input type="text" name="apellidos" class="form-control"  id="apellido2" value="{{$personales->apellidos}}" hidden="">{{-- recibido de scrips arriba --}}
      <input type="text" name="nacionalidad" class="form-control"  id="nacionalidad2" value="{{$personales->nacionalidad}}" hidden="">{{-- recibido de scrips arriba --}}
      <div class="col-lg-4">
        <h4>Documento </h4>
        <select class="form-control m-b" name="documento_identificacion">
          <option value="{{$personales->documento_identificacion}}">{{$personales->documento_identificacion}}</option>
          @if($personales->documento_identificacion == 'DNI')
          <option value="Pasaporte">Pasaporte</option>
          @elseif($personales->documento_identificacion == 'Pasaporte')
          <option value="DNI">DNI</option>
          @endif
        </select>
        <hr>
      </div>
      <div class="col-lg-4"><h4>Numero Documento</h4><input type="text" name="numero_documento" class="form-control"  value=" {{$personales->numero_documento}}"><hr></div>
      <div class="col-lg-4"> <h4>Fecha Nacimiento</h4><input type="date" name="fecha_nacimiento" class="form-control"  value="{{$personales->fecha_nacimiento}}"><hr></div>
      <div class="col-lg-4">
        <h4>Genero</h4>
        <select class="form-control m-b" name="genero">
          <option value="femenino">{{$personales->genero}}</option>
          @if($personales->genero == 'femenino')
          <option value="masculino">masculino</option>
          @elseif($personales->genero == 'masculino')
          <option value="femenino">femenino</option>
          @endif
        </select>
        <hr>
      </div>

      <div class="col-lg-4"><h4>Celular</h4> <input type="text" name="celular" class="form-control"  value=" {{$personales->celular}}"><hr></div>
      <div class="col-lg-4"><h4>Telefono</h4> <input type="text" name="telefono" class="form-control"  value=" {{$personales->telefono}}"><hr></div>
      <div class="col-lg-4"><h4>Correo</h4> <input type="text" name="email" class="form-control"  value=" {{$personales->email}}"><hr></div>
      <div class="col-lg-4"><h4>Direccion</h4> <input type="text" name="direccion" class="form-control"  value=" {{$personales->direccion}}"><hr></div>

      <div class="col-lg-4">
        <h4>Nivel Educativo</h4>
        <select class="form-control" name="nivel_educativo">
          <option value="{{$personales->nivel_educativo}}">{{$personales->nivel_educativo}}</option>
          <option value="Primaria">Primaria</option>
          <option value="Secundaria">Secundaria</option>
          <option value="Tecnico">Tecnico</option>
          <option value="universitaria">universitaria</option>
        </select>
        <hr>
      </div>
      <div class="col-lg-4"><h4>Carrera Profesional</h4>

        <select class="form-control" name="profesion">
          <option >{{$personales->profesion}}</option>
          <option disabled="">------------------</option>
          <option value="sin carrera">Sin carrera</option>
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
          <option >{{$personales->estado_civil}}</option>
          <option disabled="">------------------</option>
           <option value="Soltero">Soltero</option>
           <option value="Casado">Casado</option>
           <option value="Viudo con hijos">Viudo con hijos</option>
           <option value="Viudo sin hijos">Viudo sin hijos</option>
         </select>

        <hr></div>
      <div class="col-lg-4"><h4>Foto Perfil</h4><input style="display: none;"  type="file" id="archivoInput"  name="foto" onchange="return validarExt()"  /><label for="archivoInput" class="btn btn-info " style="display: inline-block;  cursor: pointer; ">Seleccionar Foto</label><hr></div>

      <div class="col-lg-4"><h4>Guardar</h4> <input type="submit" name="" class="btn btn-success"  value="Guardar"><hr></div>

    </div>
  </form>
  {{-- Fin  Datos Generales Formulario --}}
</div>

<div class="full-height">
  {{-- Titulo --}}
  <div align="left">
    <div class="row">
      <div class="col-lg-2">
        <div class="client-avatar"><img src="{{ asset('/archivos/imagenes/personal/laborable.svg')}}"> </div>
      </div>
      <div class="col-lg-4" style="margin-top: 10px"><h2>Datos Laborables</h2> </div>
      <div class="col-lg-6" align="right">
        <div class="client-avatar" onclick="editar_datos_laborables()" id="boton_datos_laborables" style="cursor: pointer"><img src="{{ asset('/archivos/imagenes/personal/editar.svg')}}">
        </div>
      </div>
    </div>
    <hr style="margin-top: -10px;">
  </div>
  {{--Fin Titulo --}}

  @if(isset($persona->id))
  {{-- Vista de Datos Laborables --}}
  <div class="row" style="margin-bottom: 50px;" id="vista_datos_laborables">
    <div class="col-lg-4"> <h4>Area </h4>{{$persona->departamento_area}}<hr></div>
    <div class="col-lg-4"><h4>Cargo </h4>{{$persona->cargo}}<hr></div>
    <div class="col-lg-4"> <h4>Tipo Trbajador </h4>{{$persona->tipo_trabajador}}<hr></div>
    <div class="col-lg-4"> <h4>Sede</h4>{{$persona->sede}}<hr></div>

    <div class="col-lg-4"><h4>Turno</h4>{{$persona->turno}}<hr></div>
    <div class="col-lg-4"><h4>Salario</h4>{{$persona->salario}}<hr></div>
    <div class="col-lg-4"><h4>Fecha Viculacion</h4>{{$persona->fecha_vinculacion}}<hr></div>
    <div class="col-lg-4"><h4>Fecha Retiro</h4>{{$persona->fecha_retiro}}<hr></div>

    <div class="col-lg-4"><h4>Forma Pago</h4>{{$persona->forma_pago}}<hr></div>
    <div class="col-lg-4"><h4>Banco Abonado</h4>{{$persona->banco_renumeracion}}<hr></div>
    <div class="col-lg-4"><h4>Numero Cuenta</h4>{{$persona->numero_cuenta}}<hr></div>
    <div class="col-lg-4"><h4>Seguro de Salud</h4>{{$persona->afiliacion_salud}}<hr></div>

    <div class="col-lg-4"><h4>Tipo Contrato</h4>{{$persona->tipo_contrato}}<hr></div>
    <div class="col-lg-4"><h4>Regimen Pensionario</h4>{{$persona->regimen_pensionario}}<hr></div>
    <div class="col-lg-4"><h4>Estado Del Trabajador</h4>{{$persona->estado_trabajador}}<hr></div>
  </div>
  {{--Fin Vista de Datos Laborables --}}

  {{--Formulario de Datos Laborables --}}
  <form action="{{ route('personal-datos-laborales.update',$persona->id) }}"  enctype="multipart/form-data" method="post">
    @csrf
    @method('PATCH')
    <input type="hidden" name="id_personal" value="{{$persona->personal_id}}">
    <div class="row" style="margin-bottom: 50px;"  hidden=""  id="form_datos_laborables">
      <div class="col-lg-4"> <h4>Area </h4>
       <select class="form-control" name="departamento_area" required="">
        <option value="{{$persona->departamento_area}}">{{$persona->departamento_area}}</option>
        <option disabled="">------------------------</option>
        <option value="Aministracion">Administracion</option>
        <option value="Almacen">Almacen</option>
        <option value="Compras">Compras</option>
        <option value="Recursos Humanos">Recursos Humanos</option>
        <option value="otros">otros</option>
      </select>
      <hr></div>
      <div class="col-lg-4"><h4>Cargo </h4>
       <select class="form-control" name="cargo" required="">
        <option value="{{$persona->cargo}}">{{$persona->cargo}}</option>
        <option disabled="">------------------------</option>
        <option value="vendedor">vendedor</option>
        <option value="Obrero">Obrero</option>
        <option value="Empleado">Empleado</option>
      </select>
      <hr></div>
      <div class="col-lg-4"> <h4>Tipo Trbajador </h4>
       <select class="form-control" name="tipo_trabajador" required="">
        <option value="{{$persona->tipo_trabajador}}">{{$persona->tipo_trabajador}}</option>
        <option disabled="">------------------------</option>
        <option value="Interno">Interno</option>
        <option value="Externo">Externo</option>
        <option value="Temporal">Temporal</option>
      </select>
      <hr></div>
      <div class="col-lg-4"> <h4>Sede</h4> <input type="text" name="sede" class="form-control"  value="{{$persona->sede}}"><hr></div>

      <div class="col-lg-4"><h4>Turno</h4>
       <select class="form-control" name="turno" required="">
        <option value="{{$persona->turno}}">{{$persona->turno}}</option>
        <option disabled="">------------------------</option>
        <option value="Mañana">Mañana</option>
        <option value="Tarde">Tarde</option>
        <option value="Noche">Noche</option>
      </select>
      <hr></div>
      <div class="col-lg-4"><h4>Salario</h4> <input type="nmber" name="salario" class="form-control"  value="{{$persona->salario}}"><hr></div>
      <div class="col-lg-4"><h4>Fecha Viculacion</h4> <input type="date" name="fecha_vinculacion" class="form-control"  value="{{$persona->fecha_vinculacion}}"><hr></div>
      <div class="col-lg-4"><h4>Fecha Retiro</h4> <input type="date" name="fecha_retiro" class="form-control"  value="{{$persona->fecha_retiro}}"><hr></div>

      <div class="col-lg-4"><h4>Forma Pago</h4>
        <select class="form-control" name="forma_pago" required="">
          <option value="{{$persona->forma_pago}}">{{$persona->forma_pago}}</option>
          <option disabled="">------------------------</option>
          <option value="Semanal">Semanal</option>
          <option value="Quincenal">Quincenal</option>
          <option value="Mensual">Mensual</option>
        </select>
        <hr></div>
        <div class="col-lg-4"><h4>Banco Abonado</h4>
         <select class="form-control" name="banco_renumeracion" required="">
          <option value="{{$persona->banco_renumeracion}}">{{$persona->banco_renumeracion}}</option>
          <option disabled="">------------------------</option>
          <option value="BCP">BCP</option>
          <option value="BN">BN</option>
          <option value="Interbank">Interbank</option>
          <option value="Continental">Continental</option>
          <option value="Scotiabank">Scotiabank</option>
        </select>
        <hr></div>
        <div class="col-lg-4"><h4>Numero Cuenta</h4> <input type="text" name="numero_cuenta" class="form-control"  value="{{$persona->numero_cuenta}}"><hr></div>
        <div class="col-lg-4"><h4>Seguro de Salud</h4>
         <select class="form-control" name="afiliacion_salud" required="">
          <option value=" {{$persona->afiliacion_salud}}"> {{$persona->afiliacion_salud}}</option>
          <option disabled="">------------------------</option>
          <option value="Sin Seguro">Sin Seguro</option>
          <option value="AFP Integra">AFP Integra</option>
          <option value="AFP Horizonte">AFP Horizonte</option>
          <option value="ONP">ONP</option>
        </select>
        <hr></div>

        <div class="col-lg-4"><h4>Tipo Contrato</h4>
          <select class="form-control" name="tipo_contrato" required="">
            <option value="{{$persona->tipo_contrato}}">{{$persona->tipo_contrato}}</option>
            <option disabled="">------------------------</option>
            <option value="Idefinido">Indefinido</option>
            <option value="Fijo">Fijo</option>
            <option value="Temporal">Temporal</option>
          </select>
          <hr></div>
          <div class="col-lg-4"><h4>Regimen Pensionario</h4>
            <select class="form-control" name="regimen_pensionario" required="">
              <option value="{{$persona->regimen_pensionario}}">{{$persona->regimen_pensionario}}</option>
              <option disabled="">------------------------</option>
              <option value="Sin Regimen">Sin Regimen</option>
              <option value="Privado">Privado</option>
              <option value="Nacional">Nacional</option>
            </select>
            <hr></div>
            <div class="col-lg-4"><h4>Estado Del Trbajador</h4>
              <select class="form-control" name="estado_trabajador" required="">
              <option value="{{$persona->estado_trabajador}}">{{$persona->estado_trabajador}}</option>
              <option disabled="">------------------------</option>
              <option value="Activo">Activo</option>
              <option value="Desactivo">Desactivo</option>
            </select>
            <hr></div>
            <div class="col-lg-4"><h4>Guardar</h4> <input type="submit" name="" class="btn btn-success"  value="Guardar"><hr></div>
          </div>
        </form>
        {{-- Fin Formulario de Datos Laborables --}}
        @endif
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
  function editar_datos_generales() {
    var datos_generales_vista = document.getElementById("datos_generales_vista");
    var form_datos_generales = document.getElementById("form_datos_generales");
    var boton_datos_generales= document.getElementById("boton_datos_generales");

    var superior_vista_dg= document.getElementById("superior_vista_dg");
    var superior_form_dg= document.getElementById("superior_form_dg");

    var vista_datos_laborables= document.getElementById("vista_datos_laborables");
    var form_datos_laborables= document.getElementById("form_datos_laborables");

    if( datos_generales_vista.hasAttribute("hidden") )
    {
      datos_generales_vista.removeAttribute("hidden", "");
      superior_vista_dg.removeAttribute("hidden", "");

      boton_datos_generales.innerHTML='<img src="{{ asset('/archivos/imagenes/personal/editar.svg')}}"> ';

      form_datos_generales.setAttribute("hidden", "");
      superior_form_dg.setAttribute("hidden", "");
    }
    else{
      datos_generales_vista.setAttribute("hidden", "");
      superior_vista_dg.setAttribute("hidden", "");
      vista_datos_laborables.removeAttribute("hidden", "");/*Remueve los formularios abiertos*/

      boton_datos_generales.innerHTML='<img src="{{ asset('/archivos/imagenes/personal/cancelar.svg')}}"> ';
      boton_datos_laborables.innerHTML='<img src="{{ asset('/archivos/imagenes/personal/editar.svg')}}"> ';

      form_datos_generales.removeAttribute("hidden", "");
      superior_form_dg.removeAttribute("hidden", "");
      form_datos_laborables.setAttribute("hidden", "");
    }
  }
  function editar_datos_laborables() {
    if( vista_datos_laborables.hasAttribute("hidden") )
    {
      vista_datos_laborables.removeAttribute("hidden", "");

      boton_datos_laborables.innerHTML='<img src="{{ asset('/archivos/imagenes/personal/editar.svg')}}"> ';

      form_datos_laborables.setAttribute("hidden", "");
    }
    else{
      vista_datos_laborables.setAttribute("hidden", "");
      datos_generales_vista.removeAttribute("hidden", "");/*Remueve los formularios abiertos*/
      superior_vista_dg.removeAttribute("hidden", "");

      boton_datos_laborables.innerHTML='<img src="{{ asset('/archivos/imagenes/personal/cancelar.svg')}}"> ';
      boton_datos_generales.innerHTML='<img src="{{ asset('/archivos/imagenes/personal/editar.svg')}}"> ';

      form_datos_laborables.removeAttribute("hidden", "");
      form_datos_generales.setAttribute("hidden", "");
      superior_form_dg.setAttribute("hidden", "");
    }
  }
</script>
@endsection