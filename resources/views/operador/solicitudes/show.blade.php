@extends('layouts.panel')

@section('title','Ver Solicitud')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Administración</li>
        <li class="breadcrumb-item">
            <a href="{{ route('operador.gestion-solicitudes.index') }}">Solicitudes</a>
        </li>
        <li class="breadcrumb-item active">Solicitud #{{ $model->id }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag"></i>
                        Detalle solicitud
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <td>
                                    {{ $model->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    TITULO
                                </th>
                                <td>
                                    {{ $model->titulo }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    INCIDENTE
                                </th>
                                <td>
                                    {{ $model->incidente }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    ESTATUS
                                </th>
                                <td>
                                    <span class="badge badge-primary text-sm"  style="background-color:{{ $model->status->color }}">
                                        {{ $model->status->display_name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    EMPLEADO
                                </th>
                                <td>
                                    <p class="text-muted">{{ $model->empleado->nombre }}</p>
                                </td>
                            </tr>

                            @if($model->media->exists)
                                <tr>
                                    <th>
                                        ARCHIVO ADJUNTO
                                    </th>
                                    <td>
                                        <p>
                                            <a href="{{ route('operador.gestion-solicitudes.archivo',$model) }}" target="_blank" class="linked text-sm"><i class="fas fa-link mr-1"></i> {{ $model->media->name }} </a>
                                        </p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if($model->estatus_id == 1 )
                        <a class="btn btn-primary float-right" href="{{ route('operador.gestion-solicitudes.edit',$model) }}">
                            <i class="fas fa-pencil-alt"></i> Editar
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
