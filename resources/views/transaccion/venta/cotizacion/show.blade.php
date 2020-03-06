@extends('layout')

@section('title', 'Cotizacion Ver')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacion')
@section('href_accion', route('cotizacion.index'))
@section('value_accion', 'Atras')

@section('content')

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    
                                    <address class="col-sm-4">
                                        {{-- <h5>De:</h5>
                                        <i class=" fa fa-user">:</i><strong > juan</strong><br>
                                        <i class=" fa fa-building">:</i> <br>
                                        <i class="fa fa-phone">:</i>  --}}
                                        <img src="https://lh3.googleusercontent.com/proxy/t7LxCKVwclP5dHwI56rV8_ZMdGxSwzeZ_00F7aVmy_FXPe-r9Ib1fYoojm0tOxsuoUDQllsCazCV0N_mfjbkfRIEOR9uN3QUXV6O2DTVAYqqoLtCIsg" alt="" width="250px">
                                    </address>
                                </div> 
                                <div class="col-sm-2">
                                </div> 

                                <div class="col-sm-3 text-right">
                                    <h4>Guia Entrada</h4>
                                    <h4 class="text-navy">GE-000</h4>
                                    <span>Para:</span>
                                    <address>
                                        <i class=" fa fa-user">:</i><strong> </strong><br>
                                        <i class=" fa fa-building">:</i><br>
                                        <i class="fa fa-phone">:</i>
                                    </address>
                                    <p>
                                        <span><strong>Fecha de la factura:</strong> </span><br/>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7" align="center">
                                    <div class="form-control">hola
                                        <div align="left">
                                            <strong>De:</strong>Luis
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5" align="center">
                                    <div class="form-control">hola
                                        <div align="left">
                                            <strong>De:</strong>Luis
                                        </div>
                                    </div>
                                </div>
                                
    
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Precio U.</th>
                                        <th>S/.</th>
                                        <th style="background: #f3f3f4">Precio Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     {{-- @foreach($kardex_entradas_registros as $kardex_entradas_registro) --}}
                                    <tr>
                                        <td><strong></strong><br>
                                            <small></small>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #f3f3f4"></td>
                                    </tr>
                                      {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            {{--  --}}
                            {{--  @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                            <tr class="gradeX">
                                <td>{{$kardex_entradas_registro->id}}</td>
                                <td>{{$kardex_entrada->motivo}}</td>
                                <td>{{$kardex_entrada->provedor->empresa}}</td>
                                <td>{{$kardex_entrada->almacen->nombre}}</td>
                                <td>{{$kardex_entrada->guia_remision}}</td>
                                <td>{{$kardex_entrada->factura}}</td>
                                <td><center><a href="{{ route('kardex-entrada.show', $kardex_entrada->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                                <td><center><a href="{{ route('kardex-entrada.edit', $kardex_entrada->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td>
                                <td>
                                    <center>
                                        <form action="{{ route('kardex-entrada.destroy', $kardex_entrada->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-s-m btn-danger">Anular</button>
                                        </form>
                                    </center>
                                </td>
                            </tr>
                        @endforeach --}}
                            {{--  --}}

                           
                                
                        </div>
                </div>
            </div>
        </div>
       

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
 <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

  
@endsection
