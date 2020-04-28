@extends('layouts.panel')

@section('title','Administrar Roles')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Administración </li>
    <li class="breadcrumb-item active">Roles</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de roles</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.roles.create') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                @include('admin.roles.partials._table')
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

