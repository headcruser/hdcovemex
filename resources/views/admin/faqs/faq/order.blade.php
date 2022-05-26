@extends('layouts.panel')

@section('title','Ordenar FAQ´s')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/x-editable/css/bootstrap-editable.css') }}">

    <style>
        .dd {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            max-width: 100%;
            list-style: none;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-list {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .dd-list .dd-list {
            padding-left: 30px;
        }
        .dd-collapsed .dd-list {
            display: none;
        }
        .dd-item{
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 20px;
            font-size: 13px;
            line-height: 20px;
            cursor: pointer;
            cursor: hand;
        }
        .dd-handle {
            display: block;
            font-size: 15px;
            margin: 5px 0;
            padding: 7px 15px;
            color: #333333;
            text-decoration: none;
            border: 1px solid #cfcfcf;
            background: #fbfbfb;
        }
        .dd-handle:hover {
            color: #2ea8e5;
            background: #ffffff;
        }
        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: 9999 !important;
            opacity: 0.8;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
            filter: alpha(opacity=80);
        }
        .gu-hide {
            display: none !important;
        }
        .gu-unselectable {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }
        .gu-transit {
            opacity: 0.2;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
            filter: alpha(opacity=20);
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Administración </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.faqs.faq.index') }}">Faqs</a>
        </li>
        <li class="breadcrumb-item active">FAQ</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dd">
                <ol class="dd-list">
                    @foreach ($items as $categoria => $preguntas)
                        @foreach ($preguntas->faqs as $item)
                            <li class="dd-item" data-id="{{ $item->id }}">
                                <div class="dd-handle">
                                    <div>
                                        <a class="editable_value"
                                            data-name="orden"
                                            data-type="number"
                                            data-value="{{ $item->orden }}"
                                            data-pk="{{ $item->id }}"
                                            data-url="{{ route('admin.faqs.faq.actualizar-orden') }}"
                                            data-titule="Orden"> {{ $item->orden }} </a>
                                    </div>
                                    {{ $item->pregunta }}
                                    <p class="text-muted">{!! $item->resumen_respuesta !!}</p>
                                </div>
                            </li>
                        @endforeach
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js'></script>
    <script src="{{ asset('vendor/x-editable/js/x-editable.min.js') }}"></script>

    <script type="text/javascript">
        $(function(){

            // 👉 XEDITABLE
            $('.editable').on('shown', function(e, editable) {
                $('.editable-submit').html('<i class="fas fa-check fa-1x"></i>');
                $('.editable-cancel').html('<i class="fas fa-times"></i>');
            });

            $('.editable_value').editable({
                emptytext: 'Vacio',
                onblur: 'ignore'
            });


            dragula([document.querySelector('.dd-list')],{
            }).on('drop', function (el) {
                var parentElId = $(el).parent().attr('id');
                var droppedElIndex = $(el).index();
                var droppedElId = $(el).attr('id');
                console.log({parentElId,droppedElIndex,droppedElId});
                console.log(Array.from(document.querySelectorAll('[data-id]')).map( item => item.dataset.id));
            });
        })
    </script>
@endpush

