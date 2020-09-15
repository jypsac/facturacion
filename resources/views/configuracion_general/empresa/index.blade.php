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
                      <input  type="text" class="form-control"  value="{{$mi_empresa->pagina_web}}">
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
          <br>
          N° Soles: {{$bancos->numero_soles}}
          <br>
          N° Dolares: {{$bancos->numero_dolares}}<br>
          @if($bancos->estado==0)
          <strong> estado: Activado</strong>
          @else
          <strong> estado: Desactivado</strong>
          @endif

          <br><br>
          <a  class="btn btn-lg btn-success" href="{{ route('banco.edit', $bancos->id) }}" style="padding: 3px 5px 3px 7px; " > <i  class="fa fa-edit"></i></a>
        </p>
      </div>
      @endforeach


    </div>


  </div>
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
    <style type="text/css">
      .banco{border-radius: 5px;border: 1px solid black }
    </style>

    @endsection