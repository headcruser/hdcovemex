@extends('layouts.panel')

@section('title','Crear Departamento')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Administración </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.permisos.index') }}">Departamentos</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del departamento</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.departamentos.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('admin.departaments.partials._fields')
                        <div>
                            <a class="btn btn-default" href="{{ route('admin.departamentos.index') }}">
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
@endpush
