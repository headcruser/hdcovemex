@extends('layouts.panel')

@section('title','Ver usuario')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Administracion</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li>
        <li class="breadcrumb-item active">Usuario #{{ $user->id }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                ID
                            </th>
                            <td>
                                {{ $user->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                NOMBRE
                            </th>
                            <td>
                                {{ $user->nombre }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                EMAIL
                            </th>
                            <td>
                                {{ $user->email }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                DEPARTAMENTO
                            </th>
                            <td>
                                {{ $user->departamento->nombre }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Roles
                            </th>
                            <td>
                                @forelse($user->roles as $id => $roles)
                                    <span class="label label-info label-many">{{ $roles->nombre }}</span>
                                @empty
                                    <span class="label label-warning label-many">Sin Roles</span>
                                @endforelse
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.usuarios.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

