<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimiento Consulta</title>{{--
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

    <table style="width: 100%;border-collapse:separate;vertical-align: inherit">
        <tr>
            <td style="border: 1px #e5e6e7 solid;border-radius: 10px;width: auto;padding-top: 5px;text-align: center;vertical-align: inherit;" align="center">
                <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 50px;width: 150px;margin-top: 5px;">
            </td>
            {{-- <td style="width: 5px;border: 1px white"></td> --}}
            <td style="width: 33%;border: 1px white"></td>
            {{-- <td style="width: 5px;border: 1px white"></td> --}}
            <td style="border: 1px #e5e6e7 solid;border-radius: 10px;width: auto;margin-top: -10px;text-align: center;" align="center">
                {{-- <div style="height: 50px;width: 165px;border: 1px white solid;margin-right: -5px;margin-top: -15px;padding-right: -45px"   > --}}
                {{-- <center> --}}
                    <span style="margin: 5px;font-weight: 250;"> R.U.C {{$empresa->ruc}}</span><br>
                    <span style="margin: 5px;font-size: 15px;font-weight: 500;" >CONSULTA DE MOVIMIENTOS</span><br>
                    <span style="margin: 5px;font-size: 10px;" >Del: {{$fecha_inicio}}</span><br>
                    <span style="margin: 5px;font-size: 10px;" >Al: {{$fecha_final}}</span>
                {{-- </center> --}}
                {{-- </div> --}}
            </td>
        </tr>
    </table>
    @if(isset($kardex_entrada))
    <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
        <thead>
            <tr>
                <th colspan="11" style="font-weight: bolder;">Compra</th>
            </tr>
            
            <tr>
                <th >Fecha</th>
                <th >Nr. Doc</th>
                <th >Proveedor</th>
                <th >R.U.C</th>
                <th >Doc. Prov.</th>
                <th >Sub Total ({{$moneda_nac->simbolo}}) </th>
                <th >I.G.V ({{$moneda_nac->simbolo}})</th>
                <th >Importe total ({{$moneda_nac->simbolo}})</th>
                <th >Sub Total ({{$moneda_ex->simbolo}})</th>
                <th >I.G.V ({{$moneda_ex->simbolo}})</th>
                <th >Importe total ({{$moneda_ex->simbolo}})</th>
            </tr>
        </thead>
        <tbody  >
            @foreach($kardex_entrada as $kardex_entradas)
            <tr>
                <td>{{$kardex_entradas->fecha_compra}}</td>
                <td>{{$kardex_entradas->codigo_guia}}</td>
                <td>{{$kardex_entradas->provedor->empresa}}</td>
                <td>{{$kardex_entradas->provedor->ruc}}</td>
                <td>{{$kardex_entradas->factura}}</td>
                {{-- PRECIO NACIONAL --}}
                <td align="right"> {{round($sub_tot_nac = $kardex_entradas->precio_nacional_total,2)}}</td>
                <td align="right"> {{round($igv_uni_nac = ($sub_tot_nac*($igv->igv_total/100)),2)}}</td>
                <td align="right"> {{round($sub_tot_nac+ $igv_uni_nac,2)}}</td>
                {{-- PRECIO EXTRANJERO --}}
                <td align="right">{{$sub_uni_ext = round($kardex_entradas->precio_extranjero_total,2)}}</td>
                <td align="right">{{$igv_uni_ext = round(($sub_uni_ext*($igv->igv_total/100)),2) }}</td>
                <td align="right">{{round($sub_uni_ext+ $igv_uni_ext,2)}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                {{-- PRECIO NACIONAL --}}
                <td align="right">{{round($sub_tot_nac = $kardex_entrada->sum('precio_nacional_total'),2)}}</td>
                <td align="right">{{round($igv_sub_nac = ($sub_tot_nac*($igv->igv_total/100)),2)}}</td>
                <td align="right">{{round($sub_tot_nac+$igv_sub_nac,2)}}</td>
                {{-- PRECIO EXTRANJERO --}}
                <td align="right">{{round($sub_tot_ext = $kardex_entrada->sum('precio_extranjero_total'),2)}}</td>
                <td align="right">{{round($igv_sub_ext = ($sub_tot_ext*($igv->igv_total/100)),2)}}</td>
                <td align="right">{{round($sub_tot_ext+$igv_sub_ext,2)}}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <br>
    @endif
    {{-- BOLETA Y FACTURA --}}
    @if(isset($data_extra_f) || isset($data_extra_b))
        <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
            <thead>
                <tr>
                    @if($categoria == "1")
                    <th colspan="7"> Venta Productos</th>
                    @elseif($categoria == "2")
                        <th colspan="7"> Venta Servicios</th>
                    @endif
                </tr>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Nr. Doc</th>
                    <th>Cantidad</th>
                    <th>Tipo de Cambio</th>
                    <th>Total {{$moneda_nac->simbolo}} </th>
                    <th>Total {{$moneda_ex->simbolo}} </th>
                </tr>
            </thead>
            <div style="display: none">
                {{ $fac_t_n = 0 }}
                {{ $fac_t_x = 0 }}
                {{ $bol_t_n = 0 }}
                {{ $bol_t_x = 0 }}
            </div>
            @if(isset($data_extra_f))
                <tbody>
                    @foreach($data_extra_f as $data)
                    <tr>
                        <td style="display: none">{{$fac_t_n += $data['precio_nac']*$data['cantidad']}} {{$fac_t_x += $data['precio_ex']*$data['cantidad']}}</td>
                        <td>{{$data['id']}}</td>
                        <td>{{$data['tipo']}}</td>
                        <td>{{$data['codigo_guia']}}</td>
                        <td>{{$data['cantidad']}}</td>
                        <td>{{$data['cambio']}}</td>
                        <td>{{$data['precio_nac']*$data['cantidad']}}</td>
                        <td>{{$data['precio_ex']*$data['cantidad']}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="text-align: right;font-weight: 500;">Total:</td>
                        <td>{{number_format($fac_t_n++,2)}}</td>
                        <td>{{number_format($fac_t_x++,2)}}</td>
                    </tr>
                </tbody>
            @endif
            <tbody>
                <tr>
                    <td colspan="7"></td>
                </tr>
            </tbody>
            @if(isset($data_extra_b))
                <tbody>
                    @foreach($data_extra_b as $data)
                    <tr>
                        <td style="display: none">{{$bol_t_n += $data['precio_nac']*$data['cantidad']}}{{$bol_t_x += $data['precio_ex']*$data['cantidad']}}</td>
                        <td>{{$data['id']}}</td>
                        <td>{{$data['tipo']}}</td>
                        <td>{{$data['codigo_guia']}}</td>
                        <td>{{$data['cantidad']}}</td>
                        <td>{{$data['cambio']}}</td>
                        <td>{{$data['precio_nac']*$data['cantidad']}}</td>
                        <td>{{$data['precio_ex']*$data['cantidad']}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="5" style="text-align: right;font-weight: 500;">Total:</td>
                    <td>{{number_format($bol_t_n++,2)}}</td>
                    <td>{{number_format($bol_t_x++,2)}}</td>
                </tr>
            @endif
        </table>
        <br>
    @endif
{{-- @endif --}}
<style>
    *{font-size: 12px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
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
<style type="text/css">
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-top: 1px solid #e7eaec;
    line-height: 1.42857;
    padding: 8px;
    vertical-align: top;
}
.table > thead > tr > th {
    border-bottom: 1px solid #DDDDDD;
    vertical-align: bottom;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 1px solid #e7e7e7;
}
.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
    background-color: #F5F5F6;
    border-bottom-width: 1px;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
th {
    text-align: inherit;
}
*, ::after, ::before {
    box-sizing: border-box;
}
user agent stylesheet
th {
    display: table-cell;
    vertical-align: inherit;
    font-weight: bold;
    text-align: -internal-center;
}
Style Attribute {
    text-align: center;
}
table {
    border-collapse: collapse;
}
user agent stylesheet
table {
    border-collapse: separate;
    text-indent: initial;
    border-spacing: 2px;
}
</style>