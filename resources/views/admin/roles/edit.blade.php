@extends('layouts.panel')

@section('title','Editar Rol')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Administracion</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del rol</h3>
            </div>
            <div class="card-body">
                <form action="{{ route("admin.roles.update", $model) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('admin.roles.partials._fields')
                    <div>
                        <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
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

@section('scripts')
@endsection

