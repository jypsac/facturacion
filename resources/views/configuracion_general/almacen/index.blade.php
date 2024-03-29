@extends('layout')

@section('title', 'Almacen')
@section('breadcrumb', 'Almacen')
@section('breadcrumb2', 'Almacen')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')

<!-- Modal Create  -->
@if($errors->any())
<div style="padding-top: 10px">
  <div class="alert alert-danger">
    <a class="alert-link" href="#">
      @foreach ($errors->all() as $error)
      <li style="color: red">{{ $error }}</li>
      @endforeach
  </a>
</div>
</div>
@endif
@if (session('campo'))
<div class="alert alert-success">
    {{ session('campo') }}
</div>
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-left: 450px;">
        <div class="modal-content" style="width: 702px;">

            <div style="padding-left: 15px;padding-right: 15px;">
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center" onsubmit="return valida(this)">

                    <form action="{{route('almacen.store')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group  row">
                            <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/almacen.svg')}}" width="100px"></div>
                            <label class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Almacen" class="form-control" required="required" name="nombre" autocomplete="off" >
                            </div><br>
                            <label class="col-sm-2 col-form-label">Abreviatura:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="abreviatura" autocomplete="off" required="required" placeholder="ALM.">
                            </div>
                            <label class="col-sm-2 col-form-label">Responsable:</label>
                            <div class="col-sm-4">
                                <select name="responsable" required  class="form-control m-b" autocomplete="off" required="required" style="margin-bottom: 0px;">
                                  @foreach($personal as $personals)
                                  <option value="{{$personals->id}}" > {{$personals->nombres}} {{$personals->apellidos}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <label class="col-sm-2 col-form-label">Codigo Sunat:</label>
                          <div class="col-sm-4">
                            <input  type="number" class="form-control" name="cod_sunat" autocomplete="off" required="required" placeholder="Numero de sucursal">
                        </div>
                        <label class="col-sm-2 col-form-label">Dirección:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Av. , Calle, Ciudad" name="direccion" autocomplete="off" required="required">
                        </div>
                        <label class="col-sm-2 col-form-label">Cod. Ubigeo:</label>
                        <div class="col-sm-4">
                            <input type="number"  class="form-control" name="ubigeo" autocomplete="off" required="required" value="150101">
                        </div>

                        <label class="col-sm-2 col-form-label">Descripcion:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="descripcion" autocomplete="off" required="required">Almacen ...</textarea>
                        </div>
                        <br><br>
                        <br>
                        <br>
                        <div class="col-sm-12">
                            <p class="form-control"  style="background: #57b59738;text-align: left;font-family: fangsong;"><b>Nota:</b>Los campos siguientes es el numero de registro que se continuara en el sistema.</p>
                        </div>
                        <div class="col-lg-4 ">
                            <label class="col-sm-12 col-form-label">Cod.Facturacion:</label>
                            <div class="input-group m-b">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">F00 &nbsp;</span>
                                </div>
                                <input type="text" value="" class="form-control write_button" name="serie_factura" autocomplete="off"  required="required">
                                <div class="input-group-append">
                                    <span class="input-group-addon">- 000</span>
                                </div>
                                <input type="text" value="" required name="cod_fac" class="form-control write_button">
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <label class="col-sm-12 col-form-label">Cod.Boleta:</label>
                            <div class="input-group m-b">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">B00 &nbsp;</span>
                                </div>
                                <input type="text" value="" class="form-control write_button" name="serie_boleta" autocomplete="off"  required="required">
                                <div class="input-group-append">
                                    <span class="input-group-addon">- 000</span>
                                </div>
                                <input type="text" value="" required name="cod_bol" class="form-control write_button">
                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <label class="col-sm-12 col-form-label">Cod.Guia R.:</label>

                            <div class="input-group m-b">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">T00 &nbsp;</span>
                                </div>
                                <input type="text" value="" class="form-control write_button" name="serie_remision" autocomplete="off"  required="required">
                                <div class="input-group-append">
                                    <span class="input-group-addon">- 000</span>
                                </div>
                                <input type="text" value="" required name="cod_guia" class="form-control write_button">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-4">
                                <label class="col-sm-12 col-form-label">Cod. Nota Credito:</label>
                                <div class="input-group m-b">
                                    <div class="input-group-prepend">
                                        <span class="input-group-addon">F00 &nbsp;</span>
                                    </div>
                                    <input type="text" value="" class="form-control write_button" name="serie_credito" autocomplete="off"  required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-addon">- 000</span>
                                    </div>
                                    {{-- @if(is_numeric($almacen->cod_fac)) --}}
                                    <input type="text" value="" required name="cod_credito" class="form-control write_button">
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="col-sm-12 col-form-label">Cod. Nota Debito:</label>
                                <div class="input-group m-b">
                                    <div class="input-group-prepend">
                                        <span class="input-group-addon">F00 &nbsp;</span>
                                    </div>
                                    <input type="text" value="" class="form-control write_button" name="serie_debito" autocomplete="off" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-addon">- 000</span>
                                    </div>
                                    {{-- @if(is_numeric($almacen->cod_fac)) --}}
                                    <input type="text" value="" required name="cod_debito" class="form-control write_button">
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="col-lg-2">

                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="action" id="boton">Guardar</button>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- / Modal Create  -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Direccion</th>
                                    <th>Responsable</th>
                                    <th>Descripcion</th>
                                    <th>Activo/Desactivo</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($almacenes as $almacen)
                                <tr class="gradeX">
                                    <td>{{$almacen->id}}</td>
                                    <td>{{$almacen->nombre}}</td>
                                    <td>{{$almacen->abreviatura}}</td>
                                    <td>{{$almacen->direccion}}</td>
                                    <td>{{$almacen->personal->nombres}} {{$almacen->personal->apellidos}}</td>
                                    <td>{{$almacen->descripcion}}</td>
                                    <td>@if($almacen->estado==0)Activo @elseif($almacen->estado==1)Desactivo @endif</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$almacen->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$almacen->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document"style="margin-left: 450px;">
                                                <div class="modal-content" style="width: 702px;">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{route('almacen.update',$almacen->id)}}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-group  row">
                                                                    <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/almacen.svg')}}" width="100px"></div>

                                                                    <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                    <div class="col-sm-4"><input type="text" class="form-control" name="nombre" value="{{$almacen->nombre}}"></div>

                                                                    <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                                                    <div class="col-sm-4"><input type="text" class="form-control" name="abreviatura" value="{{$almacen->abreviatura}}"></div>

                                                                    <label class="col-sm-2 col-form-label">Responsable:</label>
                                                                    <div class="col-sm-4">
                                                                        <select class="form-control" name="responsable">
                                                                            <option value="{{$almacen->personal->id}}">{{$almacen->personal->nombres}}</option>
                                                                            <option disabled="disabled">----------------------------</option>
                                                                            @foreach($personal as $personals)
                                                                            <option value="{{$personals->id}}">{{$personals->nombres}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <label class="col-sm-2 col-form-label">Codigo Sunat:</label>
                                                                    <div class="col-sm-4">
                                                                        <input style="padding-right: 0;padding-left:  7px"  type="text" class="form-control"  value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_sunat')->first()}}" name="cod_sunat">
                                                                    </div>

                                                                    <label class="col-sm-2 col-form-label">Dirección:</label>
                                                                    <div class="col-sm-4"><input type="text" class="form-control" name="direccion" value="{{$almacen->direccion}}"></div>
                                                                    <label class="col-sm-2">Cod. Ubigeo</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" name="ubigeo" class="form-control" value="{{$almacen->cod_postal}}">
                                                                    </div>
                                                                    <label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                    <div class="col-sm-6"><textarea class="form-control" name="descripcion" autocomplete="off" required="required" >{{$almacen->descripcion}}</textarea></div>

                                                                    <label class="col-sm-2 col-form-label">Activo/desactivo:</label>
                                                                    {{-- <input type="checkbox" class="js-switch{{$almacen->id}}" checked /> --}}

                                                                    <div class="col-sm-1">
                                                                        @if($almacen->estado == 0)
                                                                        @if($conteo_almacen == 1)
                                                                        <div class="switch-button">
                                                                            <input type="text" name="estado" value="on" hidden="hidden">
                                                                              <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked  disabled="disabled" />
                                                                        </div>
                                                                        @elseif($conteo_almacen >1)
                                                                        <div class="switch-button">
                                                                             <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked   />
                                                                        </div>
                                                                        @endif

                                                                        @elseif($almacen->estado == 1)
                                                                        <div class="switch-button">
                                                                             <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" />

                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group  row">
                                                                    <div class="col-lg-4 ">
                                                                        <label class="col-sm-12 col-form-label">Cod.Facturacion:</label>
                                                                        <div class="input-group m-b">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-addon">F00 &nbsp;</span>
                                                                            </div>
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura')->first()}}" class="form-control" name="serie_factura" autocomplete="off" readonly="" required="required">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-addon">- 000</span>
                                                                            </div>
                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura')->first()))
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura')->first()}}" name="cod_fac" class="form-control ">
                                                                            @else
                                                                            <input type="text" value="" readonly name="cod_fac" class="form-control ">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 ">
                                                                        <label class="col-sm-12 col-form-label">Cod.Boleta:</label>
                                                                        <div class="input-group m-b">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-addon">B00 &nbsp;</span>
                                                                            </div>
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta')->first()}}" class="form-control" name="serie_boleta" autocomplete="off" readonly="" required="required">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-addon">- 000</span>
                                                                            </div>
                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta')->first()))
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta')->first()}}" name="cod_bol" class="form-control ">
                                                                            @else
                                                                            <input type="text" value="" readonly name="cod_bol" class="form-control ">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 ">
                                                                        <label class="col-sm-12 col-form-label">Cod.Guia R.:</label>
                                                                        <div class="input-group m-b">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-addon">T00 &nbsp;</span>
                                                                            </div>
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision')->first()}}" class="form-control" name="serie_remision" autocomplete="off" readonly="" required="required">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-addon">- 000</span>
                                                                            </div>
                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision')->first()))
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision')->first()}}" name="cod_guia" class="form-control ">
                                                                            @else
                                                                            <input type="text" value="" readonly name="cod_guia" class="form-control ">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-2">
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <label class="col-sm-12 col-form-label">Cod. Nota Credito:</label>
                                                                        <div class="input-group m-b">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-addon">F00 &nbsp;</span>
                                                                            </div>
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito')->first()}}" class="form-control" name="serie_credito" autocomplete="off" readonly="" required="required">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-addon">- 000</span>
                                                                            </div>
                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito')->first()))
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito')->first()}}" name="cod_credito" class="form-control ">
                                                                            @else
                                                                            <input type="text" value="" readonly name="cod_credito" class="form-control ">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <label class="col-sm-12 col-form-label">Cod. Nota Debito:</label>
                                                                        <div class="input-group m-b">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-addon">F00 &nbsp;</span>
                                                                            </div>
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_debito')->first()}}" class="form-control" name="serie_debito" autocomplete="off" readonly="" required="required">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-addon">- 000</span>
                                                                            </div>
                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_debito')->first()))
                                                                            <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_debito')->first()}}" name="cod_debito" class="form-control ">
                                                                            @else
                                                                            <input type="text" value="" readonly name="cod_debito" class="form-control ">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">

                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-primary" type="submit" name="action">Guardar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.form-control{margin-top: 6px;}
.input-group-append{margin-top: 6px;}
.input-group-prepend{margin-top: 6px;}
/*.write_button{border-color: #899db7;}*/
</style>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@foreach($almacenes as $almacen)

<!-- Switchery -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script>
    var elem{{$almacen->id}} = document.querySelector('.js-switch{{$almacen->id}}');
    var switchery = new Switchery(elem{{$almacen->id}}, { color: '#4cc0f7' });
</script>
@endforeach

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

@endsection
