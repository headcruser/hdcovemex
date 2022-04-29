@extends('layouts.panel')

@section('title','Ver Error')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Administración</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.log-email.index') }}">Log Email</a></li>
        <li class="breadcrumb-item active">Departamento #{{ $model->id }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">Detalle del envio de correo</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>

                            <tr>
                                <th>
                                    OPERADOR
                                </th>
                                <td>
                                    {{ $model->operador->nombre }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    DESTINATARIO
                                </th>
                                <td>
                                    {{ $model->subject->empleado->nombre }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    CORREO ELECTRONICO
                                </th>
                                <td>
                                    {{ $model->subject->empleado->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    ASUNTO
                                </th>
                                <td>
                                    <h2>{{ $model->subject->titulo }}</h2>
                                    <p>{{ $model->subject->incidente }}</p>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    ERROR DE ENVIO
                                </th>
                                <td>
                                    {{ $model->description }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.log-email.index') }}">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
