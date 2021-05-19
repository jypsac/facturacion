@extends('layout')

@section('title', 'movimiento consulta')
@section('breadcrumb', 'Movimiento Consulta')
@section('breadcrumb2', 'Movimiento Consulta')
@section('href_accion', '')
@section('value_accion', 'Agregar')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" align="right" style="padding-right: 3.1%">
        {{-- <div class="ibox-tools"> --}}
            {{-- <a class="btn btn-success"  href="" >Imprimir --}}
            <div class="tooltip-demo" >
                <button type="submit" id="pdf" name="pdf" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg" ></i></button>
            </div>
    </div>

	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nueva Entradas</h5>
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
					<form enctype="multipart/form-data"  id="formulario">
                        @csrf
                        <div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Fecha Inicio:</label>
								<div class="col-sm-4">
									<input type="datetime-local" class="form-control" name="fecha_inicio" >
								</div>

							<label class="col-sm-2 col-form-label">Fecha Final:</label>
								<div class="col-sm-4">
                                    <input type="datetime-local" class="form-control" name="fecha_final" >
							    </div>
						</div>

						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Almacen:</label>
								<div class="col-sm-4">
									<select class="form-control" name="almacen" id="almacen" onchange="seleccionado()">
                                        <option value="0">Todos los almacenes</option>
                                        @foreach($almacenes as $almacen)
                                        <option value="{{$almacen->id}}">{{$almacen->nombre}}</option>
                                        @endforeach
                                    </select>
								</div>

							<label class="col-sm-2 col-form-label">Categoria :</label>
								<div class="col-sm-4">
                                    <select class="form-control" name="categoria" id="categoria" onchange="seleccionado()">
                                        <option value="0">Seleccione Categoria</option>
                                        <option value="1">Productos</option>
                                        <option value="2">Servicios</option>
                                    </select>
							    </div>
						</div>

                        <div class="form-group row " id="consulta_p" style="display:none;">
							<label class="col-sm-2 col-form-label" >Consulta para Productos:</label>
								<div class="col-sm-10">
									<select class="form-control" name="consulta_p_input" id="consulta_p_input">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Compra</option>
                                        <option value="2">Venta</option>
                                        <option value="3">Compra Y Venta</option>
                                    </select>
								</div>
						</div>

                        <div class="form-group row " id="consulta_s" style="display:none;">
							<label class="col-sm-2 col-form-label" >Consulta para Servicio:</label>
								<div class="col-sm-10">
									<select class="form-control" name="consulta_s_input" id="consulta_s_input">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Venta</option>
                                    </select>
								</div>
						</div>
                        
					</form>
                    <button  class="btn btn-primary" id="boton" name="boton">Consultar</button>
				</div>
			</div>

            <div class="ibox-content">
                <div class="ibox-title">
                    <h5>Compras Productos</h5>
                    <div class="table-responsive">
                        <table id="tablaid" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nr Doc</th>
                                    <th>Proveedor</th>
                                    <th>Ruc</th>
                                    <th>Nr Doc Prov</th>
                                    <th>Subtotal</th>
                                    <th>Igv</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        <tbody id="tbody">
                            <tr class="gradeX">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="ibox-content">
                <div class="ibox-title">
                    <h5>Facturas</h5>
                    <div class="table-responsive">
                        <table id="tablaid_venta" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nr Doc</th>
                                    <th>Proveedor</th>
                                    <th>Ruc</th>
                                    <th>Nr Doc </th>
                                    <th>Subtotal</th>
                                    <th>Igv</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        <tbody id="tbody_venta">
                            <tr class="gradeX">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="ibox-content">
                <div class="ibox-title">
                    <h5>Boletas</h5>
                    <div class="table-responsive">
                        <table id="tablaid_venta_b" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nr Doc</th>
                                    <th>Cliente</th>
                                    <th>Ruc</th>
                                    <th>Nr Doc </th>
                                    <th>Subtotal</th>
                                    <th>Igv</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        <tbody id="tbody_venta">
                            <tr class="gradeX">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

		</div>
	</div>
</div>
<script>
    $(document).ready(function(e) {

        $('#boton').on('click', function() {
            // var opt = $('#categoria').val();
            // if(opt=="1"){
                    //para productos
                    $.ajax({
                    method: "POST",
                    url: "{{ route('ajax_movimiento') }}",
                    data:$("#formulario").serialize()
                }).done(function(res){
                    $('#tablaid').dataTable().fnDestroy();
                    var data=JSON.parse(res);
                    $('#tablaid').dataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
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
                            ],
                        "aaData": data,
                        "columns": [
                            { "data": "fecha_compra" },
                            { "data": "codigo_guia" },
                            { "data": "provedor.empresa" , "defaultContent": ""},
                            { "data": "provedor.ruc" , "defaultContent": ""},
                            { "data": "factura" },
                            { "data": "subtotal"},
                            { "data": "igv" },
                            { "data": "precio_nacional_total" }
                        ]
                    });
                    
                });

                
                
                $('#tbody_venta tr').slice(1).remove();
                $.ajax({
                    method: "POST",
                    url: "{{ route('ajax_movimiento_ventas') }}",
                    data:$("#formulario").serialize()
                }).done(function(res){
                    $('#tablaid_venta').dataTable().fnDestroy();
                    var data=JSON.parse(res);
                    $('#tablaid_venta').dataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
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
                            ],
                        "aaData": data,
                        "columns": [
                            { "data": "fecha_emision" , "defaultContent": "" },
                            { "data": "codigo_fac" },
                            { "data": "cliente.nombre" , "defaultContent": ""},
                            { "data": "cliente.numero_documento" , "defaultContent": ""},
                            { "data": "codigo_fac" },
                            { "data": "subtotal"},
                            { "data": "igv" },
                            { "data": "precio" }
                        ]
                    })
                });

                $('#tbody_venta_b tr').slice(1).remove();
                $.ajax({
                    method: "POST",
                    url: "{{ route('ajax_movimiento_ventas_b') }}",
                    data:$("#formulario").serialize()
                }).done(function(res){
                    $('#tablaid_venta_b').dataTable().fnDestroy();
                    var data=JSON.parse(res);
                    $('#tablaid_venta_b').dataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
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
                            ],
                        "aaData": data,
                        "columns": [
                            { "data": "fecha_emision" , "defaultContent": "" },
                            { "data": "codigo_boleta" },
                            { "data": "cliente.nombre" , "defaultContent": ""},
                            { "data": "cliente.numero_documento" , "defaultContent": ""},
                            { "data": "codigo_boleta" },
                            { "data": "subtotal"},
                            { "data": "igv" },
                            { "data": "precio" }
                        ]
                    })
                });
            // }else{
            //     $('#compras_table_productos').hide();
            //     $('#compras_table_servicios').show();
            //     //para servicios
            //     alert("servicios")
                

            // }
		});
        $('#pdf').on('click', function() {
            $("#formulario").attr("action",'{{ route('periodo_consulta_pdf') }}');
            $("#formulario").attr("method",'POST');
            $("#formulario").submit();
		});

    });
</script>
	
    
    
     {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
    <script>
        function valida(f) {
            var boton=document.getElementById("boton");
            var completo = true;
            var incompleto = false;
            if( f.elements[0].value == "" )
               { alert(incompleto); }
           else{boton.type = 'button';}
       }
   </script>
   {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}

<script>
        function seleccionado(){
            var opt = $('#categoria').val();
            var alm = $('#almacen').val();
            console.log(alm);
            if(alm=="1"){
                if(opt=="1"){
                    $('#consulta_p_input').prop('disabled', false);
                    $('#consulta_p').show();
                    $('#consulta_s_input').prop('disabled', 'disabled');
                    $('#consulta_s').hide();
                }else{
                    $('#consulta_p_input').prop('disabled', 'disabled');
                    $('#consulta_p').hide();
                    $('#consulta_s_input').prop('disabled', false);
                    $('#consulta_s').show();
                }
            }else{
                $('#consulta_p_input').prop('disabled', 'disabled');
                $('#consulta_p').hide();
                $('#consulta_s_input').prop('disabled', false);
                $('#consulta_s').show();
            }
        }

        function actualizatext() {
            let action = document.getElementById("texto2").value;
            document.getElementById("texto_orden").value = action;
        }

   </script>


    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
@endsection
