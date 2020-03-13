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
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
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

                            {{--  --}}
                              <div class="row">
                                
                                <div class="col-sm-1">
                                    Cantidad <br>
                                     <table class="table ">

                                        @foreach($cotizacion_registro as $cotizacion_registros)
                                        <tr><td>{{$cotizacion_registros->cantidad}}</td></tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-sm-2">
                                    Codigo <br>
                                    <table class="table ">
                                            @foreach($cotizacion_registro as $cotizacion_registros)
                                            <tr><td>{{$cotizacion_registros->producto->codigo_producto}}</td></tr>
                                            @endforeach
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    Descripcion <br>
                                             <table class="table ">
                                            @foreach($cotizacion_registro as $cotizacion_registros)
                                            <tr><td>{{$cotizacion_registros->producto->nombre}}</td></tr>@endforeach
                                            </table>
                                </div>
                                <div class="col-sm-1">
                                    S/. <br>
                                             <table class="table ">
                                            @foreach($array as $arrays)
                                            <tr><td>S/.{{$arrays}}</td></tr>
                                             @endforeach
                                            </table>
                                </div>
                                <div class="col-sm-2">
                                    Precio Total
                                </div>
                               
                                
                            </div>

                            {{--  --}}


                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Codigo</th>
                                        <th >Descripcion</th>
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
                                        <span hidden="hidden">
                                             @foreach($array as $arrays)
                                                {{$arraysa=$arrays}}
                                             @endforeach
                                        </span>
                                        <td>S/.{{$cotizacion_registros->producto->precio * $arraysa}}</td>

                                        <td style="background: #f3f3f4">S/.{{$cotizacion_registros->producto->precio * $cotizacion_registros->cantidad}}</td>
                                        <span  hidden="hidden">{{$sum=$sum+$cotizacion_registros->producto->precio * $cotizacion_registros->cantidad}}</span>
                                        
                                    </tr>

                                      @endforeach
                                        
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">Sub Total</td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                            S/.{{$sum}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #f3f3f4;">IGV</td>
                                        <td style="background: #f3f3f4;">
                                            S/.{{$igv_p=$sum*$igv->igv_total/100}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">Total</td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                            S/.{{$sum+$igv_p}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                           
                            

                        <footer style="padding-top: 150px">
                       <div class="row">    
                            <div class="col-sm-6" align="left">
                               
    

                            <h3>Centro de Atencion:</h3>
                            <table>
                                    <tr>
                                        <td style="width: 70px">Telefono</td><td>:</td><td>&nbsp;{{$cotizacion->personal->telefono}}</td>
                                    <tr>
                                        <td style="width: 70px">Celular</td><td>:</td><td>&nbsp;{{$cotizacion->personal->celular}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 70px">Email</td><td>:</td><td>&nbsp;{{$cotizacion->personal->email}}</td>
                                    </tr>
                                     {{-- <tr>
                                        <td style="width: 70px">Web</td><td>:</td><td>&nbsp;{{$cotizacion->personal->telefono}}</td>
                                    </tr> --}}
                                </table>
                                
                            </div>
                            <div class="col-sm-6" align="center">

                                <hr width="200" style="color:black">
                                <p> {{$cotizacion->personal->nombres}} {{$cotizacion->personal->apellidos}} <br> <strong>{{$cotizacion->personal->profesion}}</strong>  </p>
                            </div>
                       </div>
                        </footer>
                             
                        </div>
                </div>
            </div>
        </div>
        
       
<style type="text/css">
    .form-control{border-radius: 10px; height: 150px;}
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
