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

                    <tbody>
                        <tr >
                            <td  style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
                                <center><strong style="align-content: center;margin: 5px">Domicilio De Partida </strong></center><br>
                                &nbsp;{{$guia_remision->almacen->direccion}}<br>
                            </td>
                            <th style="width: 2%;border-color: white"></th>
                            <td  style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
                                <center><strong style="align-content: center;margin: 5px">Domicilio De Llegada </strong></center><br>
                                {{$guia_remision->cliente->direccion}} <br>
                            </td>
                        </tr>
                    </tbody>
                    <tbody >
                        <tr >
                            <td  style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
                                <center><strong style="align-content: center;margin: 5px">Destinario</strong></center><br>
                                <strong>señor(es) :</strong>&nbsp;{{$guia_remision->cliente->nombre}}<br>
                                <strong>R.U.C / DNI :</strong>&nbsp; {{$guia_remision->cliente->numero_documento}}<br>
                                <strong>Fecha Emision :</strong>&nbsp;{{$guia_remision->fecha_emision}} <br>
                                <strong>Fecha Traslado :</strong>&nbsp;{{$guia_remision->fecha_entrega}} <br>
                            </td>
                            <th style="width: 2%;border-color: white"></th>
                            <td  style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
                                <center><strong style="align-content: center;margin: 5px">Unidad de Transporte/Conductor</strong></center><br>
                                 @if(isset($guia_remision->vehiculo_id))
                            <p>
                                <b>Placa del Vehiculo : </b>{{$guia_remision->vehiculo->placa}}<br>
                                <b>Marca del Vehiculo : </b>{{$guia_remision->vehiculo->marca}}<br>
                                <b>Conductor : </b>{{$guia_remision->personal->nombres}}
                            </p>
                            @elseif(isset($guia_remision->vehiculo_publico))
                             <p>
                                <b>Empresa:</b> {{$guia_remision->vehiculo_publicos->nombre}}<br>
                                <b>Ruc: </b> {{$guia_remision->vehiculo_publicos->ruc}}<br>
                                <b>Nota:</b>Esta Empresa es Publica

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
                            </td>
                        </tr>
                    </tbody>

                </table>

                <table class="table " style="text-align: left;border-top: 0px" >
                    <thead style="text-align: left;">
                       <tr align="left" style="text-align: left;font-weight: bold;border-top-width:  0px ">
                        <th>Codigo Producto </th>
                        <th>Marca / Descripcion</th>
                        <th>Unid.Medida</th>
                        <th>Cantidad</th>
                        <th>Peso</th>
                    </tr>

                </thead>
                <tbody>
                 @foreach($guia_registro as $guia_registros)
                 <tr style="border-bottom-width:   0px white ">
                    <td>{{$guia_registros->id}}</td>
                    <td>{{$guia_registros->producto->marcas_i_producto->nombre}} / {{$guia_registros->producto->nombre}} N/S: {{$guia_registros->numero_serie}}</td>
                    <td>{{$guia_registros->producto->unidad_i_producto->medida}}</td>
                    <td>{{$guia_registros->cantidad}}</td>
                    <td>{{$guia_registros->producto->peso}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="height: 150px"></div>
        <table style="width: 100%;border-collapse:separate;">
            <tbody>
                <tr >
                    <td  style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
                        <center><strong style="align-content: center;margin: 5px">Observacion </strong></center><br>
                        &nbsp;{{$guia_remision->observacion}}<br>

                    </td>
                    <th style="width: 2%;border-color: white"></th>
                    <td  style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
                        <center><strong style="align-content: center;margin: 5px">Motivo de Traslado</strong></center><br>{{$guia_remision->motivo_traslado}}<br>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <!-- Fin Totales de Productos -->

        <table style="border-collapse: separate;">
            <tr>
             <th style="width: 2%;border-color: white"></th>
             @foreach($banco as $bancos)
             @if($banco_count==3)
             <th width="33%" style="border: 1px #e5e6e7 solid;border-radius: 8px;">
                @elseif($banco_count==2)
                <th width="50%"style="border: 1px #e5e6e7 solid;border-radius: 8px;">
                    @elseif($banco_count==1)
                    <th width="100%"style="border: 1px #e5e6e7 solid;border-radius: 8px;">
                        @else
                        <th width="20%"style="border: 1px #e5e6e7 solid;border-radius: 8px;">
                            @endif
                            <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="height: 30px;"><br>
                            <span style="font-size: 11px"><strong> {{$bancos->tipo_cuenta}}</strong></span>
                            <br>
                            <span style="font-size: 12px">
                              S/: {{$bancos->numero_soles}}
                              <br>
                              $: {{$bancos->numero_dolares}}<br>
                          </span>
                      </p>
                  </th>
                  <th style="width: 2%;border-color: white"></th>
                  @endforeach
              </tr>
          </table>
          <div style="height: 100px"></div>
          <table style="border:  0px solid white">
            <tr style="border:  0px solid white">
                <td>
                    <p><u>centro de Atencion : </u></p>
                    Telefono : {{$guia_remision->user_personal->personal->telefono }}<br>
                    Celular : {{$guia_remision->user_personal->personal->celular }}<br>
                    Email : {{$guia_remision->user_personal->personal->email }}<br>
                    Web : {{$empresa->pagina_web}} <br>
                </td>
                <td >
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr>
                    <center>{{$guia_remision->user_personal->personal->nombres }}</center>
                </td>
            </tr>
        </table>

    </div>
</div>
</div>

</div>

<style type="text/css">
    .form-control{border-radius: 10px; height: auto;}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

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

