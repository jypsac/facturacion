@extends('layout')

@section('title', 'kardex Salida- Ver')
@section('breadcrumb', 'Salida')
@section('breadcrumb2', 'Salida')
@section('href_accion', route('kardex-salida.index') ) 
@section('value_accion', 'Atras')

@section('content')

    

            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox-content p-xl"><div class="row">
	<div class="col-sm-12 text-right">
					 <h4>Guia Entrada</h4>
					 <h4 class="text-navy">GS-000{{$kardex_salidas->id}}</h4>
					 <span>Para:</span>
					 <address>
					     <i class=" fa fa-user">:</i><strong> {{$mi_empresa->nombre}}</strong><br>
					     <i class=" fa fa-building">:</i>{{$mi_empresa->calle}}<br>
					     <i class="fa fa-phone">:</i> {{$mi_empresa->telefono}} / {{$mi_empresa->movil}}
					 </address>
					 <p>
					     <span><strong>Fecha de la factura:</strong> {{$kardex_salidas->created_at}}</span><br/>
					 </p>
    </div>
    </div>
                    	
                    	<div class="form-group row ">
								<label class="col-sm-2 col-form-label" >motivos:</label>
							                    <div class="col-sm-4">
							                     	
							                     	<p class="form-control">{{$kardex_salidas->motivos->nombre}}</p>
							                    </div>

							    <label class="col-sm-2 col-form-label">Informaciones:</label>
												<div class="col-sm-4">
													<p class="form-control">{{$kardex_salidas->informacion}}</p>
							                    </div>
						</div>




					<div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>	
                                    </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($kardex_salidas_registros as $kardex_salidas_registro)
                                    <tr>
                                        <td><strong>{{$kardex_salidas_registro->producto->nombre}}</strong><br>
                                            <small>{{$kardex_salidas_registro->producto->descripcion}}</small>
                                        </td>
                                        <td>{{$kardex_salidas_registro->cantidad}}</td>
                                        
                                    </tr>
                                      @endforeach
                                    </tbody>
                                </table>
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

    
@endsection