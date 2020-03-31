@extends('layouts.panel')

@section('title','Ver Estatus')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item"><a href="{{ route('config.atributos.index') }}">Estatus</a></li>
    <li class="breadcrumb-item active">Estatus #{{ $model->id }}</li>
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
                                {{ $model->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                NOMBRE
                            </th>
                            <td>
                                {{ $model->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                ALIAS
                            </th>
                            <td>
                                {{ $model->display_name }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                COLOR
                            </th>
                            <td style="background-color:{{ $model->color ?? '#FFFFFF' }}"></td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ route('config.estatus.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

