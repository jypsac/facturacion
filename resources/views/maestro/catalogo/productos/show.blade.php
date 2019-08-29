@extends('layout')

@section('title', 'productos')
@section('breadcrumb', 'productos')
@section('breadcrumb2', 'productos')
@section('href_accion', route('productos.create'))
@section('value_accion', 'Agregar')

@section('content')
{{$producto->id}}<br>
{{$producto->nombre}}<br>
{{$producto->categoria}}<br>
{{$producto->marca}}<br>
{{$producto->modelo}}<br>
{{$producto->unidad_medida}}<br>
{{$producto->activo}}<br>
{{$producto->codigo_barras}}<br>
{{$producto->foto}}<br>
{{$producto->descripcion}}<br>
{{$producto->created_at}}<br>
{{$producto->updated_at}}<br>

@endsection