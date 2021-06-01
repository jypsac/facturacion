<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periodo Consulta</title>{{--
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

@if($consulta == "1")
    {{-- KARDEX ENTRADAS --}}
    <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
        <thead>
            <tr>
                <th colspan="8">Periodo Consulta - Compra</th>
            </tr>
            <tr>
                <th colspan="4">
                    Fecha Inicio: {{$fecha_inicio}}
                </th>
                <th colspan="4">
                    {{$empresa->nombre}}
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    Fecha Final: {{$fecha_final}}
                </th>
                <th colspan="4">
                    {{$empresa->ruc}}
                </th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Nr. Doc</th>
                <th>Proveedor</th>
                <th>R.U.C</th>
                <th>Doc. Prov.</th>
                <th>Sub Total</th>
                <th>I.G.V</th>
                <th>Importe total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kardex_entrada as $kardex_entrada)
            <tr>
                <td>{{$kardex_entrada->created_at}}</td>
                <td>{{$kardex_entrada->codigo_guia}}</td>
                <td>{{$kardex_entrada->provedor->empresa}}</td>
                <td>{{$kardex_entrada->provedor->ruc}}</td>
                <td>{{$kardex_entrada->factura}}</td>
                <td>{{$sub_uni = $kardex_entrada->precio_nacional_total}}</td>
                <td>{{$igv_uni = ($sub_uni*($igv->igv_total/100)) }}</td>
                <td>{{$sub_uni+ $igv_uni}}</td>
            </tr>
            @endforeach
            <?php
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td>{{$sub_tot = $kardex_entrada->sum('precio_nacional_total')}}</td>
                <td>{{$igv_sub = ($sub_tot*($igv->igv_total/100))}}</td>
                <td>{{$sub_tot+$igv_sub}}</td>
            </tr>
        </tfoot>
    </table>
@elseif($consulta == "2")
    {{-- BOLETA Y FACTURA --}}
    <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
        <thead>
            <tr>
                <th colspan="8">Periodo Consulta - Compra</th>
            </tr>
            <tr>
                <th colspan="4">
                    Fecha Inicio: {{$fecha_inicio}}
                </th>
                <th colspan="4">
                    {{$empresa->nombre}}
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    Fecha Final: {{$fecha_final}}
                </th>
                <th colspan="4">
                    {{$empresa->ruc}}
                </th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Nr. Doc</th>
                <th>Tipo</th>
                <th>R.U.C</th>
                <th>Doc. Prov.</th>
                <th>Sub Total</th>
                <th>I.G.V</th>
                <th>Importe total</th>
            </tr>
        </thead>
        <div style="display: none">
            {{ $hola = 0 }}
        </div>
        <tbody>
            @foreach($json as $data)
            <tr>
                <td style="display: none">{{$hola += $data['precio']}}</td>
                <td>{{$data['id']}}</td>
                <td>{{$data['codigo_guia']}}</td>
                <td>{{$data['tipo']}}</td>
                <td>{{$data['cantidad']}}</td>
                <td>{{$data['precio']}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            <?php
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td>{{$hola++}}</td>
                {{-- <td>{{$igv_sub = ($sub_tot*($igv->igv_total/100))}}</td> --}}
                {{-- <td>{{$sub_tot+$igv_sub}}</td> --}}

            </tr>
        </tfoot>
    </table>
@else
{{-- KARDEX ENTRADAS --}}
    <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
        <thead>
            <tr>
                <th colspan="8">Periodo Consulta - Compra</th>
            </tr>
            <tr>
                <th colspan="4">
                    Fecha Inicio: {{$fecha_inicio}}
                </th>
                <th colspan="4">
                    {{$empresa->nombre}}
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    Fecha Final: {{$fecha_final}}
                </th>
                <th colspan="4">
                    {{$empresa->ruc}}
                </th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Nr. Doc</th>
                <th>Proveedor</th>
                <th>R.U.C</th>
                <th>Doc. Prov.</th>
                <th>Sub Total</th>
                <th>I.G.V</th>
                <th>Importe total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kardex_entrada as $kardex_entrada)
            <tr>
                <td>{{$kardex_entrada->created_at}}</td>
                <td>{{$kardex_entrada->codigo_guia}}</td>
                <td>{{$kardex_entrada->provedor->empresa}}</td>
                <td>{{$kardex_entrada->provedor->ruc}}</td>
                <td>{{$kardex_entrada->factura}}</td>
                <td>{{$sub_uni = $kardex_entrada->precio_nacional_total}}</td>
                <td>{{$igv_uni = ($sub_uni*($igv->igv_total/100)) }}</td>
                <td>{{$sub_uni+ $igv_uni}}</td>
            </tr>
            @endforeach
            <?php
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td>{{$sub_tot = $kardex_entrada->sum('precio_nacional_total')}}</td>
                <td>{{$igv_sub = ($sub_tot*($igv->igv_total/100))}}</td>
                <td>{{$sub_tot+$igv_sub}}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <br>
    {{-- BOLETA Y FACTURA --}}
    <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
        <thead>
            <tr>
                <th colspan="5">Periodo Consulta - Venta</th>
            </tr>
            <tr>
                <th colspan="2">
                    Fecha Inicio: {{$fecha_inicio}}
                </th>
                <th colspan="3">
                    {{$empresa->nombre}}
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    Fecha Final: {{$fecha_final}}
                </th>
                <th colspan="3">
                    {{$empresa->ruc}}
                </th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Nr. Doc</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <div style="display: none">
            {{ $fac_t = 0 }}
            {{ $bol_t = 0 }}
        </div>
        @if(isset($data_extra_f))
            <tbody>
                @foreach($data_extra_f as $data)
                <tr>
                    <td style="display: none">{{$fac_t += $data['precio']}}</td>
                    <td>{{$data['id']}}</td>
                    <td>{{$data['tipo']}}</td>
                    <td>{{$data['codigo_guia']}}</td>
                    <td>{{$data['cantidad']}}</td>
                    <td>{{$data['precio']}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4"></td>
                <td>{{$fac_t++}}</td>
                {{-- <td>{{$igv_sub = ($sub_tot*($igv->igv_total/100))}}</td> --}}
                {{-- <td>{{$sub_tot+$igv_sub}}</td> --}}

            </tr>
        </tfoot>
        @else

        @endif
        @if(isset($data_extra_b))
            <tbody>
                @foreach($data_extra_b as $data)
                <tr>
                    <td style="display: none">{{$bol_t += $data['precio']}}</td>
                    <td>{{$data['id']}}</td>
                    <td>{{$data['tipo']}}</td>
                    <td>{{$data['codigo_guia']}}</td>
                    <td>{{$data['cantidad']}}</td>
                    <td>{{$data['precio']}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4"></td>
                <td>{{$bol_t++}}</td>
                {{-- <td>{{$igv_sub = ($sub_tot*($igv->igv_total/100))}}</td> --}}
                {{-- <td>{{$sub_tot+$igv_sub}}</td> --}}

            </tr>
        @else
        @endif
        </tfoot>
    </table>
@endif
<style>
    *{font-size: 14px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
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