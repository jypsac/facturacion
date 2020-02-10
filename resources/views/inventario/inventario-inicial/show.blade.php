@extends('layout')

@section('title', 'Inventario Inicial-Ver')
@section('breadcrumb', 'Inventario Inicial')
@section('breadcrumb2', 'Inventario Inicial')
@section('href_accion', route('inventario-inicial.index'))
@section('value_accion', 'atras')

@section('content')


<h1>xD</h1>


	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
