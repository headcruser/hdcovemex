@extends('layouts.panel')

@section('title','Editar FAQ')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Administración</li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.faqs.faq.index') }}">FAQ</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del FAQ</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($model ,[
                        'route'             => ['admin.faqs.faq.update',$model],
                        'method'            => 'PUT',
                        'accept-charset'    => 'UTF-8',
                        'enctype'           =>'multipart/form-data']) !!}

                        @include('admin.faqs.faq.partials._fields')

                        <div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('form').submit(function(e){
                Swal.fire({
                    title: 'Procesando',
                    html: 'Espere un momento por favor.',
                    allowEscapeKey:false,
                    allowOutsideClick:false,
                    allowEnterKey:false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                })
            });

            $('#respuesta').summernote({
                height: 250,
                lang: 'es-ES',
                codemirror: {
                    theme: 'monokai'
                }
            });
        });

    </script>
@endpush

