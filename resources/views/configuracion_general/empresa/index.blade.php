@extends('layout')

@section('title', 'Configuracion de Empresa')
@section('breadcrumb', 'Empresa')
@section('breadcrumb2', 'Empresa')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Editar')

@section('content')

<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-left: 25%">
    <div class="modal-content" style="width: 702.22222px;">

      <div style="padding-left: 15px;padding-right: 15px;">
        {{-- ccccccccccccccccc --}}
        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px" align="center">

          <form action="{{route('empresa.update',$mi_empresa->id) }}"  enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
            <fieldset >
              <div>
                <div class="panel-body" >
                  <div class="row">
                    <div class="col-sm-12">
                      <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" alt="">
                    </div>
                    <label class="col-sm-2 col-form-label">Descripcion:</label>
                    <div class="col-sm-10" style="padding-bottom: 10px">
                      <textarea name="descripcion" class="form-control">{{$mi_empresa->descripcion}}</textarea>
                    </div>
                    <label class="col-sm-2 col-form-label">Movil:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="movil" value="{{$mi_empresa->movil}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Telefono:</label>
                    <div class="col-sm-4" style="padding-bottom: 15px; ">
                      <input type="text" class="form-control" name="telefono" value="{{$mi_empresa->telefono}}">
                    </div>

                    <label class="col-sm-2 col-form-label">Correo:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="correo" value="{{$mi_empresa->correo}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Region Provincia:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="region_provincia" value="{{$mi_empresa->region_provincia}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Pais:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="pais" value="{{$mi_empresa->pais}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Ciudad:</label>
                    <div class="col-sm-4" style="padding-bottom: 15px">
                      <input type="text" class="form-control" name="ciudad" value="{{$mi_empresa->ciudad}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Calle:</label>
                    <div class="col-sm-4" style="padding-bottom: 15px">
                      <textarea name="calle" class="form-control" >{{$mi_empresa->calle}}</textarea>
                    </div>
                    <label class="col-sm-2 col-form-label">Codigo Postal:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="codigo_postal" value="{{$mi_empresa->codigo_postal}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Rubro:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="rubro" value="{{$mi_empresa->rubro}}">
                    </div>
                    <label class="col-sm-2 col-form-label">Pagina Web:</label>
                    <div class="col-sm-4">
                      <input  type="text" class="form-control" name="pagina_web" value="{{$mi_empresa->pagina_web}}">
                    </div>
                  </div>
                </div>
              </div>

            </fieldset>
            <button class="btn btn-primary" type="submit">Grabar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Modal Create  -->

<div class="container" style="height:auto;padding-top: 10px; background: white; margin-bottom: 50px; " >
  <div class="jumbotron">
    <h1>{{$mi_empresa->nombre}}
      <img align="right"  src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 300px;height: 50px; border-radius:15px"></h1>
      <br>
      <p class="lead" style="font-size: 15px">{{$mi_empresa->descripcion}}</p>
      {{-- <p><a class="btn btn-lg btn-success" href="#" style="background-color: #1ab394; border-color: #1ab394"> <i class="fa fa-edit"></i></a></p> --}}
    </div>

    <div class="row marketing">
      <div class="col-lg-6">
        <h4> Razon Social</h4>
        <p>{{$mi_empresa->razon_social}}</p><hr>

        <h4>RUC</h4>
        <p>{{$mi_empresa->ruc}}</p><hr>

        <h4>Telefono</h4>
        <p>{{$mi_empresa->telefono}}</p><hr>
      </div>

      <div class="col-lg-6">
        <h4>Movil</h4>
        <p>{{$mi_empresa->movil}}</p><hr>

        <h4>Correo</h4>
        <p>{{$mi_empresa->correo}}</p><hr>

        <h4>Pais</h4>
        <p>{{$mi_empresa->pais}}</p><hr>
      </div>
      <div class="col-lg-6">
        <h4>Region Provincia</h4>
        <p>{{$mi_empresa->region_provincia}}</p><hr>

        <h4>Ciudad</h4>
        <p>{{$mi_empresa->ciudad}}</p><hr>

        <h4>Calle</h4>
        <p>{{$mi_empresa->calle}}</p><hr>
      </div>
      <div class="col-lg-6">
        <h4>Codigo Postal</h4>
        <p>{{$mi_empresa->codigo_postal}}</p><hr>

        <h4>Rubro</h4>
        <p>{{$mi_empresa->rubro}}</p><hr>

        <h4>Moneda Principal</h4>
        <p>{{$mi_empresa->moneda->nombre}}</p><hr>
      </div>
      <div class="col-lg-6">
        <h4>Pagina Web</h4>
        <p>{{$mi_empresa->pagina_web}}</p><hr>

      </div>
    </div>

    <div class="row ">

      @foreach($banco as $bancos)
      <div class="col-lg-3 " align="center">
        <p class="form-control">
          <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 100px;height: 30px;">
          <br> <span style="font-size: 11px">
            S/: {{$bancos->numero_soles}}
            <br>
            $: {{$bancos->numero_dolares}}<br></span>
            @if($bancos->estado==0)
            <strong> Estado: Activado</strong>
            @else
            <strong> Estado: Desactivado</strong>
            @endif
            <br>
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$bancos->id}}"><i class="fa fa-edit"></i></button>
            <div class="modal fade" id="exampleModal{{$bancos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div style="padding-left: 15px;padding-right: 15px;">
                    {{-- ccccccccccccccccc --}}
                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                      <form action="{{ route('banco.update',$bancos->id) }}"  enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <fieldset >
                          <div>
                            <div class="panel-body" >
                              <div class="row">
                                {{-- Foto --}}
                                <div class="col-sm-12">
                                 <input type="file" id="archivoInput{{$bancos->id}}" name="foto" onchange="return validarExt{{$bancos->id}}()"  />
                                 <div id="visorArchivo{{$bancos->id}}">
                                   <!--Aqui se desplegará el fichero-->
                                   <center >
                                    <img src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 200;height: 60px;"></center>
                                  </div>
                                  <input type="text" value="{{$bancos->foto}}" class="form-control" name="ori_foto" hidden="hidden">
                                </div>

                                {{--/ foto --}}
                                <label class="col-sm-3 col-form-label">N° Soles:</label>
                                <div class="col-sm-9" style="padding-bottom: 10px">
                                  <input type="text" class="form-control" name="numero_soles" value="{{$bancos->numero_soles}}">
                                </div>
                                <label class="col-sm-3 col-form-label">N° Dolares:</label>
                                <div class="col-sm-9" style="padding-bottom: 10px">
                                  <input type="text" class="form-control" name="numero_dolares" value="{{$bancos->numero_dolares}}">
                                </div>

                                <label class="col-sm-3 col-form-label">Activo/Desactivo:</label>
                                <div class="col-sm-3">
                                  @if($bancos->estado == 0)
                                  <div class="switch-button">
                                    <input type="checkbox" name="estado" id="switch-label{{$bancos->id}}" class="switch-button__checkbox" checked="">
                                    <label for="switch-label{{$bancos->id}}" class="switch-button__label"></label>
                                  </div>
                                  @else
                                  <div class="switch-button">
                                    <input type="checkbox" name="estado" id="aswitch-label{{$bancos->id}}" class="switch-button__checkbox" >
                                    <label for="aswitch-label{{$bancos->id}}" class="switch-button__label"></label>
                                  </div>
                                  @endif
                                </div>
                                <div class="col-sm-2">
                                 <button class="btn btn-primary" type="submit">Grabar</button>
                               </div>
                               <div class="col-sm-2">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               </div>
                             </div>
                           </div>
                         </div>

                       </fieldset>


                     </form>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <!-- / Modal Create  -->
         </p>
       </div>
       @endforeach

     </div>


   </div>
   @foreach($banco as $bancos)
   <script type="text/javascript">
    {{-- Fotooos --}}
    function validarExt{{$bancos->id}}(){
      var archivoInput = document.getElementById('archivoInput{{$bancos->id}}');
      var archivoRuta = archivoInput.value;
      var extPermitidas = /(.jpg|.png|.jfif)$/i;
      if(!extPermitidas.exec(archivoRuta)){
        alert('Asegurese de haber seleccionado una Imagen');
        archivoInput.value = '';
        return false;
      }else{
        //PRevio del PDF
        if (archivoInput.files && archivoInput.files[0])
        {
          var visor = new FileReader();
          visor.onload = function(e)
          {
            document.getElementById('visorArchivo{{$bancos->id}}').innerHTML =
            '<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
          };
          visor.readAsDataURL(archivoInput.files[0]);
        }
      }
    }


  </script>
  <style>input#archivoInput{{$bancos->id}}{
      position:absolute;
      top:0px;
      left:0px;
      right:0px;
      bottom:0px;
      width:100%;
      height:100%;
      opacity: 0  ;
    }</style> @endforeach
  <style type="text/css" media="screen">

    :root {
      --color-button: #fdffff;
    }
    .switch-button {
      display: inline-block;
      padding-top: 9px;
      padding-right: 30px;
    }
    .switch-button .switch-button__checkbox {
      display: none;
    }
    .switch-button .switch-button__label {
      background-color:#1f1f1f66;
      width: 2rem;
      height: 1rem;
      border-radius: 3rem;
      display: inline-block;
      position: relative;
    }
    .switch-button .switch-button__label:before {
      transition: .6s;
      display: block;
      position: absolute;
      width: 1rem;
      height: 1rem;
      background-color: var(--color-button);
      content: '';
      border-radius: 50%;
      box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
      background-color: #1c84c6;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
      transform: translateX(1rem);
    }
    .banco{border-radius: 5px;border: 1px solid black }

  </style>
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
  <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

  <!-- Custom and plugin javascript -->
  <script src="{{ asset('js/inspinia.js') }}"></script>
  <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

  <script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
          height: '300px'
        })

      });

    </script>

    @endsection