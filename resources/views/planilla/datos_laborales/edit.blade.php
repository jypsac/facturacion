@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Editar')
@section('breadcrumb2', 'Personal-Editar')
@section('href_accion', route('personal-datos-laborales.show', $personales->id) )
@section('value_accion', 'Atras')

@section('content')
 <link href="{{ asset('css/plugins/blueimp/css/blueimp-gallery.min.css') }}" rel="stylesheet">

<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
      <div class="jumbotron"
      style="padding: 10px 40px ;
      background-image: url('https://www.iwantwallpaper.co.uk/images/muriva-bluff-embossed-brick-effect-wallpaper-j30309-p711-1303_image.jpg'); background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;"
       >
    <table>
            <tr>
                <th width="100% "><h1 style="color: black">{{$personales->personal_l->nombres}} {{$personales->personal_l->apellidos}} <br> <span style="font-size: 20px">&nbsp;&nbsp;{{$personales->personal_l->nacionalidad}}</span></h1>
                </th>
                <th  width="100%" rowspan="2">

                            <a href="{{ asset('/profile/images/')}}/{{$persona->foto}}" title="{{$personales->personal_l->nombres}}  {{$personales->personal_l->apellidos}}" data-gallery=""><img src="{{ asset('/profile/images/')}}/{{$personales->personal_l->foto}}" class="rounded-circle circle-border m-b-md" alt="profile"  width="150px" height="150px" ></a>

                           <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                {{-- <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol> --}}
                            </div>

                 </th>

             </tr>

     </table>
      </div>
      <form action="{{ route('personal-datos-laborales.update',$personales->id) }}"  enctype="multipart/form-data" method="post">
		@csrf
		@method('PATCH')

          <input type="text" class="form-control" name="id_personal" value="{{$personales->personal_id}}" hidden="hidden">
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Fecha Viculacion</h4>
          <p><input type="date" class="form-control" name="fecha_vinculacion" value="{{$personales->fecha_vinculacion}}"></p>

          <h4>Fecha Retiro</h4>
          <p><input type="date" class="form-control" name="fecha_retiro" value="{{$personales->fecha_retiro}}"></p>


          <h4>Forma Pago</h4>

          <p>
           <select class="form-control" name="forma_pago">
              <option value="{{$personales->forma_pago}}">{{$personales->forma_pago}}</option>
              <option value="Semanal">Semanal</option>
              <option value="Quincenal">Quincenal</option>
              <option value="Mensual">Mensual</option>
              <option value="Otros">Otros</option>
            </select></p>
        </div>

        <div class="col-lg-6">
          <h4>Salario</h4>
          <p><input type="text" class="form-control" name="salario" value="{{$personales->salario}}"> </p>

            <h4>Categoria Ocupacional</h4>
          <p>
           <select class="form-control" name="categoria_ocupacional">
              <option value="{{$personales->categoria_ocupacional}}">{{$personales->categoria_ocupacional}}</option>
              <option value="Obrero">Obrero</option>
              <option value="Empleado">Empleado</option>
              <option value="Administrativo">Administrativo</option>
              <option value="Ejecutivo">Ejecutivo</option>
            </select></p>

            <h4>Estado Del Trbajador</h4>
          <p><select class="form-control" name="estado_trabajador">
              <option value="{{$personales->estado_trabajador}}">{{$personales->estado_trabajador}}</option>
              <option value="Activo">Activo</option>
              <option value="Retirado">Retirado</option>
              <option value="Vacaciones">Vacaciones</option>
              <option value="Descanso medico">Descanso medico</option>
            </select></p>


        </div>
        <div class="col-lg-6">


          <h4>Sede</h4>
          <p><input type="text" class="form-control" name="sede" value="{{$personales->sede}}"></p>

          <h4>Turno</h4>
          <p>
           <select class="form-control" name="turno">
              <option value="{{$personales->turno}}">{{$personales->turno}}</option>
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
              <option value="Noche">Noche</option>
            </select></p>


        </div>
        <div class="col-lg-6">
         <h4>Departamento Area</h4>
          <p>
            <select class="form-control" name="departamento_area">
              <option value="{{$personales->departamento_area}}">{{$personales->departamento_area}}</option>
              <option value="Aministracion">Administracion</option>
              <option value="Almacen">Almacen</option>
              <option value="Compras">Compras</option>
              <option value="Comercial">Comercial</option>
              <option value="Contabilidad">Contabilidad</option>
              <option value="Logistica">Logistica</option>
              <option value="Marketing">Marketing</option>
              <option value="Produccion">Produccion</option>
              <option value="Recursos Humanos">Recursos Humanos</option>
              <option value="otros">otros</option>
            </select></p>


          <h4>Cargo</h4>
          <p>
            <select class="form-control" name="cargo">
              <option value="{{$personales->cargo}}">{{$personales->cargo}}</option>
              <option value="vendedor">vendedor</option>
              <option value="Obrero">Obrero</option>
              <option value="Empleado">Empleado</option>
              <option value="Contador">Contador</option>
              <option value="Jefe de Ventas">Jefe de Ventas</option>
              <option value="Administrador">Administrador</option>
              <option value="Gerente">Gerente</option>
            </select></p>


        </div>

        <div class="col-lg-6">


          <h4>Tipo Trabajador</h4>
          <p>
           <select class="form-control" name="tipo_trabajador">
              <option value="{{$personales->tipo_trabajador}}">{{$personales->tipo_trabajador}}</option>
              <option value="Interno">Interno</option>
              <option value="Externo">Externo</option>
              <option value="Temporal">Temporal</option>
            </select></p>






          <h4>Regimen Pensionario</h4>
          <p>
           <select class="form-control" name="regimen_pensionario">
              <option value="{{$personales->regimen_pensionario}}">{{$personales->regimen_pensionario}}</option>
              <option value="Privado">Privado</option>
              <option value="Nacional">Nacional</option>
              <option value="Sin Regimen">Sin Regimen</option>
            </select></p>

        </div>
        <div class="col-lg-6">
         <h4>Seguro de Salud</h4>
          <p>
                    <select class="form-control" name="afiliacion_salud">
              <option value="{{$personales->afiliacion_salud}}">{{$personales->afiliacion_salud}}</option>
              <option value="AFP Integra">AFP Integra</option>
              <option value="AFP Horizonte">AFP Horizonte</option>
              <option value="ONP">ONP</option>
              <option value="Sin Seguro">Sin Seguro</option>

            </select></p>


          <h4>Banco Abonado</h4>
          <p>
            <select class="form-control" name="banco_renumeracion">
              <option value="{{$personales->banco_renumeracion}}">{{$personales->banco_renumeracion}}</option>
              <option value="BCP">BCP</option>
              <option value="BN">BN</option>
              <option value="Interbank">Interbank</option>
              <option value="Continental">Continental</option>
              <option value="Scotiabank">Scotiabank</option>
            </select></p>


        </div>
        <div class="col-lg-6">
         <h4>Numero Cuenta</h4>
          <p><input type="text" class="form-control" name="numero_cuenta" value="{{$personales->numero_cuenta}}"></p>

        </div>
        <div class="col-lg-6">

          <h4>Notas</h4>
          <p><input type="text" class="form-control" name="notas" value="{{$personales->notas}}"></p>

          <h4>Tipo Contrato</h4>
          <p>
           <select class="form-control" name="tipo_contrato">
              <option value="{{$personales->tipo_contrato}}">{{$personales->tipo_contrato}}</option>
              <option value="Idefinido">Indefinido</option>
              <option value="Fijo">Fijo</option>
              <option value="Temporal">Temporal</option>
              <option value="Practicante">Practicante</option>
              <option value="Obra o Labor">Obra o Labor</option>
              <option value="Sin Contrato">Sin Contrato</option>
            </select></p>

        </div>

      </div>
				    	<button class="btn btn-primary" type="submit">Guardar</button>


      </form>



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

@endsection