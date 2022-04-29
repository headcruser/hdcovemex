@extends('layouts.panel')

@section('title','Editar Impresora')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Gestion Inventarios</li>
        <li class="breadcrumb-item">
            <a href="{{ route('gestion-inventarios.impresoras.index') }}">Impresoras</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de la Impresora</h3>
                </div>
                {!! Form::model($impresora,['route' => ['gestion-inventarios.impresoras.update',$impresora],'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
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

@push('scripts')
@endpush

