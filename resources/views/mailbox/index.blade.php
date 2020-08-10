@extends('layout')

@section('title', 'Email')
@section('breadcrumb', 'Email')
@section('breadcrumb2', 'Email')
@section('href_accion', route('email.create'))
@section('value_accion', 'Redactar')

@section('content')
</br>
<div class="col animated fadeInRight">
    <div class="mail-box-header">
        <h2>
            Bandeja de Salida
        </h2>

        <div class="mail-tools tooltip-demo m-t-md">
            <div class="btn-group float-right">
                <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>
            </div>
            <a href="" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> Refresh</a>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>
        </div>
    </div>
    <div class="mail-box">
        <table class="table table-hover table-mail">
            <tbody>@foreach($mailbox as $row)
                <tr  class="unread">
                    <td class="check-mail">
                        <input type="checkbox" class="i-checks">
                    </td>
                    <td ><a href="#">{{$row->destinatario}}</a></td>
                    <td width="100px"> <div class="pre">{!!$row->mensaje!!}</div></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">{{$row->fecha_hora}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .blockquote{font-size: 12px !important}
    span{font-size: 12px !important; background: none !important;font-family: open sans !important;text-align: left !important;font-weight: normal !important;}
    li{font-size: 12px !important;  text-align: left !important;font-weight: normal !important; }
    ol{font-size: 12px !important; padding-left: 12px !important;font-weight: normal !important;}
    b{font-size: 12px !important; font-weight: normal !important;}
    .table .table-bordered{display:none !important;}
    h1, h2, h3, h4, h5, h6{font-size: 12px !important; margin-top: 0px!important;font-family: open sans !important;}
    .pre{background-color: #eff2f305 !important; border: 1px solid #d1dade05 !important;height: 25px; width: 500px; overflow: hidden !important;padding: 0;}
</style>

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

@endsection