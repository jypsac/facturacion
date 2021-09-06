 @extends('layout')

 @section('title', 'Facturacion Ver')
 @section('breadcrumb', 'Facturacion')
 @section('breadcrumb2', 'Facturacion')
 @section('href_accion', route('facturacion.index'))
 @section('value_accion', 'Atras')

@section('button2', 'Nueva Facturacion')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cots').submit();")

@section('content')

<body>
    <button id="btnImprimir">Imprimir</button>
    <input type="text" value="{{$ids}}" name="id" id="id" hidden="">
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btnImprimir').click(function(){
            var articulo2 = $(`[id='id']`).val();
           $.ajax({
               type: "post",
                url: "{{ route('ticket_ajax') }}",
                 data: {
                    '_token': $('input[name=_token]').val(),
                    'id' : articulo2
                    },
               success: function(response){
                   if(response==1){
                       alert('Imprimiendo....');
                   }else{
                       alert('Error');
                   }
               }
           });
        });
    });
</script>
@endsection