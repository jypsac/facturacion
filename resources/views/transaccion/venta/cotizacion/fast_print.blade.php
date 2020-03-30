{{$cliente_id}}
{{$atencion}}
{{$forma_pago_id}}
{{$validez}}
{{$referencia}}
{{$user_id}}
{{$observacion}}

bucle de articulo
@foreach ($producto_id as $index => $producto_ids)
    {{$producto_ids}} -- {{$cantidad[$index]}} -- {{$check_descuento[$index]}}
@endforeach




