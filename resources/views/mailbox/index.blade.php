@extends('layout')

@section('title', 'Email')
@section('breadcrumb', 'Email')
@section('breadcrumb2', 'Email')
@section('href_accion', route('email.create'))
@section('value_accion', 'Redactar')

@section('content')
<style>#page-wrapper{height: 500px;}</style>
<div class="fh-breadcrumb">
    <div class="fh-column">
        <div class="full-height-scroll">
            <ul class="list-group elements-list">
                @foreach($mailbox as $row)
               <li class="list-group-item">
                <a class="nav-link" data-toggle="tab" href="#tab-{{$row->id}}">
                    <small class="float-right text-muted">{{$row->fecha_hora}}</small>
                    <strong style="font-size: 10px">{{$row->remitente}}</strong>
                    <div class="small m-t-xs">
                        <p class="m-b-xs">
                            {{$row->mensaje_sin_html}}
                        </p>
                        <p class="m-b-none">
                            <i class="fa fa-map-marker"></i> San Francisko 12/100
                        </p>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="full-height">
    <div class="full-height-scroll white-bg border-left">

        <div class="element-detail-box">

            <div class="tab-content">
                @foreach($mailbox as $row)
                <div id="tab-{{$row->id}}" class="tab-pane">

                    <div class="float-right">
                        <div class="tooltip-demo">
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="left" title="Plug this message"><i class="fa fa-plug"></i> Plug it</button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important"><i class="fa fa-exclamation"></i> </button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to trash"><i class="fa fa-trash-o"></i> </button>

                        </div>
                    </div>
                    <div class="small text-muted">
                        <i class="fa fa-clock-o"></i> Friday, 12 April 2014, 12:32 am
                    </div>

                    <h1>
                        Their separate existence is a myth
                    </h1>

                  {!!$row->mensaje!!}
                    <p class="small">
                        <strong>Best regards, Anthony Smith </strong>
                    </p>

                    <div class="m-t-lg">
                        <p>
                            <span><i class="fa fa-paperclip"></i> 2 attachments - </span>
                            <a href="#">Download all</a>
                            |
                            <a href="#">View all images</a>
                        </p>

                        <div class="attachment">
                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>

                                        <div class="icon">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <div class="file-name">
                                            Document_2014.doc
                                            <br>
                                            <small>Added: Jan 11, 2014</small>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>

                                        <div class="icon">
                                            <i class="fa fa-line-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            Seels_2015.xls
                                            <br>
                                            <small>Added: May 13, 2015</small>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                @endforeach
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

@endsection