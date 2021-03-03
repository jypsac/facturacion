@extends('layout')
@section('title', 'Provedor')
@section('breadcrumb', 'Provedor')
@section('breadcrumb2', 'Provedor')

@section('data-toggle', 'modal')
@section('href_accion', '#ModalProvedor')
@section('value_accion', 'Agregar')


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
{{-- Modal Provedor --}}
<div class="modal fade" id="ModalProvedor" tabindex="-1" role="dialog" aria-labelledby="Provedor" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-left: 22%;">
    <div class="modal-content" style="width: 880px;">
      <div class="modal-header">
        <h5 class="modal-title" id="Provedor">Agregar Provedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div>
     <div class="ibox-content" style="padding-bottom: 0px;">
        <form>
            {{ csrf_field() }}
            <div class="form-group  row"><label class="col-sm-3 col-form-label">Introducir Ruc (Inestable):</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" class="ruc" id="ruc" name="ruc" required="required">
                </div>
                <div class="col-sm-2"> <button class="btn btn-primary" id="boton" class="botoncito"><i class="fa fa-search"></i> Buscar</button></div>
            </div>

        </form><script>
            $(function(){
                $('#boton').on('click', function(){
                    var ruc = $('#ruc').val();
                    var url = "{{ url('provedorruc') }}";
                    $.ajax({
                        type:'GET',
                        url:url,
                        data:'ruc='+ruc,
                        success: function(datos_dni){
                            var datos = eval(datos_dni);
                            $('#numero_ruc').val(datos[0]);
                            $('#razon_social').val(datos[1]);
                            $('#direccion').val(datos[2]);
                        }
                    });
                        return false;
                });
            });
        </script>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px">
        <div class="row">
            <div class="col-lg-12">
                <div >
                    <div >
                        <form action=""  enctype="multipart/form-data" id="form" class="wizard-big" method="post"> {{-- Yiel form- es para colocar una ruta alterna  --}}
                            @csrf
                            <h1>Datos Personales</h1>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Documento Identificacion *</label>
                                            <select class="form-control m-b" name="documento_identificacion" >
                                                <option value="RUC">RUC</option>
                                                <option value="DNI">DNI</option>
                                                <option value="pasaporte">Pasaporte</option>
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
                                            <input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc" required  autocomplete="off" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Direccion *</label>
                                            <input type="text" class="form-control" name="direccion" id="direccion" class="form-control required" required="required">
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Correo *</label>
                                                <input  name="email" value="sincorreo@gmail.com" type="text" class="form-control required " required="required">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Distrito *</label>
                                                <input type="text" class="form-control" name="ciudad" id="distrito" class="form-control required" required="required">
                                                <input type="submit" >
                                            </div>
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
</div>
{{-- Fin Modal Cliente --}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 13px" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>RUC</th>
                                    <th>Empresa</th>
                                    <th>Direccion</th>
                                    <th>Telefonos</th>
                                    <th>Correo</th>
                                    <th>-</th>
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
                                    <td>{{$provedor->email_provedor}}</td>
                                    <td><div id="auto" style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()">
                                        <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i>  </a>
                                    </div></td>
                                </tr>
                                <tr hidden="" id="form{{$provedor->id}}">
                                    <form action="{{ route('provedor.update',$provedor->id) }}"  enctype="multipart/form-data" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <td>{{$provedor->id}}</td>
                                        <td><input class="form-control" name="ruc" value="{{$provedor->ruc}}" type="text"></td>
                                        <td><input class="form-control" name="empresa" value="{{$provedor->empresa}}" type="text"></td>
                                        <td><input class="form-control" name="direccion" value="{{$provedor->direccion}}" type="text"></td>
                                        <td><input class="form-control" name="telefonos" value="{{$provedor->telefonos}}" type="text"></td>
                                        <td><input class="form-control" name="email_provedor" value="{{$provedor->email_provedor}}" type="text"></td>
                                        <td >{{--  <div id="auto" style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()">
                                                <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i></a>
                                            </div>  --}}<input class="btn  btn-success" type="submit"></td>
                                        </form>
                                    </tr>
                                    <script>
                                        var clic = 1;
                                        function divAuto{{$provedor->id}}(){
                                           if(clic==1){
                                             // document.getElementById("div-mostrar").style.height = "50px";
                                             document.getElementById("vista{{$provedor->id}}").setAttribute("hidden", "");
                                             document.getElementById("form{{$provedor->id}}").removeAttribute("hidden", "");
                                             clic = clic + 1;
                                         } else{
                                            // document.getElementById("div-mostrar").style.height = "0px";
                                            document.getElementById("vista{{$provedor->id}}").removeAttribute("hidden", "");
                                            document.getElementById("form{{$provedor->id}}").setAttribute("hidden", "");
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