@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Perfil')
@section('breadcrumb2', 'Personal-Perfil')
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
             <td>
                 <a class="btn btn-lg btn-success" href="{{ route('personal.edit', $personales->id) }}" style="background-color: #1ab394; border-color: #1ab394"> <i class="fa fa-edit"></i></a>
             </td>
             <td>
               @if($personales->estado==0)
                  <a class="btn btn-lg btn-success" href="{{ route('create.laboral', $personales->id) }}" style="background-color: #2ab524; border-color: #1ab394"> <i class="fa fa-plus"></i></a>

               @else
                  <a class="btn btn-lg btn-success" href="{{ route('personal-datos-laborales.show', $personales->id) }}" style="background-color: #2ab524; border-color: #1ab394"> <i class="fa fa-eye"></i></a>
              
               
               @endif
             </td>

     </table>
                        
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Fecha Nacimiento</h4>
          <p>{{$personales->fecha_nacimiento}} </p><hr>

          <h4>Celular</h4>
          <p>{{$personales->celular}} </p><hr>


          <h4>Genero</h4>
          <p>{{$personales->genero}} </p><hr>
        </div>

        <div class="col-lg-6">
          <h4>Correo</h4>
          <p>{{$personales->email}} </p><hr>

            <h4>Nivel Educativo</h4>
          <p>{{$personales->nivel_educativo}} </p><hr>

            <h4>Carrera Profesional</h4>
          <p>{{$personales->profesion}} </p><hr>


        </div>
        <div class="col-lg-6">
         

          <h4>Documento Identificacion</h4>
          <p>{{$personales->documento_identificacion}} </p><hr>

          <h4>Estado Civil</h4>
          <p>{{$personales->estado_civil}} </p><hr>

        

        </div>
        <div class="col-lg-6">
         <h4>Numero Documento</h4>
          <p>{{$personales->numero_documento}} </p><hr>
          

          <h4>Direccion Domiciliaria</h4>
          <p>{{$personales->direccion}} </p><hr>

          
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