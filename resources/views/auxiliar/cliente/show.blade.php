@extends('layout')

@section('title', 'cliente ver')
@section('breadcrumb', 'cliente ver')
@section('breadcrumb2', 'ver cliente')
@section('href_accion', route('cliente.index'))
@section('value_accion', 'atras')

@section('content')

<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
      <div class="jumbotron" style="height: 50px;padding:10px">
       <center><h1>{{$cliente_show->nombre}}</h1> </center>
      </div>

  <i  class="fa fa-user-o" aria-hidden="true" style="font-size: 35px"></i>&nbsp;&nbsp;
  <a  class="btn btn-sm btn-success" href="{{ route('cliente.edit', $cliente_show->id) }}" style="background-color: #1ab394; border-color: #1ab394;padding: 2px 4px"> <i style="font-size: 15px" class="fa fa-edit"></i></a>
  <br><br>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Direccion:</h4>
          <p>{{$cliente_show->direccion}}</p><hr>

          <h4>Telefono:</h4>
          <p>{{$cliente_show->telefono}}</p><hr>

          <h4>Email:</h4>
          <p>{{$cliente_show->email}}</p><hr>
        </div>

        <div class="col-lg-6">
          <h4>Tipo de Documento:</h4>
          <p>{{$cliente_show->documento_identificacion}}</p><hr>

          <h4>Numero de Documento:</h4>
          <p>{{$cliente_show->numero_documento}}</p><hr>

          <h4>Celular:</h4>
          <p>{{$cliente_show->celular}}</p><hr>

        </div>

    </div> 

{{--Contacto  --}}
<p aling='rigth'><a class="btn btn-primary" href="{{ route('contacto.crear',$cliente_show->id) }}"> Agregar Contacto</a></p>

    <div style="padding-bottom: 10px">
    @foreach($contacto_show as $contacto)
    <table>
      <tr>
        <th><i  style="font-size: 35px" class="fa fa-address-book-o" aria-hidden="true"></i></th>
        <th><a  class="btn btn-sm btn-success" href="{{ route('contacto.editar', $contacto->id) }}" style="background-color: #1ab394; border-color: #1ab394;padding: 2px 4px"> <i style="font-size: 15px" class="fa fa-edit"></i></a></th>
        <th>
         @if($contacto->primer_contacto==1)
                                            <button class="btn btn-s-m btn-info">Sin funcion</button>  
                                        @else
                                        <form action="{{ route('contacto.destroy', $contacto->clientes_id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
                                        </form>
                                        @endif
       </th>
      </tr>
    </table>

    <div class="row marketing">
    	<div class="col-lg-6">
    	  <h4>Nombre del Contacto:</h4>
          <p>{{$contacto->nombre}}</p><hr>
    	  <h4>Cargo:</h4>
          <p>{{$contacto->cargo}}</p><hr>
    	</div>
    	<div class="col-lg-6">
    	  <h4>Telefono/Celular:</h4>
          <p>{{$contacto->telefono}} / {{$contacto->celular}}</p><hr>
    	  <h4>Email:</h4>
          <p>{{$contacto->email}}</p><hr>
    	</div>
     
    	
    </div>
    @endforeach
    </div>
                           
</div>
</div>
@endsection