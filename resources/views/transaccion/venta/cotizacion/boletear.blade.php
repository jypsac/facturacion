 @extends('layout')

 @section('title', 'Boletear Cotizacion')
 @section('breadcrumb', 'Boletear')
 @section('breadcrumb2', 'Boletear')
 @section('href_accion', route('cotizacion.show',$cotizacion->id))
 @section('value_accion', 'Atras')

 @section('content')
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <head>
    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });


        });
    </script>
</head>
<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{route('cotizacion.boletear_store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
     @csrf
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
                         <div class="form-control ruc" style="height: 125px">
                             <center>
                                 <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                 <h2>BOLETA ELECTRONICA</h2>
                                 <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="hidden">
                                 <p>{{$cod_bol}}</p>
                                 <input type="text" value="{{$cotizacion->comisionista_id}}" name="id_comisionista" hidden="hidden">
                             </center>
                         </div>
                     </div>
                 </div><br>
                 <table class="table ">
                     <thead>
                         <tr>
                             <td style="width: 170px"><b>Razon Social</b></td>
                             <td style="width: 3px">:</td>
                             <td style="width: 200px" colspan="4">
                                 <input type="text" class="form-control" value="{{$cotizacion->cliente->nombre}}" readonly="readonly" >
                             </td>
                             <td style="width: 140px"><b>RUC</b></td>
                             <td style="width: 3px">:</td>
                             <td>
                                 <input type="text" class="form-control" value="{{$cotizacion->cliente->numero_documento}}"  readonly="readonly">
                             </td>
                         </tr>
                         <tr>
                             <td><b>Direccion</b></td>
                             <td style="width: 3px">:</td>
                             <td colspan="4"><input type="text" class="form-control" value="{{$cotizacion->cliente->direccion}}" readonly="readonly">
                                 <td><b>Orden de Compra</b></td>
                                 <td>:</td>
                                 <td><input type="text" class="form-control" value="0" name="orden_compra"></td>
                             </tr>
                             <tr>
                                 <td><b>Condiciones de Pago</b></td>
                                 <td style="width: 3px">:</td>
                                 @if($cotizacion->forma_pago_id == 1)
                                    <td colspan="4"><input type="text" class="form-control" value="{{$cotizacion->forma_pago->nombre }}" readonly="readonly"></td>
                                @else
                                    <td colspan="2"><input type="text" class="form-control" value="{{$cotizacion->forma_pago->nombre }}" readonly="readonly"></td>
                                    <td colspan="2"><button  type="button" class='cuota_modal btn btn-info' id="cuota_modal" onclick="most_tot()"  data-toggle="modal" data-target="#cuotas_modal">Cuotas</button></td>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert"   id="alert_campos" style="display: none">
                                              <strong style="font-size:11px">Rellenar todos los campos</strong>
                                              <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()" style="padding: 6;">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert"  id="suma_campos" style="display: none" >
                                              <strong style="font-size:11px">La suma de las cuotas exceden el monto total</strong>
                                              <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()" style="padding: 6;">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="row_number">
                                                <div class="pago_modal row">
                                                    <div class="col-sm-1"><label>Fecha:</label></div>
                                                    <div class="col-sm-4">
                                                        <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control" >
                                                    </div>
                                                    <div class="col-sm-1"><label>Monto:</label></div>
                                                    <div class="col-sm-4">
                                                        <div class="input-group mb-3" style="padding-right:15px">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3">{{$cotizacion->moneda->simbolo}}</span>
                                                          </div>
                                                          <input type="text" name="monto_pago[]" id="monto_pago0" class="monto_pago form-control"   >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label ><button type="button"  aria-hidden="true" id="add_pago" class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg" > </i></button></label>
                                                </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @endif
                                 <td><b>Guia Remision</b></td>
                                 <td style="width: 3px">:</td>
                                 <td><input type="text" class="form-control" value="0" name="guia_remision"></td>
                             </tr>
                             <tr>
                                 <td><b>Fecha Emision</b></td>
                                 <td style="width: 3px">:</td>
                                 <td><input type="date" class="form-control" value="{{date("Y-m-d")}}"  readonly="readonly" name=fecha_emision></td>
                                 <td style="width: 180px"><b>Fecha de Vencimiento</b></td>
                                 <td style="width: 3px">:</td>
                                 <td style="width: 200px"><input type="text" class="form-control"  name="fecha_vencimiento" value="{{$cotizacion->fecha_vencimiento }}" readonly="readonly"></td>
                                 <td><b>Tipo Moneda</b></td>
                                 <td style="width: 3px">:</td><td><input type="text" class="form-control" value="{{$cotizacion->moneda->nombre }}" readonly="readonly" > <input type="text" name="tipo_moneda" hidden="hidden" value="{{$cotizacion->moneda->id }}" > </td>

                             </tr>
                         </thead>
                     </table>
                     <br>
                     <div class="table-responsive">
                         <table class="table ">
                             <thead>
                                 <tr>
                                     <th>Codigo Producto</th>
                                     <th>Cantidad</th>
                                     <th>Descripción</th>
                                     <th>Stock</th>
                                     <th>Valor Unitario</th>
                                     <th>Valor Venta </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($productos as $index => $cotizacion_registros)
                                 {{-- @if($validor[$index]==1) --}}
                                 <tr>
                                     <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                     <td>{{$cotizacion_registros->cantidad}}</td>
                                     <td>
                                         {{$cotizacion_registros->producto->nombre}} / {{$cotizacion_registros->producto->descripcion}}
                                         <input type="text" class="form-control col-sm-4" name="numero_serie[{{$index}}]" placeholder="N° Serie">
                                     </td>
                                     <td>{{$array_cantidad[$index]}}</td>
                                     {{-- MODIFICAR ESTA PARTE CON LOGICA DE REPROGRAMACION PARA UN NUEVO PRODUCTO DIRECTAMENTE DESDE KARDEX --}}
                                      <td style="display: none;">
                                        {{$desc_array=$array[$index]-($array_promedio[$index]*$cotizacion_registros->descuento/100)}}
                                        {{$comis_array= $desc_array+($desc_array*($comi/100))}}
                                    </td>
                                    <td>{{$cotizacion->moneda->simbolo}}. {{round(($comis_array)+($comis_array)*($igv->igv_total/100),2)}}</td>
                                    <td>{{$cotizacion->moneda->simbolo}}. {{round($comis_array+($comis_array)*($igv->igv_total/100),2)*$cotizacion_registros->cantidad}}</td>

                                    <td style="display: none">{{$sub_total=$cotizacion->op_gravada}}
                                    </td>
                                 </tr>
                                 {{-- @endif --}}
                                 @endforeach
                                 <tr>
                                     <td colspan="3" rowspan="4">
                                         <div class="row">
                                             <div class="col-lg-2" align="center">
                                                 <img src="https://www.codigos-qr.com/qr/php/qr_img.php?d=https%3A%2F%2Fwww.jypsac.com%2F&s=6&e=m" alt="Generador de Códigos QR Codes" height="150px" />
                                             </div>
                                             <div class="col-lg-10" align="center">
                                                 <h3>
                                                     <?php $v=new CifrasEnLetras() ;
                                                     $letra=($v->convertirEurosEnLetras($sub_total));
                                                     $letra_final = strstr($letra, 'soles',true);
                                                     $end_final=strstr($sub_total, '.');
                                                     ?>
                                                     {{$letra_final}} {{$end_final}}/100 {{$cotizacion->moneda->nombre }}
                                                 </h3>
                                                 Representacion impresa de la Factura electrónica Puede ser <br>consultada en https://cloud.horizontcpe.com/ConsultaComprobanteE/<br> Autorizado mediante la Resolución de intendencia N° <br>0340050001931/SUNAT/SUNAT
                                             </div>
                                         </div>
                                     </td>
                                     <td></td>
                                     <td>Total</td>
                                     <td>
                                         {{$cotizacion->moneda->simbolo}}.{{round($sub_total, 2)}}

                                         <input type="text" name="total" hidden="hidden" value="{{round($sub_total, 2)}}" >

                                     </td>
                                 </tr>
                                 <tr></tr>
                             </tbody>
                         </table>
                     </div>
                     <input type="text" name="name" maxlength="50" hidden="" value="{{$cotizacion->cod_cotizacion}}"  >
                     <input type="text" name="id" maxlength="50" hidden="" value="{{$cotizacion->id}}"  >
                     <input type="text" name="remitente" hidden=""  value="{{$cotizacion->cliente->email}}"  >
                     <div class="row" align="center" >
                        <div class="col-sm-4">
                        </div>
                        @if(auth()->user()->email_creado == 1 )
                        <div class="  col-sm-6 alert alert-info" >
                            <input type="hidden" name="verificacion" value="1" id="">
                            <p style="margin-bottom: 0px">!Al momento de Boletear se le enviará una copia al correo del cliente!</p>
                        </div>
                        @else
                        <div class="  col-sm-6 alert alert-info" >
                            <input type="hidden" name="verificacion" value="0" id="">
                            <p style="margin-bottom: 0px">!Solo se guardará la factura!</p>
                        </div>
                        @endif
                        <div class="col-sm-2" align="center" >
                            <button class="btn btn-primary" id="boton" style="margin-top: 5px" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true">Guardar</i></button>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


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

{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
           { alert(incompleto); }
       else{boton.type = 'button';}
   }
</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script type="text/javascript">
    function most_tot(){
       var monto_0 = document.getElementById("monto_pago0").value;
        if(monto_0.length == 0){
            var total_final = document.getElementById('total').value;
            document.getElementById("monto_pago0").value = total_final;
        }
    }
</script>
{{-- <script type="text/javascript">
    $(document).ready(function() {
    // show the alert
    setTimeout(function() {
        $(".alert").alert('close');
    }, 2000);
});
</script> --}}
<script>
        var total = document.getElementById('total').value;
        var x = 1;
        $(".add_pago").on('click', function () {
        var total = document.getElementById('total').value;
        var data = `
        <div class="delete_modal${x} row">
        <div class="col-sm-1"><label>Fecha:</label></div>
        <div class="col-sm-4">
            <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" >
        </div>
        <div class="col-sm-1"><label>Monto:</label></div>
        <div class="col-sm-4">
            <div class="input-group mb-3" style="padding-right:15px">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">{{$cotizacion->moneda->simbolo}}</span>
              </div>
              <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}"    >
            </div>
        </div>
        <div class="col-sm-2">
            <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
        </div>
        </div>`;
        $('.row_number').append(data);

        var inp_mont = document.getElementsByClassName('monto_pago').length;

       document.getElementById(`monto_pago${x}`).value = (total/inp_mont);

        x++;
        if(inp_mont>6){
            $('.add_pago').attr('disabled');
        }
        var multiplier2 = 100;
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total/inp_mont)
                document.getElementById("monto_pago0").value = Math.round(fin * multiplier2)/ multiplier2; ;
                document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
        }
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
        }else{
            document.getElementById('add_pago').removeAttribute('disabled');
        }
        });
    </script>
    <script type="text/javascript">
        // $(".delete_pago").on('click', function () {
        function eliminar(x){
            $(`.delete_modal${x}`).remove();
            var monto_c = document.getElementsByClassName('monto_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var multiplier2 = 100;

            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var total = document.getElementById('total').value;
                var fin = (total/inp_mont)
                document.getElementById("monto_pago0").value = Math.round(fin * multiplier2)/ multiplier2; ;
                document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
            }else{
                document.getElementById('add_pago').removeAttribute('disabled');
            }
        };
    </script>
    <script>
        $("#boton").on(" click",function(buton){
            var monto_0 = document.getElementById("monto_pago0").value;
            if(monto_0.length == 0){
                var total_final = document.getElementById('total').value;
                document.getElementById("monto_pago0").value = total_final;
            }
          @if($cotizacion->forma_pago_id == 2)
                var total = document.getElementById('total').value;
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                    var sum = 0;
                    for(g = 0; g<inp_mont;g++){
                        var monto1 = monto_c[g].id; //input montopago0
                        var input_text_2 = document.getElementById(`${monto1}`).value; //180
                        var sum = parseFloat(sum) + parseFloat(input_text_2); //suma(180+0) ->180
                    }
                    if(sum != total){
                        document.getElementById('suma_campos').style.display = "flex";
                        document.getElementById('cuota_modal').click();
                        buton.preventDefault();
                    }
                    for (var i = 0; i < inp_mont; i++) {
                        var fecha = monto_fc[i].id;
                        var monto = monto_c[i].id;
                        var input_text = document.getElementById(`${monto}`).value;
                        var date_text = document.getElementById(`${fecha}`).value;
                        if( input_text.length  == 0 || date_text.length  == 0 ){
                            console.log("q");
                            document.getElementById('alert_campos').style.display = "flex";
                            document.getElementById('cuota_modal').click();
                            buton.preventDefault();
                        }else{
                            console.log("b");
                            document.getElementById('boton').click();
                            // buton.preventDefault();
                        }
                    }
            // buton.preventDefault();
            @else
                document.getElementById('boton').click();
            @endif
        });

    </script>
    <script >
        function cerrar_but_rc(){
            document.getElementById('alert_campos').style.display = "none";
        }
        function cerrar_but_mt(){
            document.getElementById('suma_campos').style.display = "none";
        }
    </script>
@endsection