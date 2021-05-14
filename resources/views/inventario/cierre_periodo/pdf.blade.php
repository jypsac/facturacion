<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizacion</title>{{--
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
<table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
    <thead>
        <tr>
            <th rowspan="2">Almacen</th>
            <th rowspan="2">Almacen Central</th>
            <th rowspan="2">Stock Actual</th>
            <th rowspan="2"></th>
            <th rowspan="2">{{$cierre_periodo->moneda->simbolo}}</th>
            <th rowspan="2">Costo</th>
            <th>Tipo Cambio:</th>
            <th>{{$cierre_periodo->tipo_cambio}}</th>
        </tr>
        <tr>
            <th colspan="2">Valorizacion</th>
        </tr>
        <tr>
            <th>Cod. Anexo</th>
            <th>Nombre del Artículo</th>
            <th></th>
            <th>Monto</th>
            <th></th>
            <th>Precio Unitario</th>
            <th>{{$moneda2->nombre}} ({{$moneda2->simbolo}}) </th>
            <th>{{$moneda1->nombre}} ({{$moneda1->simbolo}}) </th>
        </tr>
    </thead>
    <tbody>
        @foreach($cierre_periodo_re as $cierre_registro)
        <tr>
            <td>{{$cierre_registro->producto->codigo_producto}}</td>
            <td>{{$cierre_registro->producto->nombre}}</td>
            <td>{{$cierre_registro->cantidad}}</td>
            <td>{{$cierre_registro->producto->unidad_i_producto->unidad}}. {{$cierre_registro->producto->unidad_i_producto->simbolo}}</td>
            <td>{{ $a = $cierre_periodo->moneda->simbolo}}</td>
            <td>
                @if( $cierre_periodo->moneda->tipo == 'nacional')
                   {{$cierre_registro->costo_nacional}}
                @else
                    {{$cierre_registro->costo_extranjero}}
                @endif
            </td>
            <td>{{($cierre_registro->costo_nacional*$cierre_registro->cantidad)}}</td>
            <td>{{($cierre_registro->costo_extranjero*$cierre_registro->cantidad)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
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