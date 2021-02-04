@extends('layout')

@section('title', 'Cliente')
@section('breadcrumb', 'Cliente')
@section('breadcrumb2', 'Cliente')

@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')

@section('content')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@if($errors->any())
<div style="padding-top: 20px;">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
</div>
@endif

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-left: 22%;">
    <div class="modal-content" style="width: 880px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div>

    {{--  --}}
    <div class="ibox-content" >
        <form>
            {{ csrf_field() }}
            <div class="form-group  row"><label class="col-sm-2 col-form-label">Introducir Ruc (Inestable):</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" class="ruc" id="ruc" name="ruc">
                </div>
            </div>
            <button class="btn btn-primary" id="botoncito" class="botoncito"><i class="fa fa-search"></i> Buscar</button>
        </form><script>
            $(function(){
                $('#botoncito').on('click', function(){
                    var ruc = $('#ruc').val();
                    var url = "{{ url('provedorruc') }}";
                    $('.ajaxgif').removeClass('hide');
                    $.ajax({
                        type:'GET',
                        url:url,
                        data:'ruc='+ruc,
                        success: function(datos_dni){
                            $('.ajaxgif').addClass('hide');
                            var datos = eval(datos_dni);
                            var nada ='nada';
                            if(datos[0]==nada){
                                alert('DNI o RUC no válido o no registrado');
                            }else{
                                $('#numero_ruc').val(datos[0]);
                                $('#razon_social').val(datos[1]);
                                $('#fecha_actividad').val(datos[2]);
                                $('#condicion').val(datos[3]);
                                $('#tipo').val(datos[4]);
                                $('#estado').val(datos[5]);
                                $('#fecha_inscripcion').val(datos[6]);
                                $('#domicilio').val(datos[7]);
                                $('#emision').val(datos[8]);
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div >

                    <div >
                        <form action="{{ route('cliente.store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post">
                            @csrf
                            <h1>Datos Personales</h1>
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Documento Identificacion *</label>
                                            <select class="form-control m-b" name="documento_identificacion" >
                                                <option value="DNI">DNI</option>
                                                <option value="pasaporte">Pasaporte</option>
                                                <option value="RUC">Ruc</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre *</label>
                                            <input type="text" class="form-control" name="nombre" class="form-control required" id="razon_social" required="required">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Numero de Documento *</label>
                                            <input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc" required value="{{ old('numero_documento')}}" autocomplete="off" type="number">
                                            <datalist id="browserdoc" >
                                                @foreach($clientes as $cliente)
                                                <option id="a">{{$cliente->numero_documento}} - existente</option>
                                                @endforeach
                                            </datalist>
                                        </div>

                                        <div class="form-group">
                                            <label>Direccion *</label>
                                            <input type="text" class="form-control" name="direccion" id="domicilio" class="form-control required" required="required">
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Correo *</label>
                                                <input  name="email" type="text" class="form-control required " required="required">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Ciudad *</label>
                                                <input type="text" class="form-control" name="ciudad" class="form-control required" required="required">
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </fieldset>
                            <h1>Informacion</h1>
                            <fieldset>
                                <div class="row" >
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Telefono *</label>
                                                <input value="5200000" type="number" class="form-control" name="telefono" class="form-control required">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Departamento *</label>
                                                <input value="Lima" type="text" class="form-control" name="departamento" class="form-control required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Celular *</label>
                                                <input value="92000000" type="number" class="form-control" name="celular" class="form-control required">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Pais *</label>
                                                <input value="Perú" type="text" class="form-control" name="pais" class="form-control required">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tipo Cliente *</label>
                                            <select class="form-control" name="tipo_cliente">
                                                <option value="Cliente Frecuente">Cliente Frecuente</option>
                                                <option value="Cliente Revendedor">Cliente Revendedor</option>
                                                <option value="Cliente VIP">Cliente VIP</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Aniversario *</label>
                                            <input value="2020-07-22" type="date" class="form-control" name="aniversario" class="form-control required">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label>Codigo Postal *</label>
                                            <input value="01" name="cod_postal" type="text" class="form-control required ">
                                        </div>

                                        <div class="form-group">
                                            <label>Fecha Registro *</label>
                                            <input value="{{date("Y-m-d")}}" type="date" class="form-control" name="fecha_registro" class="form-control required">
                                        </div>

                                    </div>

                                </div>
                            </fieldset>
                            <h1>Contacto</h1>
                            <fieldset>
                                <h2>Informacion I</h2>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nombre *</label>
                                            <input id="name" name="nombre_contacto" type="text" class="form-control required" value="Contacto">
                                        </div>
                                        <div class="form-group">
                                            <label>Cargo *</label>
                                            <input id="surname" name="cargo_contacto" type="text" class="form-control required" value="Cargo">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Telefono *</label>
                                            <input id="email" name="telefono_contacto" type="text" class="form-control required" value="0050000">
                                        </div>
                                        <div class="form-group">
                                            <label>Celular *</label>
                                            <input id="address" name="celular_contacto" type="text" class="form-control required" value="951000000">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Correo *</label>
                                            <input id="email" name="email_contacto" type="text" class="form-control required email" value="correo@contanto.com">
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

    {{--  --}}



</div>

</div>
</div>
</div>
{{--  --}}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Creacion de Almacen</h5>
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
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Nro Documento</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                <tr class="gradeX">
                                    <td>{{$cliente->id}}</td>
                                    <td>{{$cliente->nombre}}</td>
                                    <td>{{$cliente->documento_identificacion}}</td>
                                    <td>{{$cliente->numero_documento}}</td>
                                    <td>{{$cliente->email}}</td>
                                    <td>{{$cliente->celular}}</td>
                                    <td><center><a href="{{ route('cliente.show', $cliente->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
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

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            }
            ]

        });

        });

    </script>

    @endsection