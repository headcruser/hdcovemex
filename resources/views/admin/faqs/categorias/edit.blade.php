@extends('layouts.panel')

@section('title','Editar Categoria')

@section('styles')
    @parent
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Administración</li>
        <li class="breadcrumb-item">Faqs</li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.faqs.categorias.index') }}">Categorias</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de categoria</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.faqs.categorias.update", $categoria) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin.faqs.categorias.partials._fields')
                        <div>
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

