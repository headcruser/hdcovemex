@extends('layouts.panel')

@section('title','Ver Permiso')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Solicitudes</li>
        <li class="breadcrumb-item active">Solicitud #{{ $model->id }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Detalle solicitud</div>

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
                                <span class="badge badge-primary">
                                    {{ $model->status->display_name }}
                                </span>
                            </td>
                        </tr>


                        @isset($model->adjunto)
                            <tr>
                                <th>
                                    INCIDENTE
                                </th>
                                <td>
                                    <a class="linked" href="{{ route('solicitudes.archivo',$model) }}" target="_blank">{{ $model->nombre_adjunto }}</a>
                                </td>
                            </tr>
                        @endisset

                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ route('solicitudes.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

