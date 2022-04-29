@extends('layouts.panel')

@section('title','Editar Personal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @parent
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Gestion Inventario </li>
        <li class="breadcrumb-item">
            <a href="{{ route('gestion-inventarios.personal.index') }}">Personal</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del personal</h3>
                    <div class="card-tools">
                        <a id="btn-agregar-info" href="{{ route('gestion-inventarios.personal.show',$personal) }}" class="btn btn-success btn-sm" title="Crear">
                            Perfil <i class="fas fa-user"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::model($personal, ['route' => ['gestion-inventarios.personal.update',$personal],'id' => 'form-crear-personal','method' => 'PUT', 'accept-charset' =>'UTF-8', 'enctype' => 'multipart/form-data']) !!}

                        @include('gestion-inventarios.personal.partials._fields')

                        <div class="text-right">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Guardar</button>
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
            const $form = $('#form-crear-personal');

            $form.submit(function(e){
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

            $('#input-id_departamento').select2({
                language: "es",
                placeholder: "Selecciona un departamento",
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
                    url: '{{ route("admin.departamentos.select2") }}',
                    dataType: 'json',
                    cache: false,
                    delay:250,
                    beforeSend:function(xhr,type){
                        xhr.setRequestHeader('X-CSRF-Token',$('meta[name="csrf-token"]').attr('content'))
                    }
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function(option){
                    return option.nombre||option.text;
                },
                templateSelection:function(option){
                    return option.nombre||option.text;
                }
            });

            $('#input-id_sucursal').select2({
                language: "es",
                placeholder: "Selecciona una sucursal",
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
                    url: '{{ route("gestion-inventarios.sucursales.select2") }}',
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

            @if($personal->departamento->exists())
                var newOption = new Option('{{ $personal->departamento->nombre }}', '{{ $personal->id_departamento }}', false, false);
                $('#input-id_departamento').append(newOption).trigger('change');
            @endif

            @if($personal->sucursal->exists())
                var newOption = new Option('{{ $personal->sucursal->descripcion }}', '{{ $personal->id_sucursal }}', false, false);
                $('#input-id_sucursal').append(newOption).trigger('change');
            @endif
        });

    </script>
@endpush

