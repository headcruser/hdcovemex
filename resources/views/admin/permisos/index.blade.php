@extends('layouts.panel')

@section('title','Administrar Permisos')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Administracion</li>
        <li class="breadcrumb-item active">Permisos</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de permisos</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.permisos.create') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                @include('admin.permisos.partials._table')
            </div>

            <div class="card-footer clearfix">
               {{ $permisos->render() }}
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

