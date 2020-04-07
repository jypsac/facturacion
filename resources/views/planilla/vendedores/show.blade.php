@extends('layout')

@section('title', 'vendedores')
@section('breadcrumb', 'vendedores-Ver')
@section('breadcrumb2', 'vendedores-Ver')
@section('href_accion', route('vendedores.index') )
@section('value_accion', 'Atras')

@section('content')

<div style="padding-top: 20px;">
<div class="container" style=" padding-top: 30px; background: white;">
     
 <div class="ibox-title">
    <a class="btn btn-lg btn-success" href="{{ route('vendedores.edit', $personal->id) }}" style="background-color: #1ab394; border-color: #1ab394"> <i class="fa fa-edit"></i></a>
 </div>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Codigo Vendedor</h4>
          
          <p class="form-control" >
          {{ $personal->cod_vendedor }}</p>
        </div>

        <div class="col-lg-6">
          <h4>Nombre Vendedor:</h4>
          <p class="form-control" >
          {{ $personal->personal->nombres }}</p>
           

        </div>
       
        <div class="col-lg-6">
         
          <h4>Tipo de Comision</h4>
           <p class="form-control" >
          {{ $personal->tipo_comision }}</p> 

         
          
        </div>
         <div class="col-lg-6">
         

          <h4> Comision</h4>
         
           <p class="form-control" >
          {{ $personal->comision }}</p> 
        </div>

      </div>


    </div> 
    </div> 
     <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Lista de Comisiones</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-wrench"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                        <li><a href="#" class="dropdown-item">Config option 1</a>
                                        </li>
                                        <li><a href="#" class="dropdown-item">Config option 2</a>
                                        </li>
                                    </ul>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                              
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <!-- <th>ID</th> -->
                                                <th>Fecha</th>
                                                <th>Nª Cotizacion</th>
                                                <th>Tipo</th>
                                                <th>Factura</th>
                                                <th>Cliente</th>
                                                <th>Comision</th>
                                                <th>Aprobada</th>
                                                <th>Procesado</th>
                                                <th>Observaciones</th>
                                                {{-- <th>EDITAR</th> --}}
                                                {{-- <th>Eliminar</th> --}}
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($lista as $listas)
                                            <tr class="gradeX">
                                                <td>{{$listas->created_at}}</td>
                                                <td>{{$listas->numero_cotizacion}}</td>
                                                <td>{{$listas->tipo}}</td>
                                                <td>factura</td>
                                                <td>cliente</td>
                                                <td>comsion</td>
                                                 <td>
                                                  @if($listas->estado_aprobado == 0)
                                           <!-- Button trigger modal --><center>
                                                    <button type="button" class="btn btn-s-m btn-warning" data-toggle="modal" data-target="#{{$listas->id}}">
                                                     Aprobar
                                                    </button></center>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="{{$listas->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                     <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                               <div class="modal-content" >
                                                   <div class="modal-body" style="padding: 0px;">
                                                       
                                                        <div class="ibox-content float-e-margins">
                        
                                               <h3 class="font-bold col-lg-12" align="center">
                                              ¿Esta Seguro que Desea Aprobar la Comision:"{{$listas->numero_cotizacion}}".?<br>
                                             <h4 align="center"> <strong>Nota: Una vez Aprobada no hay opcion de deshacer cambios</strong></h4>
                                               </h3>
                                               <p align="center">
                                                   <form action="{{ route('registros.destroy', $listas->id)}}" method="POST">
                                                   @csrf
                                                   @method('delete')
                                                   <center>
                                                   <button type="submit" class="btn btn-w-m btn-info">Aprobar</button>
                                              </form>
                                                    
                                               </p>
                                              </div>

                                                    </div>
                                                  </div>
                                             </div> 
                                                    </div>

                                           @elseif($listas->estado_aprobado == 1)
                                           <center>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal123">Aprobado</button></center>

                                           @endif
                                    
                                              </td>

                                              <td>
                                                  @if($listas->pago_efectuado == 0)
                                           <!-- Button trigger modal --><center>
                                                    <button type="button" class="btn btn-s-m btn-warning" data-toggle="modal" data-target="#{{$listas->id}}p">
                                                     Procesar
                                                    </button></center>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="{{$listas->id}}p" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                     <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                               <div class="modal-content" >
                                                   <div class="modal-body" style="padding: 0px;">
                                                       
                                                        <div class="ibox-content float-e-margins">
                        
                                               <h3 class="font-bold col-lg-12" align="center">
                                              ¿Esta Seguro que Desea Procesar con el pago a la Comision:"{{$listas->numero_cotizacion}}".?<br>
                                             <h4 align="center"> <strong>Nota: Una vez Aprobada no hay opcion de deshacer cambios</strong></h4>
                                               </h3>
                                               <p align="center">
                                                   <form  action="{{ route('vendedores.destroy', $listas->id)}}" method="POST">
                                                   @csrf
                                                   @method('delete')
                                                   <center>
                                                   <button type="submit" class="btn btn-s-m btn-warning">Procesar</button>
                                              </form>
                                                    
                                               </p>
                                              </div>

                                                    </div>
                                                  </div>
                                             </div> 
                                                    </div>

                                           @elseif($listas->pago_efectuado == 1)
                                           <center>
                                            <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#modal123">Procesado</button></center>

                                           @endif
                                    
                                              </td>
                                               
                                                <td>{{$listas->observacion}}</td>


                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
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
     <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

    <style type="text/css">
      img{border-radius: 40px}
      p#texto{text-align: center;
        color:black;
        }
                
  input#archivoInput{
    position:absolute;
    top:25%;
    left:80%;
    right:0px;
    bottom:58%;
    width:15%;
    opacity: 0  ;
  }
</style>
@stop
  
