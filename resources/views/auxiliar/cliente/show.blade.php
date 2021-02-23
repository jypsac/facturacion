@extends('layout')

@section('title', 'cliente ver')
@section('breadcrumb', 'cliente ver')
@section('breadcrumb2', 'cliente ver')
@section('data-toggle', 'modal')
@section('href_accion', '#ModalCliente')
@section('value_accion', 'Agregar')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')

<div style="padding-top: 20px;padding-bottom: 50px">
  <div class="container" style=" padding-top: 30px; background: white;">
    <div class="jumbotron" style="height: 50px;padding:10px">
     <center><h1>{{$cliente_show->nombre}}</h1> </center>
   </div>

   <i  class="fa fa-user-o" aria-hidden="true" style="font-size: 35px"></i>&nbsp;&nbsp;
   <a  class="btn btn-success" href="{{ route('cliente.edit', $cliente_show->id) }}" role="button"> <i class="fa fa-edit"></i></a>
   <br><br>
   <div class="row marketing">

    <div class="col-lg-12">

      <div class="row">
        <div class="col-lg-4">
          <h4>Nombre:</h4>
          <p>{{$cliente_show->nombre}}</p>
        </div>
        <div class="col-lg-4">
          <h4>Direccion:</h4>
          <p>{{$cliente_show->direccion}}</p>
        </div>
        <div class="col-lg-4">
          <h4>Email:</h4>
          <p>{{$cliente_show->email}}</p>
        </div>
      </div><hr>

      <div class="row">
        <div class="col-lg-4">
          <h4>Pais:</h4>
          <p>{{$cliente_show->pais}}</p>
        </div>
        <div class="col-lg-4">
          <h4>Departamento:</h4>
          <p>{{$cliente_show->departamento}}</p>
        </div>
        <div class="col-lg-4">
          <h4>Ciudad:</h4>
          <p>{{$cliente_show->ciudad}}</p>
        </div>
      </div><hr>

      <div class="row">
        <div class="col-lg-4">
          <h4>Codigo Postal:</h4>
          <p>{{$cliente_show->cod_postal}}</p>
        </div>
        <div class="col-lg-4">
         <h4>Telefono:</h4>
         <p>{{$cliente_show->numero_documento}}</p>
       </div>
       <div class="col-lg-4">
        <h4>Celular:</h4>
        <p>{{$cliente_show->celular}}</p>
      </div>

    </div><hr>

    <div class="row">
      <div class="col-lg-4">
        <h4>Documento De Identifiacion:</h4>
        <p>{{$cliente_show->documento_identificacion}}</p>
      </div>
      <div class="col-lg-4">
       <h4>Numero Documento:</h4>
       <p>{{$cliente_show->numero_documento}}</p>
     </div>
     <div class="col-lg-4">
      <h4>Tipo de Cliente:</h4>
      <p>{{$cliente_show->tipo_cliente}}</p>
    </div>

  </div><hr>

  <div class="row">
    <div class="col-lg-4">
      <h4>Fecha de Aniversario:</h4>
      <p>{{$cliente_show->aniversario}}</p>
    </div>
    <div class="col-lg-4">
     <h4>Fecha de Registro:</h4>
     <p>{{$cliente_show->fecha_registro}}</p>
   </div>
            <!-- <div class="col-lg-4">
              <h4>Tipo de Cliente:</h4>
          <p>{{$cliente_show->tipo_cliente}}</p>
        </div> -->

      </div><hr>


    </div>

  </div>

  {{--Contacto  --}}
  <!-- Button trigger modal -->
  <i  style="font-size: 35px" class="fa fa-address-book-o" aria-hidden="true"></i>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Agregar Contacto </button><br>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-left: 490px;">
      <div class="modal-content" style="width: 702px;">
        <div class="modal-body" style="padding-top: 0px;">
          <div>
            <div >
              <form action="{{ route('contacto.store',$cliente_show->id) }}"  enctype="multipart/form-data" method="post">
               @csrf
               <div >
                <h1><i class="fa fa-address-book-o" aria-hidden="true"></i>  </h1>
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
<!-- / Modal -->

<div style="padding-bottom: 10px; padding-top: 5px">
  @foreach($contacto_show as $contacto)
  <table>

    <tr>
      <th>
        <a  class="btn btn-success" href="{{ route('contacto.editar', $contacto->id) }}" role="button"> <i class="fa fa-edit"></i></a>
      </th>
      @if($contacto->primer_contacto==1)
      @else
      <th>
        <a data-toggle="modal" class="btn btn-s-m btn-info" href="#modal-form"><i class="fa fa-star"></i></a>
      </th>
      @endif
    </tr>
  </table>

  <div class="row marketing">
   <div class="col-lg-6">
     <h4>Nombre del Contacto:</h4>
     <p>{{$contacto->nombre}}</p><hr>
     <h4>Cargo:</h4>
     <p>{{$contacto->cargo}}</p><hr>
   </div>
   <div class="col-lg-6">
     <h4>Telefono/Celular:</h4>
     <p>{{$contacto->telefono}} / {{$contacto->celular}}</p><hr>
     <h4>Email:</h4>
     <p>{{$contacto->email}}</p><hr>
   </div>


 </div>
 @endforeach
</div>

</div>
</div>
{{-- Modal Contacto Principal --}}

<div id="modal-form" class="modal fade" aria-hidden="true">
  <div class="modal-dialog" style="margin-top: 12%">
    <div class="modal-content">
      <div class="modal-body">

       <div class="ibox-content float-e-margins">

         <h3 class="font-bold col-lg-12" align="center">
          ¿Esta Seguro que Deseas Cambiar como "Contacto Principal"?
        </h3>
        <p align="center">
         <a class="btn btn-w-m btn-primary" href="">Aceptar</a>
         {{-- <a class="btn btn-w-m btn-danger"  href="">Cancelar</a> --}}
         <button type="button" class="btn btn-w-m btn-danger" data-dismiss="modal">Cancelar</button>

       </p>
     </div>

   </div>
 </div>
</div>
</div>
{{-- Fin Modal Contacto Principal --}}


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