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
            <span class="float-right small text-muted">1406 Elementos</span>
            <ul class="nav nav-tabs">
              <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Contacts</a></li>
              <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-plus"></i> Agregar Contacto</a></li>
            </ul>
            <div class="tab-content">
              <div id="tab-1" class="tab-pane active">
                <div class="full-height-scroll">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover" style="font-size: 13px">
                      <tbody>
                        @foreach($contacto_show as $contacto)
                        <tr>
                          <td class="client-avatar"><img src="https://www.flaticon.es/premium-icon/icons/svg/3772/3772240.svg"> </td>
                          <td><a href="#contact-1" class="client-link">{{$contacto->nombre}}</a></td>
                          <td>{{$contacto->cargo}}</td>
                          <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                          <td> {{$contacto->email}}</td>
                          <td class="contact-type"><i class="fa fa-phone"> </i></td>
                          <td>{{$contacto->telefono}} </td>
                          <td class="contact-type"><i class="fa fa-phone"> </i></td>
                          <td>{{$contacto->celular}}</td>
                          <td class="client-status"><span class="label label-primary">Activo</span></td>
                          {{-- <td class="client-status"><span class="label label-warning">desactivo</span></td> --}}
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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
                          <p><input class="form-control " type="text" name="cargo" >
                          </div>
                          <div class="col-lg-6">
                            <h4>Telefono/Celular:</h4>
                            <div class="row" style="padding-left: 15px">
                              <input class="form-control col-sm-5" name="telefono" type="text" placeholder="Telefono"> &nbsp; -  &nbsp;<input class="form-control col-sm-5" name="celular" type="text" placeholder="Celular" >
                            </div>
                            <h4>Email:</h4>
                            <input class="form-control" name="email" type="text" >
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
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="ibox selected">
        <div class="ibox-content">
          <div class="tab-content">
            <div id="contact-1" class="tab-pane active">
              <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                  <h2>{{$cliente_show->nombre}}</h2>
                </div>
                <div class="col-lg-12">
                  <button type="button" class="btn btn-primary btn-sm btn-block"><i
                    class="fa fa-edit"></i> Editar
                  </button>
                </div>
              </div>
              <div class="client-detail">
                <div class="full-height-scroll">

                    <table class="table table-striped table-hover" style="font-size: 13px">
                      <tbody>
                        <tr>
                          <td class="client-avatar"><img src="https://www.flaticon.es/premium-icon/icons/svg/3772/3772240.svg"> </td>
                          <td><a href="#contact-1" class="client-link">{{$contacto->nombre}}</a></td>
                          <td>a</td>
                          <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                          <td> a</td>
                          <td class="contact-type"><i class="fa fa-phone"> </i></td>
                          <td>a</td>
                          <td class="contact-type"><i class="fa fa-phone"> </i></td>
                          <td>a</td>
                          <td class="client-status"><span class="label label-primary">Activo</span></td>
                        </tr>
                      </tbody>
                    </table>


                <hr/>
                <strong>Timeline activity</strong>
                <div id="vertical-timeline" class="vertical-container dark-timeline">

                  <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon gray-bg">
                      <i class="fa fa-bolt"></i>
                    </div>
                    <div class="vertical-timeline-content">
                      <p>There are many variations of passages of Lorem Ipsum available.
                      </p>
                      <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
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