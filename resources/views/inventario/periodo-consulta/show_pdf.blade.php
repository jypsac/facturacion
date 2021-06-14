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

{{-- @if($consulta == "1")
    KARDEX ENTRADAS --}}

{{-- @else --}}
{{-- KARDEX ENTRADAS --}}
{{-- @if(isset($data_extra_b) or isset($data_extra_f) or isset($kardex_entrada) ) --}}
    @if(isset($productos))
    <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
        <thead>
            <tr>
                <th colspan="4">Periodo Consulta - Compra</th>
            </tr>
            <tr>
                <th colspan="2">
                    Fecha Inicio: {{$fecha_inicio}}
                </th>
                <th colspan="2">
                    {{$empresa->nombre}}
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    Fecha Final: {{$fecha_final}}
                </th>
                <th colspan="2">
                    {{$empresa->ruc}}
                </th>
            </tr>
            <tr>
                <th>Nombre del Producto</th>
                <th>Cantidad inicial</th>
                <th>Precio Nacional ({{$moneda_nac->simbolo}})</th>
                <th>Precio Extranjero ({{$moneda_ex->simbolo}})</th>
            </tr>
        </thead>
        <div style="display: none">
            {{ $cant_ini = 0}}
            {{ $pre_nac = 0 }}
            {{ $pre_ex = 0 }}
        </div>
        <tbody >

            @foreach($productos as $producto)
            <tr>
                <td style="display: none">{{$pre_nac += $producto['precio_nacional']}} {{$pre_ex += $producto['precio_extranjero']}} {{$cant_ini += $producto['cantidad_inicial']}}</td>
                <td>{{$producto['producto']}}</td>
                <td>{{$producto['cantidad_inicial']}}</td>
                <td>{{$producto['precio_nacional']}}</td>
                <td>{{$producto['precio_extranjero']}}</td>
            </tr>
            @endforeach
        </tbody>
        <tbody>
            <tr>
                <td align="right" style="font-weight: 600">Total:</td>
                <td>{{$cant_ini}}</td>
                <td>{{number_format($pre_nac++,2)}}</td>
                <td>{{number_format($pre_ex++,2)}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    @endif
    {{-- BOLETA Y FACTURA --}}
    @if(isset($data_final_fac) || isset($data_final_bol))
        <table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
            <thead>
                <tr>
                    <th colspan="4">Periodo Consulta - Venta</th>
                </tr>
                <tr>
                    <th colspan="2">
                        Fecha Inicio: {{$fecha_inicio}}
                    </th>
                    <th colspan="2">
                        {{$empresa->nombre}}
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        Fecha Final: {{$fecha_final}}
                    </th>
                    <th colspan="2">
                        {{$empresa->ruc}}
                    </th>
                </tr>
                <tr>
                    <th>Tipo</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total {{$moneda_nac->simbolo}} </th>
                    <th>Total {{$moneda_ex->simbolo}} </th>
                </tr>
            </thead>
            @if(isset($data_final_fac))
                <tbody>
                    @foreach($data_final_fac as $data)
                    <tr>
                        <td>{{$data['tipo']}}</td>
                        <td>{{$data['producto']}}</td>
                        <td>{{$data['cantidad']}}</td>
                        <td>{{$data['precio nacional']}}</td>
                        <td>{{$data['precio extranjero']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            @endif
            <tbody>
                <tr>
                    <td colspan="4"></td>
                </tr>
            </tbody>
            @if(isset($data_final_bol))
                <tbody>
                    @foreach($data_final_bol as $data)
                    <tr>
                        <td>{{$data['tipo']}}</td>
                        <td>{{$data['producto']}}</td>
                        <td>{{$data['cantidad']}}</td>
                        <td>{{$data['precio nacional']}}</td>
                        <td>{{$data['precio extranjero']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        <br>
    @endif
    {{-- @endif --}}
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