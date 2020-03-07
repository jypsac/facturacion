@extends('layout')

@section('title', 'Cotizacion Ver')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacion')
@section('href_accion', route('cotizacion.index'))
@section('value_accion', 'Atras')

@section('content')

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-4 text-left" align="left">
                                    
                                    <address class="col-sm-4" align="left">
                                        <!-- <h5>De:</h5>
                                        <i class=" fa fa-user">:</i><strong > {{$empresa->nombre}}</strong><br>
                                        <i class=" fa fa-building">:</i> <br>
                                        <i class="fa fa-phone">:</i>  --> 
                                        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                                    </address>
                                </div> 
                                <div class="col-sm-4">
                                </div> 

                                <div class="col-sm-3 ">
                                    <h4>{{$empresa->nombre}}</h4>
                                    <h4>{{$empresa->ruc}}</h4>   
                                    <h4>{{$empresa->calle}}</h4>   
                                    <h4 class="text-navy">Cotizacion N°: 000{{$cotizacion->id}}</h4>
                                    
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-7" align="center">
                                    <div class="form-control"><h3>Contanto Cliente</h3>
                                        <div align="left">
                                            <strong>Nombre:</strong> &nbsp;{{$cotizacion->cliente->nombre}}<br>
                                            <strong>Ruc/DNI:</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Fecha:</strong> &nbsp;{{$cotizacion->created_at}}<br>
                                            <strong>Direccion:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                            <strong>Telefono:</strong>&nbsp; {{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Celular:</strong>&nbsp; {{$cotizacion->cliente->celular}}<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5" align="center">
                                    <div class="form-control"><h3>Condiciones Generales</h3>
                                        <div align="left">
                                            <strong>Precios:</strong> &nbsp;{{$cotizacion->id }}<br>
                                            <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}<br>
                                            <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
                                            <strong>Plazo Entrega:</strong> &nbsp;{{$cotizacion->id }}<br>
                                            <strong>Garantia:</strong> &nbsp;{{$cotizacion->id }}<br>


                                        </div>
                                    </div>
                                </div>
                               
    
                            </div><br>
                            <div class="row">
                                <div class="col-sm-12" >
                                <h4>Observacion:</h4>
                                {{$cotizacion->observacion }}
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>S/.</th>
                                        <th style="background: #f3f3f4">Precio Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($cotizacion_registro as $cotizacion_registros)
                                    <tr>
                                        <td>{{$cotizacion_registros->cantidad}}</td>
                                        <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                        <td>{{$cotizacion_registros->producto->nombre}}</td>
                                        <td>S/.{{$cotizacion_registros->producto->precio}}</td>
                                        <td style="background: #f3f3f4">S/.{{$cotizacion_registros->producto->precio * $cotizacion_registros->cantidad}}</td>
                                    </tr>
                                      @endforeach 
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                           
                            

                           
                                
                        </div>
                </div>
            </div>
        </div>
       
<style type="text/css">
    .form-control{border-radius: 10px; height: 150px;
}
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
