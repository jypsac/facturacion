    
 @extends('layout')

@section('title', 'Boleta Ver')
@section('breadcrumb', 'Facturacion/Boleta')
@section('breadcrumb2', 'Facturacion/Boleta')
@section('href_accion', route('facturacion.index'))
@section('value_accion', 'Atras')

@section('content')

 <div class="wrapper wrapper-content animated fadeInRight">
    
            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                            <div class="row">
                                <div class="col-sm-4 text-left" align="left">
                                    
                                    <address class="col-sm-4" align="left">
                                        
                                        <img src="{{asset('img/logos/logo.png')}}" alt="" width="300px">
                                    </address>
                                </div>
                                <div class="col-sm-4">
                                </div> 

                                <div class="col-sm-4 ">
                                    <div class="form-control" style="height: 125px">
                                        <center>
                                            <h3 style="padding-top:10px ">RUC : 202020202</h3>
                                            <h2>BOLETA ELECTRONICA</h2>   
                                            <h5>BO11-0001213</h5>   
                                        </center>
                                    
                                    </div>
                                </div>
                            </div><br>

                            <table class="table ">
                                    <thead>

                                <tr>
    <td style="width: 170px"><b>Nombre</b></td><td style="width: 3px">:</td><td style="width: 500px">Julio Flores</td>
    <td style="width: 140px"><b>DNI</b></td><td style="width: 3px">:</td><td >98998798</td>
                                </tr>
                                <tr>
    <td><b>Direccion</b></td><td style="width: 3px">:</td><td>av jaja .com</td><td></td><td></td><td></td>
                                </tr>
                                <tr>
    <td><b>Fecha Emision</b></td><td style="width: 3px">:</td><td>14/02/2020</td>
    <td><b>Tipo Moneda</b></td><td style="width: 3px">:</td><td>Soles</td>
                                </tr>
                                <tr>
     <td><b>Fecha de Vencimiento</b></td><td style="width: 3px">:</td><td>12/04/3020</td>
     <td><b>Guia Remision</b></td><td style="width: 3px">:</td><td>xd</td>
                                </tr>
                                    </thead>
                            </table>

                            <br>
                            <div class="row">
                                <div class="col-sm-12" >
                                <h4>Observacion:</h4>
                               
                                </div>
                            </div>

                           

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
