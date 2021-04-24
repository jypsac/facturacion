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
header{
	position: fixed;
	display: block;
    top: 0cm;
    left: 0cm;
    right: 0cm;
    height: 3cm;
}
</style>
<body class="white-bg">
{{-- <div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >

        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
    </div>
</div> --}}
{{-- 	<header  >
		   <table style="width: 100%;margin-bottom: -10px">
	        <tr>
	            <td style="width: auto;border-color: white" rowspan="2" valign="top">
	                <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="margin-top: 0px;" width="300px" />
	                <br>
	            </td>

	        </tr>
	    </table>
	</header> --}}
	<main >
		{{-- <div class="wrapper wrapper-content animated fadeIn" style="margin-top: 0px;"> --}}
			<br>
			<br>
			<br>
			<table width="100%" >
				<thead>
					<tr>
						<th>Id</th>
						<th>Producto</th>
						<th>Stock Actual</th>
						<th>Stock Minimo</th>
					</tr>
				</thead>
			    <tbody>
			    	@foreach($producto as $producto)
			    	<tr >
		 				<td>{{$x++}}</td>
		 				<td>{{$producto->producto->nombre}}</td>
		 				<td>{{$producto->stock}}</td>
		 				<td>{{$producto->producto->stock_minimo}}</td>
				    </tr>
			    	@endforeach
			    </tbody>
			</table>
		{{-- </div> --}}
		</main>
</body>
</html>

