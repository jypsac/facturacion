@extends('layout')

@section('title', 'crear provedor')
@section('breadcrumb', 'crear provedor')
@section('breadcrumb2', 'crear provedor')
@section('href_accion', route('provedor.index'))
@section('value_accion', 'atras')

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
					<form enctype="multipart/form-data" method="post">
                        {{ csrf_field() }} {{ method_field('POST') }}
					 	<div class="form-group row"><label class="col-sm-2 col-form-label">Ruc:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="ruc" id="ruc"></div>
                        </div>
                        <button class="btn btn-primary" type="submit" id="botoncito">Buscar y Enviar</button>
                        <img src="ajax.gif" class="ajaxgif hide">
					</form>
				</div>
			</div>
        </div>
                <div>RUC: <span id="numero_ruc"></span></div>
                <div>RAZON SOCIAL: <span id="razon_social"></span></div>
                <div>INICIO DE ACTIVIDAD: <span id="fecha_actividad"></span></div>
                <div>CONDICION: <span id="condicion"></span></div>
                <div>TIPO DE CONTRIBUYENTE: <span id="tipo"></span></div>
                <div>ESTADO DE CONTRIBUYENTE: <span id="estado"></span></div>
                <div>FECHA DE INSCRIPCION: <span id="fecha_inscripcion"></span></div>
                <div>DOMICILIO: <span id="domicilio"></span></div>
                <div>EMISION ELECTRONICA: <span id="emision"></span></div>
        <script>
                $(function(){
                    $('#botoncito').on('click', function(){
                        var ruc = $('#ruc').val();
                        var url = '{{ url('provedor') }}';
                        $('.ajaxgif').removeClass('hide');
                        $.ajax({
                        type:'POST',
                        url:url,
                        data:'ruc='+ruc,
                        success: function(datos_dni){
                            $('.ajaxgif').addClass('hide');
                            var datos = eval(datos_dni);
                                var nada ='nada';
                                if(datos[0]==nada){
                                    alert('DNI o RUC no válido o no registrado');
                                }else{
                                    $('#numero_ruc').text(datos[0]);
                                    $('#razon_social').text(datos[1]);
                                    $('#fecha_actividad').text(datos[2]);
                                    $('#condicion').text(datos[3]);
                                    $('#tipo').text(datos[4]);
                                    $('#estado').text(datos[5]);
                                    $('#fecha_inscripcion').text(datos[6]);
                                    $('#domicilio').text(datos[7]);
                                    $('#emision').text(datos[8]);
                                }		
                        }
                    });
                    return false;
                    });
                });
        </script>
        
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
                    <div class="ibox-content">
                        <form action="{{ route('provedor.store') }}"  enctype="multipart/form-data" method="post">
                             @csrf
                             <div class="form-group  row"><label class="col-sm-2 col-form-label">Ruc:</label>
                                 <div class="col-sm-10"><input type="text" class="form-control" name="ruc"></div>
                            </div>
                            
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre de Empresa:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="empresa"></div>
                            </div>
    
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Direccion:</label>
                                 <div class="col-sm-10"><input type="text" class="form-control" name="direccion"></div>
                            </div>
    
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Telefonos:</label>
                                 <div class="col-sm-10"><input type="text" class="form-control" name="telefonos"></div>
                            </div>
    
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo:</label>
                                 <div class="col-sm-10"><input type="email" class="form-control" name="email"></div>
                            </div>
                            
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre del contacto:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="contacto_provedor"></div>
                           </div>
    
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Celular del contacto:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="celular_provedor"></div>
                            </div>
    
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo del provedor:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="email_provedor"></div>
                            </div>
    
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Observacion:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="observacion"></div>
                            </div>
    
    
    
                            <button class="btn btn-primary" type="submit">Guardar</button>
    
                        </form>
    
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