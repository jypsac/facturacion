@extends('layout')
@section('title', 'Provedor')
@section('breadcrumb', 'Provedor')
@section('breadcrumb2', 'Provedor')

@section('data-toggle', 'modal')
@section('href_accion', '#ModalProvedor')
@section('value_accion', 'Agregar')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 13px" >
                            <thead>
                                <tr >
                                    <th>ID</th>
                                    <th>RUC</th>
                                    <th>Empresa</th>
                                    <th>Direccion</th>
                                    <th>Telefonos</th>
                                    <th>Correo</th>
                                    <th style="width: 50px;">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($provedores as $provedor)
                                <tr class="gradeX"  id="vista{{$provedor->id}}">
                                    <td>{{$provedor->id}}</td>
                                    <td>{{$provedor->ruc}}</td>
                                    <td>{{$provedor->empresa}}</td>
                                    <td>{{$provedor->direccion}}</td>
                                    <td>{{$provedor->telefonos}}</td>
                                    <td>{{$provedor->email}}</td>
                                    <td><div style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()">
                                        <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i>  </a>
                                    </div></td>
                                </tr>
                                <tr hidden id="forma{{$provedor->id}}">
                                    <form action="{{ route('provedor.update',$provedor->id) }}"  enctype="multipart/form-data" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <td>{{$provedor->id}}</td>
                                        <td><input class="form-control" name="" value="{{$provedor->ruc}}" readonly=""  type="text"></td>
                                        <td><input class="form-control" name="empresa" value="{{$provedor->empresa}}" type="text"></td>
                                        <td><input class="form-control" name="direccion" value="{{$provedor->direccion}}" type="text"></td>
                                        <td><input class="form-control" name="telefonos" value="{{$provedor->telefonos}}" type="text"></td>
                                        <td><input class="form-control" name="correo_provedor" value="{{$provedor->email}}" type="text"></td>
                                        <td > {{-- <div  style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()">
                                            <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i></a>
                                        </div> --}} <input class="btn  btn-success" type="submit"> </td>
                                    </form>
                                </tr>
                                <script>
                                    var clic = 1;
                                    function divAuto{{$provedor->id}}(){
                                        if(clic==1){
                                             // document.getElementById("div-mostrar").style.height = "50px";
                                             document.getElementById("forma{{$provedor->id}}").removeAttribute("hidden", "");
                                             document.getElementById("vista{{$provedor->id}}").setAttribute("hidden", "");
                                             clic = clic + 1;
                                         } else{
                                            // document.getElementById("div-mostrar").style.height = "0px";
                                            document.getElementById("vista{{$provedor->id}}").removeAttribute("hidden", "");
                                            document.getElementById("forma{{$provedor->id}}").setAttribute("hidden", "");
                                            clic = 1;
                                        }
                                    }
                                </script>
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
        $("#form1").steps({
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