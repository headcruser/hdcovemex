@extends('layouts.panel')

@section('title','Editar Estatus')

@section('styles')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Administración</li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.estatus.index') }}">Estatus</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del estatus</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.estatus.update", $model) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin.statuses.partials._fields')
                        <div>
                            <a class="btn btn-default" href="{{ route('admin.estatus.index') }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $('.colorpicker').colorpicker();
    </script>
@endpush

