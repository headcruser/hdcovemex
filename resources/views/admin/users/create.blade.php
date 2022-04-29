@extends('layouts.panel')

@section('title','Crear Usuario')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Administración </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.usuarios.index') }}">Usuarios</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del usuario</h3>
                </div>
                <div class="card-body">
                    <form id="form-crear-usuario" action="{{ route("admin.usuarios.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('admin.users.partials._fields')
                        <div>
                            <a class="btn btn-default" href="{{ route('admin.usuarios.index') }}">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Guardar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function() {
            const $form = $('#form-crear-usuario');

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
        });

    </script>
@endpush

