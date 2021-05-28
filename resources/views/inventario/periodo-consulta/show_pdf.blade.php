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

<table class="table table-striped table-bordered table-hover dataTables-example" style="text-align: center;">
	<thead>
		<tr>
			<th colspan="9">Periodo Consulta</th>
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
		@foreach($json as $json)
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>a</td>
			<td>{{$json['precio_nacional']}}</td>
			<td>{{$json['precio_nacional']*($igv->igv_total)/100}}</td>
			<td>{{$json['precio_nacional']+( $json['precio_nacional']*($igv->igv_total)/100)}}</td>
		</tr>
		@endforeach
{{-- 		<tr>
			<td>hola</td>
		</tr> --}}
	</tbody>
	<tfoot>
		
	</tfoot>
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