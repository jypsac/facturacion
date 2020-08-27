@extends('layout')

@section('title', 'Bienvenido : '.auth()->user()->personal->nombres)
@section('breadcrumb', 'Inicio')
@section('breadcrumb2', 'Bienvenido')

@section('foto', auth()->user()->personal->foto)
@section('nombre', auth()->user()->personal->nombres)
@section('area', auth()->user()->name)

@section('value_accion', '>>>')
@section('content')

{{-- @if(!$consulta)
	<script>
		window.location.href = "{{route('tipo_cambio.create')}}";
	</script>
@endif --}}

@endsection
@include('partials.page_script_general')


 <!-- Flot -->
 <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
 <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
 <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
 <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
 <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
 <script src="{{ asset('js/plugins/flot/jquery.flot.symbol.js') }}"></script>
 <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

 <!-- Peity -->
 <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
 <script src="{{ asset('js/demo/peity-demo.js') }}"></script>


 <!-- jQuery UI -->
 <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

 <!-- Jvectormap -->
 <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
 <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

 <!-- EayPIE -->
 <script src="{{ asset('js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

 <!-- Sparkline -->
 <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

 <!-- Sparkline demo data  -->
 <script src="{{ asset('js/demo/sparkline-demo.js"></script>
