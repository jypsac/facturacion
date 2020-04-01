@extends('layout')

@section('title', 'crear provedor')
@section('breadcrumb', 'crear provedor')
@section('breadcrumb2', 'crear provedor')
@section('href_accion', route('provedor.index'))
@section('value_accion', 'atras')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Metodo Sunat</h5>
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
                    <form>
                        {{ csrf_field() }}
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Introducir Ruc (Inestable):</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" class="ruc" id="ruc" name="ruc">
                            </div>
                        </div>
                        <button class="btn btn-primary" id="botoncito" class="botoncito"><i class="fa fa-search"></i> Buscar</button>
                    </form>
                        {{-- <div>RUC: <span id="numero_rucs"></span></div> --}}
                        {{-- <div>RAZON SOCIAL: <span id="razon_social"></span></div>
                        <div>INICIO DE ACTIVIDAD: <span id="fecha_actividad"></span></div>
                        <div>CONDICION: <span id="condicion"></span></div>
                        <div>TIPO DE CONTRIBUYENTE: <span id="tipo"></span></div>
                        <div>ESTADO DE CONTRIBUYENTE: <span id="estado"></span></div>
                        <div>FECHA DE INSCRIPCION: <span id="fecha_inscripcion"></span></div>
                        <div>DOMICILIO: <span id="domicilio"></span></div>
                        <div>EMISION ELECTRONICA: <span id="emision"></span></div> --}}

                    </section>
                        <script>
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
            </div>
        </div>
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Creacion de provedor</h5>
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

<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style="padding-top: 30px;padding-bottom: 30px; background: white;">
 <form action="{{ route('provedor.store') }}"  enctype="multipart/form-data" method="post">
                             @csrf

      <div class="jumbotron" style="height: 60px;padding:10px">
       <center><input style="width: 250px;font-size: 18px;" type="text" required="required" class="form-control" name="empresa" id="razon_social"></center>
      </div>

<h1><i class="fa fa-user-o" aria-hidden="true"></i></h1>
      <div class="row marketing">
        <div class="col-lg-6">


          <h4>Ruc:</h4>
         <p><input type="text" required="required" class="form-control" name="ruc" id="numero_ruc"></p>

          <h4>Direccion:</h4>
          <p><input type="text" required="required" class="form-control" name="direccion" id="domicilio"></p>

          <h4>Telefonos:</h4>
          <p><input type="text" required="required" class="form-control" name="telefonos" ></p>

           <h4>Correo del provedor:</h4>
          <p><input type="text" required="required" class="form-control" name="email_provedor" ></p>
        </div>

        <div class="col-lg-6">

          <h4>Correo del Contacto:</h4>
          <p><input type="text" required="required" class="form-control" name="email" ></p>

          <h4>Nombre del contacto:</h4>
          <p><input type="text" required="required" class="form-control" name="contacto_provedor" ></p>

          <h4>Celular del contacto:</h4>
          <p><input type="text" required="required" class="form-control" name="celular_provedor" ></p>

          <h4>Observacion:</h4>
          <p><textarea name="observacion" required="required" class="form-control"></textarea></p>
    </div>

<button class="btn btn-primary" type="submit">Grabar</button>
</form>
</div>
</div>
                </div>
            </div>


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
@stop