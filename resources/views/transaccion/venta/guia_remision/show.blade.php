 @extends('layout')

 @section('title', 'Guia Remision Ver')
 @section('breadcrumb', 'Guia Remision')
 @section('breadcrumb2', 'Guia Remision')
 @section('href_accion', route('guia_remision.index'))
 @section('value_accion', 'Atras')

 @section('content')

 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <div class="ibox-tools">
            <style type="text/css">
                .procesado:before {
                    content: "Procesado";
                }
                .procesado:hover:before {
                    content: "Ver";
                }
            </style>
            <a class="btn btn-success"  href="{{route('guia_remision.print' , $guia_remision->id)}}" target="_blank">Imprimir</a>
        </div>
    </div>
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
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                            <h5>{{$guia_remision->cod_guia}} </h5>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control"><h3>Domicilio De Partida</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{{$empresa->calle}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" ><h3>Domicilio De Llegada</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{{$guia_remision->cliente->direccion}}</p>
                            </div>
                        </div>
                    </div>
                </div>

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
