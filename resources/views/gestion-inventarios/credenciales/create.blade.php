@extends('layouts.panel')

@section('title','Crear Contraseña')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Gestion de inventarios </li>
        <li class="breadcrumb-item">
            <a href="{{ route('gestion-inventarios.credenciales.index') }}">Contraseñas</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de la contraseña</h3>
                </div>
                {!! Form::open([
                    'route'             => 'gestion-inventarios.credenciales.store',
                    'method'            => 'POST',
                    'accept-charset'    => 'UTF-8',
                    'enctype'           => 'multipart/form-data']) !!}

                    <div class="card-body">
                        @include('gestion-inventarios.credenciales.partials._fields')
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                {!! Form::close() !!}
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

            $('#nota').summernote({
                height: 250,
                lang: 'es-ES',
                codemirror: {
                    theme: 'monokai'
                }
            });
        });
    </script>
@endpush
