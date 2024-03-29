@extends('layouts.panel')

@section('title','Editar hardware')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Gestion Inventario </li>
        <li class="breadcrumb-item">
            <a href="{{ route('gestion-inventarios.hardware.index') }}">Hardware</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($hardware, ['route' => ['gestion-inventarios.hardware.update', $hardware], 'method' => 'PUT', 'accept-charset' => 'UTF-8', 'enctype' => 'multipart/form-data']) !!}

                        @include('gestion-inventarios.hardware.partials._fields')

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/i18n/es.js') }}"></script>

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

            $('#input-id_tipo_hardware').select2({
                languaje: "es",
                placeholder: "Selecciona un tipo de hardware",
                ajax: {
                    method: 'POST',
                    data:
                    function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    url: '{{ route("gestion-inventarios.tipo-hardware.select2") }}',
                    dataType: 'json',
                    cache: false,
                    delay:250,
                    beforeSend:function(xhr,type){
                        xhr.setRequestHeader('X-CSRF-Token',$('meta[name="csrf-token"]').attr('content'))
                    }
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function(option){
                    return option.descripcion||option.text;
                },
                templateSelection:function(option){
                    return option.descripcion||option.text;
                }
            });

            @if($hardware->tipo->exists())
                var newOption = new Option('{{ $hardware->tipo->descripcion }}', '{{ $hardware->id_tipo_hardware }}', false, false);
                $('#input-id_tipo_hardware').append(newOption).trigger('change');
            @endif
        });

    </script>
@endpush

