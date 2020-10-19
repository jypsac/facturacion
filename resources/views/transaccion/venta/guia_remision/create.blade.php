
@extends('layout')

@section('title', 'Guia Remision Agregar')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('href_accion', route('guia_remision.index'))
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
<form action="{{route('guia_remision.store')}}"  enctype="multipart/form-data" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        <div class="col-sm-4 text-left" align="left">

                            <address class="col-sm-4" align="left">

                                <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                            </address>
                        </div>
                        <div class="col-sm-4">
                        </div>

                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                                    <h5>{{$codigo_guia}} <input type="text" name="almacen" value="{{$almacen}}" hidden="hidden"> </h5>
                                </center>

                            </div>
                        </div>
                    </div><br>
                    {{--  Cabecera --}}
                    <div class="row">
                        <div class="col-sm-6" >
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Cliente:</label>
                                <div class="col-sm-10">
                                    <input list="browsersc1" class="form-control m-b" name="cliente" required value="{{ old('nombre')}}" autocomplete="off">
                                    <datalist id="browsersc1" >
                                        @foreach($clientes as $cliente)
                                        <option id="{{$cliente->id}}">{{$cliente->numero_documento}} - {{$cliente->nombre}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" >
                            <div class="row">
                                <label class="col-sm-2 col-form-label">F.Emision:</label>
                                <div class="col-sm-3">
                                    <input type="text" style="font-size: 12px" name="fecha_emision" class="form-control" value="{{date("Y/m/d")}}" readonly="readonly">
                                </div>
                                <label class="col-sm-2 col-form-label">F.Entrega:</label>
                                <div class="col-sm-5">
                                    <input type="date" name="fecha_entrega" class="form-control" required="required"  >
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12" >
                            <div class="row">
                                <label class="col-sm-1">Vehiculo:</label>
                                <div class="col-sm-5">
                                 <input list="browsersc" class="form-control m-b" name="vehiculo" autocomplete="off">
                                 <datalist id="browsersc" >
                                    @foreach($vehiculo as $vehiculos)
                                    <option id="{{$vehiculos->id}}">{{$vehiculos->placa}} /{{$vehiculos->marca}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <label class="col-sm-1">Conductor:</label>
                            <div class="col-sm-5">
                             <input type="text" name="conductor" class="form-control"  value="0" >
                         </div>
                     </div>
                 </div>
                 <div class="col-sm-12" >
                    <div class="row">
                        <label class="col-sm-1">Motivo Traslado:</label>
                        <div class="col-sm-5">
                            <select name="motivo_traslado"  class="form-control m-b">
                                @foreach($motivo_traslado as $motivo_traslad)

                                <option id="{{$motivo_traslad->id}}">{{$motivo_traslad->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-1">Observaciones:</label>
                        <div class="col-sm-5">
                         <textarea name="observacion" class="form-control"   ></textarea>
                     </div>
                 </div>
             </div>
         </div>
         {{-- Fin Cabecera --}}
         {{-- Tabla Mostrito --}}
         <table   cellspacing="0" class="table table-striped ">
            <thead>
                <tr>
                    <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                    <th style="width: 600px;font-size: 13px">Articulo</th>
                    <th style="width: 100px;font-size: 13px">Stock</th>
                    <th style="width: 100px;font-size: 13px">Cantidad</th>
                    <th style="width: 500px;font-size: 13px">Numeros Series</th>
                    <th style="width: 100px;font-size: 13px">peso</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type='checkbox' class="case">
                    </td>
                    <td>
                        <input list="browsers2" class="form-control " name="articulo[]" class="monto0 form-control" required id='articulo' onkeyup="calcular(this,0)" onclick="Clear(this);" autocomplete="off">
                        <datalist id="browsers2" >
                            @foreach($productos as $index => $producto)
                            <option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$producto->peso}} 0 {{$array_cantidad[$index]}}">
                                @endforeach
                            </datalist>

                        </td>
                        <td>
                            <input type='text' id='stock0' readonly="readonly" name='stock[]' class="form-control" required  autocomplete="off"/>
                        </td>
                        <td>
                            <input type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"   required  autocomplete="off" />
                        </td>
                        <td>
                            <textarea name="series[]" id="series0" class="form-control" placeholder="escanear N/S"></textarea>
                        </td>
                        <td>
                            <input id='peso0' name='peso[]' type="text" class="form-control" value="0" readonly="readonly">
                        </td>

                        <span id="spTotal"></span>
                    </tr>

                </tbody><br>

            </table>

            <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
            <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
            {{-- <a onclick="print()"><button class="btn btn-warning float-right" ><i class="fa fa-cloud" aria-hidden="true">Imprimir</i></button></a> --}}
            <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp;
            {{-- Fin de Tabla Mostrito --}}




        </div>
    </div>
</div>
</form>

<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;}
</style>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script> <script>
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
        <tr>
        <td>
        <input type='checkbox' class='case'/>
        </td>";
        <td>
        <input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onkeyup="calcular(this,${i})" onclick="Clear(this);" autocomplete="off">
        <datalist id="browsers" >
        @foreach($productos as $index => $producto)
        <option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$producto->peso}} 0 {{$array_cantidad[$index]}}">
        @endforeach
        </datalist>
        </td>

        <td>
        <input type='text' id='stock${i}' name='stock[]' readonly="readonly" class="form-control" required  autocomplete="off"/>
        </td>
        <td>
        <input type='text' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control"  required  autocomplete="off"/>
        </td>
        <td>
        <textarea  id='series${i}' name='series[]' class="form-control" placeholder="escanear N/S"></textarea>
        </td>
        <td>
        <input id='peso${i}' name='peso[]' type="text" class="form-control" value="0"  readonly="readonly">
        </td>


        </tr>`;
        $('table').append(data);
        i++;
    });
</script>



<script>
    function reverseString(str) {
        return str.split("").reverse().join("");;
    }

    function calcular(input,a)
    {
        var id = input.id;
        var caracteres = input.value;
        var caracteres_reverse=reverseString(caracteres);
        var cadena=input.value;
        var separador=" ";
        var seprador_total= " / ";
        var id=cadena.split(separador,1);
            //revirtiendo la cadena
            var reverse=reverseString(caracteres);//devuelve toda la cadena articulo al reves
            //para precio
            var precio_v_r=reverse.split(separador,1); //devuelve el precio en objeto al revez
            var precio_r=precio_v_r[0];//obtiene el precio del objeto [0] al revez
            var precio_v =reverseString(precio_v_r[0]);//convierte el precio al revez a la normalidad

            var caracteres_space=caracteres_reverse.replace(precio_r,"");//obtiene la cadena articulo sin precio,pero con un espacio en blanco
            var reverse2=caracteres_space.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para descuento
            var descuento_v_r=reverse2.split(separador,1);////obtiene el descuento del objeto [0] al revez
            var descuento_r=descuento_v_r[0];//obtiene el descuento del objeto [0] al revez
            var descuento_v =reverseString(descuento_v_r[0]);//convierte el descuento al revez a la normalidad

            var caracteres_space_2=reverse2.replace(descuento_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
            var reverse3=caracteres_space_2.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para stock
            var stock_v_r=reverse3.split(separador,1);
            var stock_r=stock_v_r[0];
            var stock_v =reverseString(stock_v_r[0]);

            var caracteres_space_3=reverse3.replace(stock_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
            var reverse4=caracteres_space_3.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
            //para promedio_original
            var prom_v_r=reverse4.split(separador,1);
            var prom_r=prom_v_r[0];
            var prom_v =reverseString(prom_v_r[0]);

            var peso=prom_v+" "+stock_v;
            console.log("el promedio original es: "+prom_v);
            console.log("el strock es: "+stock_v+"-------------")

            document.getElementById(`stock${a}`).value = precio_v;
            document.getElementById(`peso${a}`).value = peso;




        }
    </script>

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });
            $('#sub_total').val(total_t);

            var igv_valor={{$igv->renta}};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv=parseFloat(subtotal)*igv_valor/100;
            var end=parseFloat(igv)+parseFloat(subtotal);

            // console.log(typeof igv);
            // console.log(typeof end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;
        });
    </script>

    <script>
        function select_all() {
            $('input[class=case]:checkbox').each(function () {
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function Clear(elem)
        {
            elem.value='';
        }
    </script>

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <style type="text/css">
        .a{color: red}
    </style>



    @endsection
