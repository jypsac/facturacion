<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Remision</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
        background-color: #FFFFFF;
        background-image: none;
        border: 1px solid #e5e6e7;
        border-radius: 1px;
        color: inherit;
        display: block;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }
    @page { size: 420mm 297mm landscape; }
</style>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">

                <table style="width: 100%;border-collapse:separate;margin-bottom: -10px;color: #676a6c;">
                    <tr>
                        <td style="width: auto;border-color: white" rowspan="2" valign="top">
                            <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="margin-top: 0px;" width="300px" />
                            <br>
                        </td>
                        <td style="width: 30%; ;border: 1px #e5e6e7 solid;border-radius: 8px;margin-top: 0px" align="right">
                            <center>
                                <h3 style="text-align: center;padding-top:10px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
                                <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >COTIZACION ELECTRONICA</h2><br>
                                <h5 style="text-align: center;margin-bottom: -5px" >{{$guia_remision->cod_guia}}</h5>
                            </center>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                    <tr >
                        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
                            <center><strong style="align-content: center;margin: 5px">Domicilio De Partida </strong></center><br>
                            &nbsp;{{$empresa->calle}}<br>

                        </td>
                        <th style="width: 5%;border-color: white"></th>
                        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
                            <center><strong style="align-content: center;margin: 5px">Domicilio De Llegada </strong></center><br>
                            {{$guia_remision->cliente->direccion}} <br>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                    <tr >
                        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
                            <center><strong style="align-content: center;margin: 5px">Destinario</strong></center><br>
                            <strong>señor(es) :</strong>&nbsp;{{$guia_remision->cliente->nombre}}<br>
                            <strong>R.U.C / DNI :</strong>&nbsp; {{$guia_remision->cliente->numero_documento}}<br>
                            <strong>Fecha Emision :</strong>&nbsp;{{$guia_remision->fecha_emision}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Fecha Traslado :</strong>&nbsp;{{$guia_remision->fecha_entrega}} <br>
                        </td>
                        <th style="width: 5%;border-color: white"></th>
                        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
                            <center><strong style="align-content: center;margin: 5px">Unidad de Transporte/Conductor</strong></center><br>
                             @if(isset($guia_remision->vehiculo_id))
                                    <b>Placa del Vehiculo : </b>{{$guia_remision->vehiculo->placa}}<br>
                                    <b>Marca del Vehiculo : </b>{{$guia_remision->vehiculo->marca}}<br>
                                    <b>Conductor : </b>
                                    @if(isset($guia_remision->conductor_id))
                                    <b>Conductor : </b>{{$guia_remision->personal->nombres}}
                                    @else
                                    <b>Conductor : </b> No Hay Conductor
                                    @endif
                                @else
                                   <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                                    <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                                    @if(isset($guia_remision->conductor_id))
                                    <b>Conductor : </b>{{$guia_remision->personal->nombres}}
                                    @else
                                    <b>Conductor : </b> No Hay Conductor
                                    @endif

                                @endif
                        </td>
                    </tr>
                </table>
                <div class="row" align="center">
                    <div class="col-sm-6" align="center">
                        <div class="form-control"><h3>Destinario</h3>
                            <div align="left" style="font-size: 13px">
                                <p><b>señor(es) :</b> {{$guia_remision->cliente->nombre}} <br>
                                   <b>R.U.C / DNI : </b> {{$guia_remision->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha Emision :</b> {{$guia_remision->fecha_emision}} <br><b>Fecha Traslado :</b> {{$guia_remision->fecha_entrega}} </p>
                               </div>
                           </div>
                       </div>
                       <div class="col-sm-6" align="center">
                        <div class="form-control" ><h3>Unidad de Transporte/Conductor</h3>
                            <div align="left" style="font-size: 13px">
                                @if(isset($guia_remision->vehiculo_id))
                                <p>
                                    <b>Placa del Vehiculo : </b>{{$guia_remision->vehiculo->placa}}<br>
                                    <b>Marca del Vehiculo : </b>{{$guia_remision->vehiculo->marca}}<br>
                                    <b>Conductor : </b>
                                    @if(isset($guia_remision->conductor_id))
                                    <b>Conductor : </b>{{$guia_remision->personal->nombres}}
                                    @else
                                    <b>Conductor : </b> No Hay Conductor
                                    @endif
                                </p>
                                @else
                                <p>
                                    <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                                    <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                                    @if(isset($guia_remision->conductor_id))
                                    <b>Conductor : </b>{{$guia_remision->personal->nombres}}
                                    @else
                                    <b>Conductor : </b> No Hay Conductor
                                    @endif
                                </p>

                                @endif
                            </div>
                        </div>
                    </div>
                </div><br>

                <div class="table-responsive">
                    <table class="table " >
                        <thead>
                            <tr >
                                <th>Codigo Producto </th>
                                <th>Marca / Descripcion</th>
                                <th>N/S</th>
                                <th>Unid.Medida</th>
                                <th>Cantidad</th>
                                <th>Peso</th>
                            </thead>
                            <tbody>
                             @foreach($guia_registro as $guia_registros)
                             <tr>
                                <td>{{$guia_registros->id}}</td>
                                <td>{{$guia_registros->producto->marcas_i_producto->nombre}} / {{$guia_registros->producto->nombre}}</td>
                                <td>{{$guia_registros->numero_serie}}</td>
                                <td>{{$guia_registros->producto->unidad_i_producto->medida}}</td>
                                <td>{{$guia_registros->cantidad}}</td>
                                <td>{{$guia_registros->producto->peso}}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->


                <footer style="padding-top: 120px">
                 <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control"><h3>Observacion:</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{{$guia_remision->observacion}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" ><h3>Motivo de Traslado</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{{$guia_remision->motivo_traslado}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>



            <br>
            <!-- Fin Totales de Productos -->
            <div class="row">
                @foreach($banco as $bancos)
                <div class="col-sm-3 " align="center">
                    <p class="form-control" style="height: 100px">
                      <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 100px;height: 30px;">
                      <br>
                      N° S/. : {{$bancos->numero_soles}}
                      <br>
                      N° $ : {{$bancos->numero_dolares}}<br>

                  </p>
              </div>
              @endforeach

          </div>
          <br>
          <div class="row">
            <div class="col-sm-3">
                <p><u>centro de Atencion : </u></p>
                Telefono : {{$guia_remision->user_personal->personal->telefono }}<br>
                Celular : {{$guia_remision->user_personal->personal->celular }}<br>
                Email : {{$guia_remision->user_personal->personal->email }}<br>
                Web : {{$empresa->pagina_web}}<br>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><br><br>
                <hr>
                <center>{{$guia_remision->user_personal->personal->nombres }}</center>
            </div>

        </div>

    </div>
</div>
</div>

</div>

<style type="text/css">
    .form-control{border-radius: 10px; height: auto;}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
</style>

<style>

    *{font-size: 15px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
    .cero{
        margin-bottom: 0px;

    }
    .table-bordered .blanco {
        border: none;
    }
    .blanco{border: none;
        border: medium transparent;
    }
    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-top-width: 0px;

    }
</style>


</body>
</html>

