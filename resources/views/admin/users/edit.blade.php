@extends('layouts.panel')

@section('title','Editar Usuario')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Administración </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.usuarios.index') }}">Usuarios</a>
    </li>
    <li class="breadcrumb-item active">Usuario #{{ $model->id }}</li>
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
                <form action="{{ route("admin.usuarios.update", $model) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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

@section('scripts')
@endsection

