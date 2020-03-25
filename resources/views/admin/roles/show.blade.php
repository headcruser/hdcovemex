@extends('layouts.panel')

@section('title','Ver rol')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Administracion</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Rol #{{ $rol->id }}</li>
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
                                {{ $rol->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                NOMBRE
                            </th>
                            <td>
                                {{ $rol->name }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                ALIAS
                            </th>
                            <td>
                                {{ $rol->display_name }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                DESCRIPCION
                            </th>
                            <td>
                                {{ $rol->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                PERMISOS
                            </th>
                            <td>
                                @forelse($rol->perms as $permission)
                                    <span class="badge badge-info">{{ $permission->display_name }}</span>
                                @empty
                                    <span class="badge badge-warning">Sin Permisos</span>
                                @endforelse
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

