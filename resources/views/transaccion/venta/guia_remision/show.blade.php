 @extends('layout')

 @section('title', 'Guia Remision Ver')
 @section('breadcrumb', 'Guia Remision')
 @section('breadcrumb2', 'Guia Remision')
 @section('href_accion', route('guia_remision.index'))
 @section('value_accion', 'Atras')

 @section('content')

 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" style="padding-right: 3.1%">
        <div class="row tooltip-demo">
         <div class="col-sm-6">

         </div>

         <div class="col-sm-6" align="right">
            <a href="{{route('pdf_guia' ,$guia_remision->id)}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </a>
         {{--   <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button> --}}



           @if(Auth::user()->email_creado == 1)
                <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                    @csrf
                    <input type="text" hidden="hidden" name="tipo" value="App\Guia_remision"/>
                    <input type="text" hidden="hidden" name="id" value="{{$guia_remision->id}}"/>
                    <input type="text" hidden="hidden" name="redict" value="guia_remision">
                    <input type="text" hidden="hidden" name="cliente" value="{{$guia_remision->cliente->email}}">
                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                </form>
            @endif

           <a class="btn btn-success" href="{{route('guia_remision.print' , $guia_remision->id)}}"target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
           <div id="auto" onclick="divAuto()">
                <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
            </div>
            <div id="div-mostrar">
               <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                @csrf
                 <input type="tel" name="numero"  value="{{$guia_remision->cliente->celular}}"   />
                 <input type="text" name="mensaje" id="texto_orden" hidden="" />
                 <input type="text" hidden="" name="url" value="{{route('pdf_guia' ,$guia_remision->id)}}?archivo=">
                 <input type="text" name="name_sin_cambio" hidden="" value="{{$guia_remision->cod_guia}}" />
                <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
            </form>
            </div>
       </div>
   </div>

</div>
<div class="row">
    <div class="col-lg-12" style="margin-top: -2px">
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
                            <th>Unid.Medida</th>
                            <th>Cantidad</th>
                            <th>Peso</th>
                        </thead>
                        <tbody>
                         @foreach($guia_registro as $guia_registros)
                         <tr>
                            <td>{{$guia_registros->id}}</td>
                            <td>{{$guia_registros->producto->marcas_i_producto->nombre}} / {{$guia_registros->producto->nombre}} N/S: {{$guia_registros->numero_serie}}</td>
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

    @if($banco_count==3)
    <div class="col-sm-4 " align="center">
    <p class="form-control" >

    @elseif($banco_count==2)
    <div class="col-sm-6" align="center">
    <p class="form-control">

    @elseif($banco_count==1)
    <div class="col-sm-12" align="center" style="width: 100px">
    <p class="form-control" style="width: 426px;">

    @else
    <div class="col-sm-3 " align="center">
    <p class="form-control" >
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
{{-- Modal Configuracion --}}
<div class="modal fade" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{route('email.config')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <fieldset >
                                <legend> Agregar Configuracion </legend>
                                {{-- <div> --}}
                                    <div class="panel-body" align="left">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" style="width: 100%;height: 90%;margin-top: 5px; border-radius: 5px" name="email"/>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10" style="flex-wrap: none">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password" id="txtPassword" required="" style="height: 90%;margin-top: 5px; border-radius: 5px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
                                                            <i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">SMPT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="" style="width: 100%;height: 90%;margin-top: 5px; border-radius: 5px">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="110 " style="height: 90%;margin-top: 5px; border-radius: 5px" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Encryption:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="encryp" >
                                                    <option value="">Ninguno</option>
                                                    <option value="SSL">SSL</option>
                                                    <option value="TLS">TLS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                            <div class="col-sm-10">
                                                <input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
                                                <span id="visorArchivo">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma"  src="" width="390px" height="200px" />
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="ancho_firma">
                                                </div>
                                            <label class="col-sm-2 col-form-label" >Alto(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="alto_firma">
                                                </div>
                                        </div>
                                        <br>
                                    </div>
                                </fieldset>
                            </div>
                            <button class="btn btn-primary" type="submit">Grabar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Fin de modal configuracion --}}

<style>
    .form-control{margin-top: 5px; border-radius: 5px}
    p#texto{
        text-align: center;
        color:black;
    }

    input#archivoInput{
        position:absolute;
        top:0px;
        left:0px;
        right:0px;
        bottom:0px;
        width:100%;
        height:100%;
        opacity: 0  ;
    }
</style>
<style>

#auto{
    /*padding: -100px;*/
    /*background: orange;*/
    /*width: 95px;*/
    cursor: pointer;
    /*margin-top: 10px;*/
    /*margin-bottom: 10px;*/
    box-shadow: 0px 0px 1px #000;
    display: inline-block;
}

#auto:hover{
    opacity: .8;
}

#div-mostrar{
    /*width: 50%;*/
    margin: auto;
    height: 0px;
    /*margin-top: -5px*/
    /*background: #000;*/
    /*box-shadow: 10px 10px 3px #D8D8D8;*/
    transition: height .4s;
    color:white;
    text-align: right;
}
#auto:hover{
    opacity: .8;
}
#auto:hover + #div-mostrar{
    height: 50px;
}
    </style>
<script type="text/javascript">
    function mostrarPassword(){
        var cambio = document.getElementById("txtPassword");
        if(cambio.type == "password"){
            cambio.type = "text";
            $('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
            cambio.type = "password";
            $('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    }

</script>
<script type="text/javascript">
    {{-- Fotooos --}}
    function validarExt()
    {
        var archivoInput = document.getElementById('archivoInput');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg|.png|.jfif)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            alert('Asegurese de haber seleccionado una Imagen');
            archivoInput.value = '';
            return false;
        }

        else
                                        {
        //PRevio del PDF
        if (archivoInput.files && archivoInput.files[0])
        {
            var visor = new FileReader();
            visor.onload = function(e)
            {
                document.getElementById('visorArchivo').innerHTML =
                '<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
</script>
<script>
    var clic = 1;
    function divAuto(){
       if(clic==1){
       document.getElementById("div-mostrar").style.height = "50px";
       clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        clic = 1;
       }
    }
</script>



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
