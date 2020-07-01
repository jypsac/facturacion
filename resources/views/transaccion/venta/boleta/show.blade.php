 @extends('layout')

@section('title', 'Facturacion Ver')
@section('breadcrumb', 'Facturacion')
@section('breadcrumb2', 'Facturacion')
@section('href_accion', route('facturacion.index'))
@section('value_accion', 'Atras')

@section('content')
@if($facturacion->cotizacion->cliente->documento_identificacion== 'RUC'|| $facturacion->cotizacion->cliente->documento_identificacion== 'Ruc'||
$facturacion->cotizacion->cliente->documento_identificacion== 'ruc')
 <div class="wrapper wrapper-content animated fadeInRight">
    <!-- 
     <form action="{{route('cotizacion.facturar_store')}}"  enctype="multipart/form-data" method="post">
                            @csrf -->
            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                            <div class="row">
                                <div class="col-sm-4 text-left" align="left">
                                    
                                    <address class="col-sm-4" align="left">
                                        
                                        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                                    </address>
                                </div>
                                <div class="col-sm-4">
                                </div> 

                                <div class="col-sm-4 ">
                                    <div class="form-control ruc" style="height: 125px">
                                        <center>
                                            <h3 style="padding-top:10px ">RUC : {{$empresa->ruc}}</h3>
                                            <h2>FACTURA ELECTRONICA</h2>   
                                            <h5> {{$facturacion->codigo_fac}}</h5>   

                                        </center>
                                    
                                    </div>
                                </div>
                            </div><br>

                            <table class="table ">
                                    <thead>

                                <tr>
    <td style="width: 170px"><b>Razon Social</b></td><td style="width: 3px">:</td>
    <td  colspan="4">{{$facturacion->cotizacion->cliente->nombre}}</td>

    <td style="width: 100px"><b>RUC</b></td><td style="width: 3px">:</td><td  style="width: 150px">{{$facturacion->cotizacion->cliente->numero_documento}}</td>
                                </tr>
                                <tr>
    <td><b>Direccion</b></td><td style="width: 3px">:</td>
    <td colspan="4">{{$facturacion->cotizacion->cliente->direccion}}</td>

    <td><b>Orden de Compra</b></td><td>:</td>
    <td> {{$facturacion->orden_compra}}</td>
                                </tr>
                                <tr>
    <td><b>Condiciones de Pago</b></td><td style="width: 3px">:</td>
    <td colspan="4">{{$facturacion->cotizacion->forma_pago->nombre }}</td>

    <td><b>Guia Remision</b></td><td style="width: 3px">:</td>
    <td> {{$facturacion->guia_remision}}</td>
                                </tr>
                                 <tr>
    <td><b>Fecha Emision</b></td><td style="width: 3px">:</td>
    <td>{{$facturacion->cotizacion->fecha_emision}}</td>

    <td ><b>Fecha de Vencimiento</b></td><td style="width: 3px">:</td>
    <td >{{$facturacion->cotizacion->fecha_vencimiento }}</td>

    <td><b>Tipo Moneda</b></td><td style="width: 3px">:</td>
    <td>{{$facturacion->cotizacion->moneda->nombre }}</td>
                                </tr>
                                    </thead>
                            </table> 

                            <br>
                           
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th >Codigo Producto</th>
                                        <th >Cantidad</th>
                                        <th >Unidad</th>
                                        <th >Descripción</th>
                                        <th >Valor Unitario</th>
                                        <th>Dscto.%</th>
                                        <th>Precio Unitario</th>
                                        <th>Valor Venta </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                     
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>                                        
                                    </tr>

                                        
                                      <tr>
                                        <td colspan="6" rowspan="4">
                                            <div class="row">
                                                <div class="col-lg-2" align="center">
                                                 <img src="https://www.codigos-qr.com/qr/php/qr_img.php?d=https%3A%2F%2Fwww.jypsac.com%2F&s=6&e=m" alt="Generador de Códigos QR Codes" height="150px" />
                                                </div>
                                                <div class="col-lg-10" align="center">
                                                  Representacion impresa de la Factura electrónica Puede ser <br>consultada en https://cloud.horizontcpe.com/ConsultaComprobanteE/<br> Autorizado mediante la Resolución de intendencia N° <br>0340050001931/SUNAT/SUNAT

                                                </div>
                                            </div>

                                        </td>
                                       
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">Sub Total</td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                            S/.
                                        </td>

                                    </tr>
                                    <tr>
                                        <!-- <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td> -->
                                        <td style="background: #f3f3f4;">Op. Gravada</td>
                                        <td style="background: #f3f3f4;">
                                            S/.
                                        </td>
                                    </tr>
                                    <tr>
                                       <!--  <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td> -->
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">IGV</td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                            S/.
                                        </td>
                                    </tr>
                                    <tr >
                                        <!-- <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td> -->
                                        <td  style="background: #f3f3f4;">Importe Total</td>
                                        <td  style="background: #f3f3f4;">
                                            S/.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
<!-- 
                             <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp; -->
                        </div>
                </div>
                
            </div>

                        <!-- </form> -->
        </div>
@else

 <div class="wrapper wrapper-content animated fadeInRight">
    <!-- 
     <form action="{{route('cotizacion.facturar_store')}}"  enctype="multipart/form-data" method="post">
                            @csrf -->
            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                            <div class="row">
                                <div class="col-sm-4 text-left" align="left">
                                    
                                    <address class="col-sm-4" align="left">
                                        
                                        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                                    </address>
                                </div>
                                <div class="col-sm-4">
                                </div> 

                                <div class="col-sm-4 ">
                                    <div class="form-control ruc" style="height: 125px">
                                        <center>
                                            <h3 style="padding-top:10px ">RUC : {{$empresa->ruc}}</h3>
                                            <h2>BOLETA ELECTRONICA</h2>   
                                            <h5> {{$facturacion->codigo_fac}}</h5>   

                                        </center>
                                    
                                    </div>
                                </div>
                            </div><br>

                            <table class="table ">
                                    <thead>

                                <tr>
    <td style="width: 170px"><b>Razon Social</b></td><td style="width: 3px">:</td>
    <td  colspan="4">{{$facturacion->cotizacion->cliente->nombre}}</td>

    <td style="width: 100px"><b>{{$facturacion->cotizacion->cliente->documento_identificacion}}</b></td><td style="width: 3px">:</td><td  style="width: 150px">{{$facturacion->cotizacion->cliente->numero_documento}}</td>
                                </tr>
                                <tr>
    <td><b>Direccion</b></td><td style="width: 3px">:</td>
    <td colspan="4">{{$facturacion->cotizacion->cliente->direccion}}</td>

    <td><b>Orden de Compra</b></td><td>:</td>
    <td> {{$facturacion->orden_compra}}</td>
                                </tr>
                                <tr>
    <td><b>Condiciones de Pago</b></td><td style="width: 3px">:</td>
    <td colspan="4">{{$facturacion->cotizacion->forma_pago->nombre }}</td>

    <td><b>Guia Remision</b></td><td style="width: 3px">:</td>
    <td> {{$facturacion->guia_remision}}</td>
                                </tr>
                                 <tr>
    <td><b>Fecha Emision</b></td><td style="width: 3px">:</td>
    <td>{{$facturacion->cotizacion->fecha_emision}}</td>

    <td ><b>Fecha de Vencimiento</b></td><td style="width: 3px">:</td>
    <td >{{$facturacion->cotizacion->fecha_vencimiento }}</td>

    <td><b>Tipo Moneda</b></td><td style="width: 3px">:</td>
    <td>{{$facturacion->cotizacion->moneda->nombre }}</td>
                                </tr>
                                    </thead>
                            </table> 

                            <br>
                           
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th >Codigo Producto</th>
                                        <th >Cantidad</th>
                                        <th >Unidad</th>
                                        <th >Descripción</th>
                                        <th >Valor Unitario</th>
                                        <th>Dscto.%</th>
                                        <th>Precio Unitario</th>
                                        <th>Valor Venta </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                     
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>                                        
                                    </tr>

                                        
                                      <tr>
                                        <td colspan="6" rowspan="4">
                                            <div class="row">
                                                <div class="col-lg-2" align="center">
                                                 <img src="https://www.codigos-qr.com/qr/php/qr_img.php?d=https%3A%2F%2Fwww.jypsac.com%2F&s=6&e=m" alt="Generador de Códigos QR Codes" height="150px" />
                                                </div>
                                                <div class="col-lg-10" align="center">
                                                  Representacion impresa de la Factura electrónica Puede ser <br>consultada en https://cloud.horizontcpe.com/ConsultaComprobanteE/<br> Autorizado mediante la Resolución de intendencia N° <br>0340050001931/SUNAT/SUNAT

                                                </div>
                                            </div>

                                        </td>
                                       
                                       <td  style="background: #f3f3f4;">Importe Total</td>
                                        <td  style="background: #f3f3f4;">
                                            S/.
                                        </td>

                                    </tr>
                                   
                                  
                                  
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
<!-- 
                             <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp; -->
                        </div>
                </div>
                
            </div>

                        <!-- </form> -->
        </div>

@endif

        
       
<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;}
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
