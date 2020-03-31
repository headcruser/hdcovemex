@extends('layouts.panel')

@section('title','Solicitudes')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Solicitudes</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mis Solicitudes</h3>
                <div class="card-tools">
                    <a href="{{ route('solicitudes.create') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Ticket">
                    <thead>
                        <tr>
                            <th width="10">
                            </th>
                            <th>
                                FECHA
                            </th>
                            <th>
                                TITULO
                            </th>

                            <th>
                                ESTADO
                            </th>

                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($collection as $element)
                            <tr>
                                <td>{{ $element->id }}</td>
                                <td>{{ $element->fecha }}</td>
                                <td>{{ $element->titulo }}</td>
                                <td class="text-center">
                                    <span class="badge badge-primary text-sm"  style="background-color:{{ $element->status->color }}">
                                        {{ $element->status->display_name }}
                                    </span>
                                </td>
                                <td>
                                    @permission('solicitude_show')
                                        <a class="btn btn-sm btn-primary" href="{{ route('solicitudes.show', $element->id) }}" title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endpermission
                                </td>
                            </tr>
                        @empty
                            <tr >
                                <td colspan="7" class="text-center">No hay solicitudes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

