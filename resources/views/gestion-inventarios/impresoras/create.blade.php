@extends('layouts.panel')

@section('title','Crear Impresora')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Gestion Inventarios</li>
    <li class="breadcrumb-item">
        <a href="{{ route('gestion-inventarios.impresoras.index') }}">Impresoras</a>
    </li>
    <li class="breadcrumb-item active">Crear</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información de la Impresora</h3>
            </div>
            {!! Form::open(['route' => 'gestion-inventarios.impresoras.store','method' => 'post','enctype' => 'multipart/form-data']) !!}
            <div class="card-body">
                @include('gestion-inventarios.impresoras.partials._fields')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

