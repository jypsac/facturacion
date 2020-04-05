@extends('layout')

@section('title', 'Personal') 
@section('breadcrumb', 'Personal-Agregar')
@section('breadcrumb2', 'Personal-Agregar')
@section('href_accion', route('personal.show', $personales->id) )
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
                <th width="100% "><h1 style="color: black">{{$personales->nombres}} {{$personales->apellidos}} <br> <span style="font-size: 20px">&nbsp;&nbsp;{{$personales->nacionalidad}}</span></h1>
                </th>
                <th  width="100%" rowspan="2">

                            <a href="{{ asset('/profile/images/')}}/{{$personales->foto}}" title="{{$personales->nombres}}  {{$personales->apellidos}}" data-gallery=""><img src="{{ asset('/profile/images/')}}/{{$personales->foto}}" class="rounded-circle circle-border m-b-md" alt="profile"  width="150px" height="150px" ></a>

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
      
     <form action="{{ route('personal-datos-laborales.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
         <input type="text" class="form-control" value="{{$personales->id}}" name="personal_id" hidden="hidden">
      <div class="row marketing">
        <div class="col-lg-6">

          <h4>Fecha Viculacion</h4>
          <p><input type="date" class="form-control" name="fecha_vinculacion" ></p>

          <h4>Fecha Retiro</h4>
          <p><input type="date" class="form-control" name="fecha_retiro" ></p>


          <h4>Forma Pago</h4>
          <p>        
              <select class="form-control" name="forma_pago">
              <option value="Semanal">Semanal</option>
              <option value="Quincenal">Quincenal</option>
              <option value="Mensual">Mensual</option>
              <option value="Otros">Otros</option>
            </select></p>

        </div>

        <div class="col-lg-6">
          <h4>Salario</h4>
          <p><input type="text" class="form-control" name="salario" > </p>

            <h4>Categoria Ocupacional</h4>
          <p>
            <select class="form-control" name="categoria_ocupacional">
              <option value="Obrero">Obrero</option>
              <option value="Empleado">Empleado</option>
              <option value="Administrativo">Administrativo</option>
              <option value="Ejecutivo">Ejecutivo</option>
            </select>
          </p>

            <h4>Estado Del Trbajador</h4>
          <p>
           <select class="form-control" name="estado_trabajador">
              <option value="Activo">Activo</option>
              <option value="Retirado">Retirado</option>
              <option value="Vacaciones">Vacaciones</option>
              <option value="Descanso medico">Descanso medico</option>
            </select></p>

        </div>
        <div class="col-lg-6">
         

          <h4>Sede</h4>
          <p><input type="text" class="form-control" name="sede" ></p>

          <h4>Turno</h4>
          <p>
           <select class="form-control" name="turno">
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
              <option value="Noche">Noche</option>
            </select></p>

        </div>
        <div class="col-lg-6">
         <h4>Departamento Area</h4>
          <p>
            <select class="form-control" name="departamento_area">
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
              <option value="vendedor">vendedor</option>
              <option value="Obrero">Obrero</option>
              <option value="Empleado">Empleado</option>
              <option value="Contador">Contador</option>
              <option value="Jefe de Ventas">Jefe de Ventas</option>
              <option value="Administrador">Administrador</option>
              <option value="Gerente">Gerente</option>
            </select>
          </p>

        </div>

        <div class="col-lg-6">
         

          <h4>Tipo Trbajador</h4>
          <p>
           <select class="form-control" name="tipo_trabajador">
              <option value="Interno">Interno</option>
              <option value="Externo">Externo</option>
              <option value="Temporal">Temporal</option>
            </select></p>


          <h4>Regimen Pensionario</h4>
          <p>
           <select class="form-control" name="regimen_pensionario">
              <option value="Privado">Privado</option>
              <option value="Nacional">Nacional</option>
              <option value="Sin Regimen">Sin Regimen</option>
            </select></p>
        

        </div>
        <div class="col-lg-6">
         <h4>Seguro de Salud</h4>
          <p><input type="text" class="form-control" name="afiliacion_salud"  value="Sin Seguro">
           <select class="form-control" name="afiliacion_salud">
              <option value="AFP Integra">AFP Integra</option>
              <option value="AFP Horizonte">AFP Horizonte</option>
              <option value="ONP">ONP</option>
              <option value="Sin Seguro">Sin Seguro</option>

            </select></p>
          

          <h4>Banco Abonado</h4>
          <p>
            <select class="form-control" name="banco_renumeracion">
              <option value="BCP">BCP</option>
              <option value="BN">BN</option>
              <option value="Interbank">Interbank</option>
              <option value="Continental">Continental</option>
              <option value="Scotiabank">Scotiabank</option>
            </select></p>
          
        </div>
        <div class="col-lg-6">
         <h4>Numero Cuenta</h4>
          <p><input type="text" class="form-control" name="numero_cuenta" ></p>
          
        </div>
        <div class="col-lg-6">

          <h4>Notas</h4>
          <p><input type="text" class="form-control" name="notas" ></p>

          <h4>Tipo Contrato</h4>
          <p>
          <select class="form-control" name="tipo_contrato">
              <option value="Idefinido">Indefinido</option>
              <option value="Fijo">Fijo</option>
              <option value="Temporal">Temporal</option>
              <option value="Practicante">Practicante</option>
              <option value="Obra o Labor">Obra o Labor</option>
              <option value="Sin Contrato"></option>
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