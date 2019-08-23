@extends('layout')

@section('title', 'Inicio')
@section('breadcrumb', 'Inicio')
@section('breadcrumb2', 'Inicio')
@section('href_accion', 'hola.html')
@section('value_accion', 'Agregar')

@section('content')

	{{-- <h2>Bienvenido {{ $nombre ?? "invitado" }}</h2>--}}

@endsection
@include('partials.page_script_general')