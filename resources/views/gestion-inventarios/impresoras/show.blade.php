@extends('layouts.panel')

@section('title','Panel Impresora')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Gestion Inventarios</li>
    <li class="breadcrumb-item"><a href="{{ route('gestion-inventarios.impresoras.index') }}">Impresoras</a></li>
    <li class="breadcrumb-item active">Panel Impresora #{{ $impresora->descripcion }}</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle Impresora</h3>
                <div class="card-tools">
                    <a href="{{ route('gestion-inventarios.impresoras.edit',$impresora) }}" class="btn btn-primary btn-sm" title="Editar">
                        Editar <i class="fas fa-pencil-alt"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                ID
                            </th>
                            <td>
                                {{ $impresora->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                NOMBRE
                            </th>
                            <td>
                                {{ $impresora->nombre }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                DESCRIPCION
                            </th>
                            <td>
                                {{ $impresora->descripcion }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                NIP
                            </th>
                            <td>
                                {{ $impresora->nip }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                IP
                            </th>
                            <td>
                                {{ $impresora->ip }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
@endsection

