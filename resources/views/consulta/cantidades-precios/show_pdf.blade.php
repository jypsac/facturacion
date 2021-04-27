<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos con bajo Stock</title>{{--
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
	<header  >
		   <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
	        <tr>
	        	<td style="width: 33%; ;border: 1px white solid;border-radius: 8px;margin-top: 0px;" align="right"></td>
	        	<td style="width: 33%; ;border: 1px white solid;border-radius: 8px;margin-top: 0px;" align="right"></td>
	            <td style="width: 33%; ;border: 2px #e5e6e7 solid;border-radius: 18px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;padding-top:10px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
                    <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >Productos</h2><br>
                    <h5 style="text-align: center;margin-bottom: -5px" ></h5>
                </center>
            </td>
	        </tr>
	    </table>
	</header>
	<main >
		<div class="table-responsive">
			<table class="table " style="border-top: 0px" >
				<thead>
					 <tr><td colspan="4" style="width: auto;border-color: white"  valign="top">
		                <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="margin-top: 0px;" width="200px" />
		                <br>
		                <br>
		                <br>
		                {{-- <p>Hola mensajes</p> --}}
		            </td></tr>
				</thead>
				<thead>
					<tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
						<th>Id</th>
						<th>Producto</th>
						<th>Stock Actual</th>
						<th>Stock Minimo</th>
					</tr>
				</thead>
			    <tbody style="padding: 10px 10px 10px 10px">
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
		</div>
		</main>
</body>
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

</html>

