@extends('layouts.panel')

@section('title','FAQ')

@section('styles')
    @parent
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Faq</li>
    </ol>
@endsection

@section('content')
    <div class="row p-2">
        <div class="col-sm-12">
            <div id="faq-box" class="row mt-3">
                <div class="col-md-12">
                    @foreach($items as $category)
                        <div>
                            @foreach($category->faqs as $faq)

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <a data-toggle="collapse" href="#faq-{{ $faq->id }}">{!! $faq->pregunta !!}</a>
                                            <small>{!! $category->nombre !!}</small>
                                        </h4>
                                    </div>
                                    <div id="faq-{{ $faq->id }}" class="card-collapse collapse" data-id="{{ $faq->id }}">
                                        <div class="card-body">
                                            {!! $faq->respuesta !!}
                                        </div>
                                        <div id="faq-footer-{{ $faq->id }}" class="card-footer" style="border-top: 1px solid #ddd;">
                                            <div class="btn-group btn-group-sm">
                                                <span class="btn" style="padding-left: 0px;">Te ha sido útil esta pregunta?</span>
                                                <a class="btn btn-success btn-helpful" href="#" data-id="{{ $faq->id }}" data-type="ayuda_si">
                                                    <i class="fa fa-thumbs-up"></i> Si
                                                </a>
                                                <a class="btn btn-danger btn-helpful" href="#" data-id="{{ $faq->id }}" data-type="ayuda_no">
                                                    <i class="fa fa-thumbs-down"></i> No
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="col-12 mt-3 text-center">
            <p class="lead">
                Si no encontro la respuesta o tiene otra pregunta <a href="#">Contactenos</a><br>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function(){

            $('#faq-box')
            .on('show.bs.collapse', function (e) {
                const route = "{{ route('faq.increment',['faq' => '_faq']) }}"
                    .replace('_faq',$(e.target).attr('data-id'));

                $.post(route);

                $(e.target).parents('.card').addClass('card-info');
            })
            .on('hide.bs.collapse', function (e) {
                $(e.target).parents('.card').removeClass('card-info');
            });

             $('.btn-helpful').on('click', function (e) {
                e.preventDefault();

                var $footer = $('#faq-footer-' + $(this).attr('data-id'));
                $footer.html("<i class=\"fa fa-spinner fa-spin text-primary text-sm\"></i>");

                const route = "{{ route('faq.increment',['faq' => '_faq','type' => '_type']) }}"
                    .replace('_faq',$(this).attr('data-id'))
                    .replace('_type',$(this).attr('data-type'));

                $.post(route, function () {
                    $footer.html("<div><small><span class=\"text-muted\">Gracias por tu respuesta.</span></small></div>");
                });


                return false;
            });
        })
    </script>
@endpush

