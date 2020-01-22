@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Editar')
@section('breadcrumb2', 'Personal-Editar')
@section('href_accion', route('personal.index') )
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
                <th width="100% "><h1 style="color: black">{{$persona->nombres}} {{$persona->apellidos}} <br> <span style="font-size: 20px">&nbsp;&nbsp;{{$persona->nacionalidad}}</span></h1>
                </th>
                <th  width="100%" rowspan="2">

                            <a href="{{ asset('/profile/images/')}}/{{$persona->foto}}" title="{{$persona->nombres}}  {{$persona->apellidos}}" data-gallery=""><img src="{{ asset('/profile/images/')}}/{{$persona->foto}}" class="rounded-circle circle-border m-b-md" alt="profile"  width="150px" height="150px" ></a>

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

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Fecha Viculacion</h4>
          <p><input type="text" value="{{$personales->fecha_vinculacion}} "></p><hr>

          <h4>Fecha Retiro</h4>
          <p>{{$personales->fecha_retiro}} </p><hr>


          <h4>Forma Pago</h4>
          <p>{{$personales->forma_pago}} </p><hr>
        </div>

        <div class="col-lg-6">
          <h4>Salario</h4>
          <p>{{$personales->salario}} </p><hr>

            <h4>Categoria Ocupacional</h4>
          <p>{{$personales->categoria_ocupacional}} </p><hr>

            <h4>Estado Del Trbajador</h4>
          <p>{{$personales->estado_trabajador}} </p><hr>


        </div>
        <div class="col-lg-6">
         

          <h4>Sede</h4>
          <p>{{$personales->sede}} </p><hr>

          <h4>Turno</h4>
          <p>{{$personales->turno}} </p><hr>

        
        </div>
        <div class="col-lg-6">
         <h4>Departamento Area</h4>
          <p>{{$personales->departamento_area}} </p><hr>
          

          <h4>Cargo</h4>
          <p>{{$personales->cargo}} </p><hr>

          
        </div>

        <div class="col-lg-6">
         

          <h4>Tipo Trbajador</h4>
          <p>{{$personales->tipo_trabajador}} </p><hr>

          <h4>Regimen Pensionario</h4>
          <p>{{$personales->regimen_pensionario}} </p><hr>

        
        </div>
        <div class="col-lg-6">
         <h4>Seguro de Salud</h4>
          <p>{{$personales->afiliacion_salud}} </p><hr>
          

          <h4>Banco Abonado</h4>
          <p>{{$personales->banco_renumeracion}} </p><hr>

          
        </div>
        <div class="col-lg-6">
         <h4>Numero Cuenta</h4>
          <p>{{$personales->numero_cuenta}} </p><hr>
          
        </div>
        <div class="col-lg-6">

          <h4>Notas</h4>
          <p>{{$personales->notas}} </p><hr>
        </div>

      </div>



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