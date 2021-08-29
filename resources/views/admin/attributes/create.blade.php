@extends('layouts.panel')

@section('title','Crear Atributo')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Administración</li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.atributos.index') }}">Atributos</a>
    </li>
    <li class="breadcrumb-item active">Crear</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del atributos</h3>
            </div>
            <div class="card-body">
                <form action="{{ route("admin.atributos.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('admin.attributes.partials._fields')
                    <div>
                        <a class="btn btn-default" href="{{ route('admin.atributos.index') }}">
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

