@extends('layouts.panel')

@section('title','Ver Detalle operador')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Administración</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.operadores.index') }}">Operadores</a></li>
    <li class="breadcrumb-item active">Operador #{{ $model->id }}</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Detalle del operador</div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                IMAGEN
                            </th>
                            <td>
                                <div class="image">
                                    <img id="avatar-image" src="{{ $model->usuario->avatar }}" class="img-circle elevation-2" alt="User Image" style="width:50px;height:50px;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                NOMBRE
                            </th>
                            <td>
                                {{ $model->usuario->nombre }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                EMAIL
                            </th>
                            <td>
                                {{ $model->usuario->email }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                DEPARTAMENTO
                            </th>
                            <td>
                                {{ $model->usuario->departamento->nombre }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                ROLES
                            </th>
                            <td>
                                @forelse($model->usuario->roles as $id => $roles)
                                    <span class="badge badge-info">
                                        {{ $roles->name }}
                                    </span>
                                @empty
                                    <span class="badge badge-secondary">Sin Roles</span>
                                @endforelse
                            </td>
                        </tr>

                        <tr>
                            <th>
                                NOTIFICAR SOLICITUD
                            </th>
                            <td>
                                {{ $model->notificar_solicitud_icon }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                NOTIFICAR ASIGNACION
                            </th>
                            <td>
                                {{ $model->notificar_asignacion_icon }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.operadores.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

