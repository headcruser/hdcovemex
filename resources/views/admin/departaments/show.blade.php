@extends('layouts.panel')

@section('title','Ver Departamento')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Administración</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.departamentos.index') }}">Departamentos</a></li>
        <li class="breadcrumb-item active">Departamento #{{ $model->id }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">Departamento</div>

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
                                    NOMBRE
                                </th>
                                <td>
                                    {{ $model->nombre }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.departamentos.index') }}">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
