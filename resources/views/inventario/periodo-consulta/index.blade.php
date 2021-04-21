@extends('layout')

@section('title', 'periodo consulta')
@section('breadcrumb', 'Periodo')
@section('breadcrumb2', 'Periodo')
@section('href_accion', route('periodo-consulta.create'))
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
									<select class="form-control" name="almacen">
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
									<select class="form-control" name="consulta_p">
                                        <option value="1">Compra</option>
                                        <option value="2">Venta</option>
                                        <option value="3">Compra Y Venta</option>
                                    </select>
								</div>
						</div>

                        <div class="form-group row " id="consulta_s" style="display:none;">
							<label class="col-sm-2 col-form-label" >Consulta para Servicio:</label>
								<div class="col-sm-10">
									<select class="form-control" name="consulta_s">
                                        <option>Venta</option>
                                    </select>
								</div>
						</div>
                        
					</form>
                    <button  class="btn btn-primary" id="boton" name="boton">Consultar</button>
                    {{-- <button  class="btn btn-primary" id="boton-d" name="boton-d">Descargar</button> --}}
				</div>
                
			</div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre producto</th>
                                <th>cantidad inicial</th>
                                <th>precio nacional</th>
                                <th>precio extranjero</th>
                            </tr>
                        </thead>
                    <tbody id="tbody">
                        <tr style="display: none">
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
<script>
    $(document).ready(function(e) {
        $('#boton').on('click', function() {
            $('#tbody tr').slice(1).remove();
			$.ajax({
				method: "POST",
				url: "{{ route('ajax_periodo') }}",
				data:$("#formulario").serialize()
			}).done(function(res){
                var arreglo=JSON.parse(res);
                var todo='';
                for(var x=0;x<arreglo.length;x++){
                    todo += '<tr>' +
                            '<td>' + arreglo[x].id + '</td>' +
                            '<td>' + arreglo[x].producto_id + '</td>' +
                            '<td>' + arreglo[x].cantidad_inicial + '</td>' +
                            '<td>' + arreglo[x].precio_nacional + '</td>' +
                            '<td>' + arreglo[x].precio_extranjero + '</td>' +
                            '</tr>';
                }
                $('tbody').append(todo);
                var todo='';
            });
		});

        $('#pdf').on('click', function() {
            $("#formulario").attr("action",'{{ route('periodo_consulta_pdf') }}');
            $("#formulario").attr("method",'POST');
            $("#formulario").submit();
		});



        // $('#print').on('click', function() {
        //     $('#tbody tr').slice(1).remove();
		// 	$.ajax({
		// 		method: "POST",
		// 		url: "{{ route('ajax_periodo') }}",
		// 		data:$("#formulario").serialize()
		// 	}).done(function(res){
        //         var arreglo=JSON.parse(res);
        //         var todo='';
        //         for(var x=0;x<arreglo.length;x++){
        //             todo += '<tr>' +
        //                     '<td>' + arreglo[x].id + '</td>' +
        //                     '<td>' + arreglo[x].producto_id + '</td>' +
        //                     '<td>' + arreglo[x].cantidad_inicial + '</td>' +
        //                     '<td>' + arreglo[x].precio_nacional + '</td>' +
        //                     '<td>' + arreglo[x].precio_extranjero + '</td>' +
        //                     '</tr>';
        //         }
        //         $('tbody').append(todo);
        //         var todo='';
        //     });
		// });

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
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
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
                ]

            });

        });

        function seleccionado(){
            var opt = $('#categoria').val();
            console.log(opt);
            if(opt=="1"){
                $('#consulta_p').show();
                $('#consulta_s').hide();
            }else{
                $('#consulta_p').hide();
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