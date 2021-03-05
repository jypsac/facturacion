@extends('layout')

@section('title', 'cliente ver')
@section('breadcrumb', 'cliente ver')
@section('breadcrumb2', 'cliente ver')
@section('data-toggle', 'modal')
@section('href_accion', '#ModalCliente')
@section('value_accion', 'Agregar')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')
<div class="wrapper wrapper-content  animated fadeInRight">
  <div class="row">
    <div class="col-sm-8">
      <div class="ibox">
        <div class="ibox-content">
          <h2>Contacto Cliente</h2>
          <p>Todos los clientes deben ser verificados antes de poder enviar un correo electrónico y configurar un proyecto.</p>
          <div class="input-group">
            <input type="text" placeholder="Buscar " class="input form-control">
            <span class="input-group-append">
              <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
            </span>
          </div>
          <div class="clients-list">
            <span class="float-right small text-muted">{{$contacto_cantidad}} Elementos</span>
            <ul class="nav nav-tabs">
              <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Contactos</a></li>
              <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-plus"></i> Agregar Contacto</a></li>
            </ul>
            <div class="tab-content">
              {{-- Contactos --}}
              <div id="tab-1" class="tab-pane active">
                <div class="full-height-scroll">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover" style="font-size: 13px">
                      <tbody>
                        @foreach($contacto_show as $contacto)
                        <tr data-toggle="modal" data-target="#exampleModal{{$contacto->id}}" >
                          <td class="client-avatar"><img src="https://www.flaticon.es/premium-icon/icons/svg/3772/3772240.svg"> </td>
                          <td>{{$contacto->nombre}}</td>
                          <td>{{$contacto->cargo}}</td>
                          <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                          <td> {{$contacto->email}}</td>
                          <td class="contact-type"><i class="fa fa-phone"> </i></td>
                          <td>{{$contacto->telefono}} </td>
                          <td class="contact-type"><i class="fa fa-phone"> </i></td>
                          <td>{{$contacto->celular}}</td>
                          @if($contacto->estado==0)
                          <td class="client-status"><span class="label label-primary">Activo</span></td>
                          @elseif($contacto->estado==1)
                          <td class="client-status"><span class="label label-warning">desactivo</span></td>
                          @endif
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$contacto->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document" style="margin-left: 490px;">
                            <div class="modal-content" style="width: 702px;">
                              <div class="modal-body" style="padding-top: 0px;">
                                <div>
                                  <div >
                                    <form action="{{ route('contacto.update',$contacto->id) }}"  enctype="multipart/form-data" method="post">
                                      @csrf
                                      @method('PATCH')
                                      <div >
                                       <div class="client-avatar"><img src="https://www.flaticon.es/premium-icon/icons/svg/3772/3772240.svg"> </div>
                                       <div class="row marketing">
                                        <div class="col-lg-6">
                                          <h4>Nombre del Contacto:</h4>
                                          <input class="form-control" type="text" value="{{$contacto->nombre}}" name="nombre" >
                                          <h4>Cargo:</h4>
                                          <p><input class="form-control " type="text" value="{{$contacto->cargo}}" name="cargo" >
                                          </div>
                                          <div class="col-lg-6">
                                            <h4>Telefono/Celular:</h4>
                                            <div class="row" style="padding-left: 15px">
                                              <input class="form-control col-sm-5" name="telefono" type="text" placeholder="Telefono" value="{{$contacto->telefono}}"> &nbsp; -  &nbsp;<input class="form-control col-sm-5" name="celular" type="text" placeholder="Celular" value="{{$contacto->celular}}" >
                                            </div>
                                            <h4>Email:</h4>
                                            <input class="form-control" name="email" type="text" value="{{$contacto->email}}"  >
                                            <input class="form-control" name="clientes_id" type="hidden" value="{{$cliente_show->id}}"  >
                                          </div>

                                          <div class="col-lg-6">
                                            <h4>Estado</h4>
                                            @if($contacto_cantidad_estado==1)
                                            @if($contacto->estado==0)
                                            <select name="estado" id="" class="form-control" disabled="">
                                              <option value="0"> Activo</option>
                                              <option value="1"> Desactivo</option>
                                            </select>
                                            @elseif($contacto->estado==1)
                                            <select name="estado" id="" class="form-control" >
                                              <option value="1"> Desactivo</option>
                                              <option value="0"> Activo</option>
                                            </select>
                                            @endif
                                            @else
                                            <select name="estado" id="" class="form-control" >
                                              @if($contacto->estado==0)
                                              <option value="0"> Activo</option>
                                              <option value="1"> Desactivo</option>
                                              @elseif($contacto->estado==1)
                                              <option value="1"> Desactivo</option>
                                              <option value="0"> Activo</option>
                                              @endif
                                            </select>
                                            @endif
                                          </div>
                                          <div class="col-lg-6">
                                            <h4 style="color: white">Grabar</h4>
                                            <input class="btn btn-primary" type="submit" value="Grabar">
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- / Modal -->
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              {{-- FIN Contactos --}}

              {{-- Agregar Contactos --}}
              <div id="tab-2" class="tab-pane">
                <div class="full-height-scroll">
                  <div>
                   <form action="{{ route('contacto.store',$cliente_show->id) }}"  enctype="multipart/form-data" method="post">
                     @csrf
                     <div style="padding-top: 20px">
                      <div class="row marketing">
                        <div class="col-lg-6">
                          <h4>Nombre del Contacto:</h4>
                          <input class="form-control" type="text" name="nombre" >
                          <h4>Cargo:</h4>
                          <p><input class="form-control " type="text" name="cargo" value="Empleado">
                          </div>
                          <div class="col-lg-6">
                            <h4>Telefono/Celular:</h4>
                            <div class="row" style="padding-left: 15px">
                              <input class="form-control col-sm-5" name="telefono" type="text" placeholder="Telefono" value="000000"> &nbsp; -  &nbsp;<input class="form-control col-sm-5" name="celular" type="text" placeholder="Celular"  value="0000">
                            </div>
                            <h4>Email:</h4>
                            <input class="form-control" name="email" type="text"  value="sincorreo@gmail.com" >
                            <input type="hidden" name="clientes_id" value="{{$cliente_show->id}}">
                          </div>
                          <div class="col-lg-6">
                            <p><input class="btn btn-primary" type="submit" value="Grabar"></p>
                          </div>

                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              {{--FIN Agregar Contactos --}}
            </div>

          </div>
        </div>
      </div>
    </div>

    {{-- Cliente  --}}
    <div class="col-sm-4">
      <div class="ibox selected">
        <div class="ibox-content">
          <div class="tab-content">
            <div id="contact-1" class="tab-pane active">
              <div class="row m-b-lg">
                <div class="col-lg-4 text-center">
                  <h3>{{$cliente_show->nombre}}</h3>
                </div>
                <div class="col-lg-8" align="left">
                  <ul>
                    <li>{{$cliente_show->documento_identificacion}}: {{$cliente_show->numero_documento}}</li>
                    <li>{{$cliente_show->tipo_cliente}}</li>
                    <li>Fecha Rigistrada: {{$cliente_show->fecha_registro}}</li>
                  </ul>
                </div>
                <div class="col-lg-12">
                 <button class="btn btn-primary btn-sm btn-block" id="boton" style="margin-top: 5px" type="submit" onclick="editar_cliente()"><i
                  class="fa fa-edit"></i> Editar
                </button>
                <script>
                  function editar_cliente() {
                    var table_clientes = document.getElementById("table_clientes");
                    var form_cliente = document.getElementById("form_cliente");
                    var boton=document.getElementById("boton");

                    if( table_clientes.hasAttribute("hidden") )
                    {
                      table_clientes.removeAttribute("hidden", "");
                      boton.innerHTML='<i class="fa fa-edit"></i> Editar';
                      form_cliente.setAttribute("hidden", "");
                    }
                    else{
                      table_clientes.setAttribute("hidden", "");
                      boton.innerHTML='Cancelar';
                      form_cliente.removeAttribute("hidden", "");

                    }
                  }
                </script>
              </div>
            </div>
            <div class="client-detail">
              <div class="full-height-scroll">

                <table class="table table-striped table-hover" style="font-size: 13px" id="table_clientes" >
                  <tbody>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/direccion.svg')}}"> </td>
                      <td><textarea  readonly="" disabled="" class="form-control">{{$cliente_show->direccion}} </textarea></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/correo.svg')}}"> </td>
                      <td><input type="text" value="{{$cliente_show->email}}" readonly="" disabled="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/ubicacion.svg')}}"> </td>
                      <td><input type="text" value="{{$cliente_show->pais}} / {{$cliente_show->departamento}}" readonly="" disabled="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/aniversario.svg')}}"> </td>
                      <td><input type="text" value="{{$cliente_show->aniversario}}" readonly="" disabled="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/telefono.svg')}}"> </td>
                      <td><input type="text" value="{{$cliente_show->telefono}} " readonly="" disabled="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/llamadas.svg')}}"> </td>
                      <td> <input type="text" value=" {{$cliente_show->celular}}" readonly="" disabled="" class="form-control"></td>
                    </tr>
                  </tbody>
                </table>
                {{-- Edita Cliente Hidden --}}
                <form action="{{ route('cliente.update',$cliente_show->id) }}"  enctype="multipart/form-data" method="post">
                  @csrf
                  @method('PATCH')
                  <table class="table table-striped table-hover" style="font-size: 13px" id="form_cliente" hidden="" >
                    <tbody>
                      <tr>
                        <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/ruc.svg')}}"> </td>
                        <td colspan="2"><input type="text" name="nombre" class="form-control" value="{{$cliente_show->nombre}}"></td>
                      </tr>
                      <tr>
                        <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/ruc.svg')}}"> </td>
                        <td><select class="form-control m-b" name="documento_identificacion" >
                          <option value="{{$cliente_show->documento_identificacion}}">{{$cliente_show->documento_identificacion}}</option>
                          <option disabled="">----------------</option>
                          <option value="RUC">RUC</option>
                          <option value="DNI">DNI</option>
                          <option value="pasaporte">Pasaporte</option>
                        </select>
                      </td>
                      <td><input type="text"  name="numero_documento" value="{{$cliente_show->numero_documento}}" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/direccion.svg')}}"> </td>
                      <td colspan="2"><textarea  name="direccion" class="form-control">{{$cliente_show->direccion}} </textarea></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/correo.svg')}}"> </td>
                      <td colspan="2"><input type="text"  name="email" value="{{$cliente_show->email}}" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/ubicacion.svg')}}"> </td>
                      <td><input type="text"  name="pais" value="{{$cliente_show->pais}} " class="form-control">
                      </td><td><input type="text" name="departamento" value="{{$cliente_show->departamento}}"  class="form-control">
                      </td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/ubicacion.svg')}}"> </td>
                      <td><input type="text"  name="ciudad" value="{{$cliente_show->ciudad}}" class="form-control">
                        <td> <select class="form-control" name="tipo_cliente">
                          <option value="{{$cliente_show->tipo_cliente}}">{{$cliente_show->tipo_cliente}}</option>
                          <option disabled="">--------------------</option>
                          <option value="Cliente Frecuente">Cliente Frecuente</option>
                          <option value="Cliente Revendedor">Cliente Revendedor</option>
                          <option value="Cliente VIP">Cliente VIP</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/telefono.svg')}}"> </td>
                      <td><input type="text"  name="telefono" value="{{$cliente_show->telefono}} " class="form-control"></td>
                      <td><input type="text"  name="celular" value="{{$cliente_show->celular}}" class="form-control"></td>
                    </tr>
                    <tr>
                      <td class="client-avatar"><img src="{{ asset('/archivos/imagenes/clientes_svg/aniversario.svg')}}"> </td>
                      <td><input type="text"  name="aniversario" value="{{$cliente_show->aniversario}}" class="form-control"></td>
                      <td><input type="text"  name="fecha_registro" value="{{$cliente_show->fecha_registro}}" class="form-control"></td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center"><button class="btn btn-primary" type="submit"> Guardar</button></td>
                    </tr>
                  </tbody>
                </table>
              </form>
              <hr/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- Fin Cliente --}}
</div>
</div>
<style>
  .form-control{border-radius: 5px}
</style>
<!-- Mainly scripts -->
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

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
{{-- scritp de modal agregar --}}
<script>
  $(document).ready(function(){
    $("#wizard").steps();
    $("#form").steps({
      bodyTag: "fieldset",
      onStepChanging: function (event, currentIndex, newIndex)
      {
                    // ¡Siempre permita retroceder incluso si el paso actual contiene campos no válidos!
                    if (currentIndex > newIndex)
                    {
                      return true;
                    }

                    // Prohibir suprimir el paso "Advertencia" si el usuario es demasiado joven
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                      return false;
                    }

                    var form = $(this);

                    // Limpie si el usuario retrocedió antes
                    if (currentIndex < newIndex)
                    {
                        // Para eliminar estilos de error
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                      }

                    // Deshabilite la validación en los campos que están deshabilitados u ocultos.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Iniciar validación; Evite avanzar si es falso
                    return form.valid();
                  },
                  onStepChanged: function (event, currentIndex, priorIndex)
                  {
                    // Suprima (omita) el paso "Advertencia" si el usuario tiene edad suficiente.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                      $(this).steps("next");
                    }

                    // Suprima (omita) el paso "Advertencia" si el usuario tiene la edad suficiente y quiere el paso anterior.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                      $(this).steps("previous");
                    }
                  },
                  onFinishing: function (event, currentIndex)
                  {
                    var form = $(this);

                    // Deshabilita la validación en los campos que están deshabilitados.
                    // En este punto, se recomienda hacer una verificación general (significa ignorar solo los campos deshabilitados)
                    form.validate().settings.ignore = ":disabled";

                    // Iniciar validación; Evitar el envío del formulario si es falso
                    return form.valid();
                  },
                  onFinished: function (event, currentIndex)
                  {
                    var form = $(this);

                    // Enviar entrada de formulario
                    form.submit();
                  }
                }).validate({
                  errorPlacement: function (error, element)
                  {
                    element.before(error);
                  },
                  rules: {
                    confirm: {
                      equalTo: "#password"
                    }
                  }
                });
              });
            </script>
            {{-- / --}}


            @endsection