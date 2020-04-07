
<!-- {{$atencion}}
{{$forma_pago_id}}
{{$validez}}
{{$referencia}}
{{$user_id}}
{{$observacion}}
 -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cotizador</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="@yield('vue_js', '#')" defer></script> -->

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
        history.go(-1);
        }
    </SCRIPT>

</head>

{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
	
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
                                    <div class="form-control" style="height: 145px">
                                        <center>
                                            <h3 style="padding-top:10px ">RUC : 202020202</h3>
                                            <h2>COTIZACION ELECTRONICA</h2>   
                                            <h5>CO02-0001</h5>   
                                        </center>
                                    
                                    </div>
                                </div>
                            </div><br>

                            <table class="table ">
                                    <thead>

                                <tr>
    <td style="width: 170px"><b>Razon Social</b></td><td style="width: 3px">:</td><td style="width: 200px">{{$cliente_id}}</td><td></td><td></td><td></td>
    <td style="width: 140px"><b>RUC</b></td><td style="width: 3px">:</td><td >98998798</td>
                                </tr>
                                <tr>
    <td><b>Direccion</b></td><td style="width: 3px">:</td><td>av jaja .com</td><td></td><td></td><td></td>
    <td><b>Orden de Compra</b></td><td>:</td><td>xd</td>
                                </tr>
                                <tr>
    <td><b>Condiciones de Pago</b></td><td style="width: 3px">:</td><td>7 dias</td><td></td><td></td><td></td>
    <td><b>Guia Remision</b></td><td style="width: 3px">:</td><td>xd</td>
                                </tr>
                                 <tr>
    <td><b>Fecha Emision</b></td><td style="width: 3px">:</td><td>14/02/2020</td><td style="width: 180px"><b>Fecha de Vencimiento</b></td><td style="width: 3px">:</td><td style="width: 200px">12/04/3020</td>
    <td><b>Tipo Moneda</b></td><td style="width: 3px">:</td><td>Soles</td>
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
                                    
                                     @foreach ($producto_id as $index => $producto_ids) 
                                      <tr>
                                      	<td>{{$producto_ids}}</td>
                                        <td>{{$cantidad[$index]}}</td>
                                        <td>{{$check_descuento[$index]}}</td>
                                        <td>ss</td>
                                        <td>ss</td>
                                        <td>ss</td>
                                        <td>ss</td>
                                        <td>ss</td>                                        
                                    </tr>
									@endforeach
                                      <tr>
                                        <td colspan="6" rowspan="4">
                                           <!--  <div class="row">
                                                <div class="col-lg-2" align="center">
                                                 <img src="https://www.codigos-qr.com/qr/php/qr_img.php?d=https%3A%2F%2Fwww.jypsac.com%2F&s=6&e=m" alt="Generador de Códigos QR Codes" height="150px" />
                                                </div>
                                                <div class="col-lg-10" align="center">
                                                  Representacion impresa de la Factura electrónica Puede ser <br>consultada en https://cloud.horizontcpe.com/ConsultaComprobanteE/<br> Autorizado mediante la Resolución de intendencia N° <br>0340050001931/SUNAT/SUNAT

                                                </div>
                                            </div> -->

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
 <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    {{-- IMPRIMIR --}}
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>

