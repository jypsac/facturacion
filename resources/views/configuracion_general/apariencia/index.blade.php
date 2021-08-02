@extends('layout')

@section('title', 'Apariencia')
@section('breadcrumb', 'Apariencia')
@section('breadcrumb2', 'Apariencia')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Agregar </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div> @foreach($config as $configs)
                <div class="ibox-content">
                    <form action="{{route('apariencia.update',$configs->id)}}"  enctype="multipart/form-data" method="post">

                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-6">
                             <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                       <thead>
                                           <th>Modificacion</th>
                                           <th>Seleccione</th>
                                           <th>Refresh</th>
                                       </thead>
                                       <tbody>
                                        <tr>
                                            <td>Fondo del Perfil :</td>
                                            <td><select name="fondo_perfil"  class="form-control m-b">
                                                <option value="{{$configs->fondo_perfil}}">{{$configs->fondo_perfil}}</option>
                                                <option value="gris.png">gris.png</option>
                                                <option value="azul_claro.png">azul_claro.png</option>
                                                <option value="azul.jfif">azul.jfif</option>
                                                <option value="naranja.png">naranja.png</option>
                                                <option value="paisaje_atardecer.jpg">paisaje_atardecer.jpg</option>
                                                <option value="paisaje_noche.jpg">paisaje_noche.jpg</option>
                                                <option value="paisaje.jpg">paisaje.jpg</option>
                                            </select></td>
                                          {{--   <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td> --}}
                                        </tr>
                                        <tr>
                                            <td>Borde del Perfil :</td>
                                            <td><select name="borde_foto"  class="form-control m-b">
                                                <option value="{{$configs->borde_foto}}">{{$configs->borde_foto}}</option>
                                                <option value="0px">0px</option>
                                                <option value="1px">1px</option>
                                                <option value="2px">2px</option>
                                                <option value="3px">3px</option>
                                                <option value="4px">4px</option>

                                            </select></td>
                                           {{--  <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td> --}}
                                        </tr>
                                        <tr>
                                            <td>Color del Borde del Perfil :</td>
                                            <td>
                                                <input type="color" name="color_borde_foto" value="{{$configs->color_borde_foto}}">
                                            </td>
                                         {{--    <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td> --}}
                                        </tr>
                                        <tr>
                                            <td>Color del Nombre:</td>
                                            <td><input type="color" name="color_nombre" value="{{$configs->color_nombre}}"></td>
                                           {{--  <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td> --}}
                                        </tr>
                                        <tr>
                                            <td>Sombras del Nombre:</td>
                                            <td><input type="color" name="color_sombra_nombre" value="{{$configs->color_sombra_nombre}}"> </td>
                                           {{--  <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td> --}}
                                        </tr>
                                        <tr>
                                            <td>Tamaño de la letra del Nombre:</td>
                                            <td>
                                                <select name="tamano_letra_perfil" class="form-control">
                                                    <option value="{{$configs->tamano_letra_perfil}}">{{$configs->tamano_letra_perfil}}</option>
                                                    <option value="12px">12px</option>
                                                    <option value="15px">15px</option>
                                                    <option value="18px">18px</option>
                                                </select> </td>
                                                <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div> {{-- col-sm-6 --}}
                        <div class="col-lg-6">
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                       <thead>
                                           <th>Modificacion</th>
                                           <th>Seleccione</th>
                                           <th>Refresh</th>
                                       </thead>
                                       <tbody>

                                        <tr>
                                            <td>Icono Favicon :</td>
                                            <td><select name="foto_icono"  class="form-control m-b">
                                                <option value="{{$configs->foto_icono}}">{{$configs->foto_icono}}</option>
                                            </select></td>
                                           {{--  <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td> --}}
                                        </tr>
                                        <tr>
                                            <td>TipoGrafía :</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <select name="tamano_letra"  class="form-control">
                                                            @if($configs->tamano_letra=='')
                                                            <option value="">0%</option>
                                                            @else
                                                            <option value="{{$configs->tamano_letra}}">{{$configs->tamano_letra}}</option>
                                                            @endif
                                                            <option value="100%">100%</option>
                                                            <option value="90%">90%</option>
                                                            <option value="80%">80%</option>
                                                            <option value="70%">70%</option>
                                                            <option value="">0%</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <select name="letra"  class="form-control">
                                                            <option value="{{$configs->letra}}">{{$configs->letra}}</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value=" sans-serif">sans-serif</option>
                                                            <option value="none">none</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td><button type="sumbit" class="btn btn-success"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh </button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>{{-- row --}}
            </form>
        </div> @endforeach
    </div>
</div>
</div>
</div>
<style>
    .form-control{border-radius: 10px}
    .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
    .check{-webkit-appearance: none;height: 34px;background-color: #ffffff00;-moz-appearance: none;border: none;appearance: none;width: 80px;border-radius: 10px;}
    .div_check{position: relative;top: -33px;left: 0px;background-color: #ffffff00;  top: -35;}
    .check:checked {background: #0375bd6b;}
</style>
<!-- Mainly scripts -->
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
            height: '200px'
        })

    });

</script>

@endsection