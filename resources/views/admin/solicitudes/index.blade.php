@extends('layouts.panel')

@section('title','Solicitudes')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Administración</li>
    <li class="breadcrumb-item active">Solicitudes</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administrar solicitudes</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Ticket">
                    <thead>
                        <tr>
                            <th width="10">
                            </th>
                            <th>
                                TITULO
                            </th>
                            <th>
                                FECHA
                            </th>
                            <th>
                               AUTOR
                            </th>

                            <th>
                                DEPARTAMENTO
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
                                <td>{{ $element->titulo }}</td>
                                <td>{{ $element->fecha }}</td>
                                <td>{{ $element->empleado->nombre }}</td>
                                <td>{{ $element->empleado->departamento->nombre }}</td>
                                <td>
                                    <span class="badge badge-primary"  style="background-color:{{ $element->status->color }}">
                                        {{ $element->status->display_name }}
                                    </span>
                                </td>
                                <td>
                                    @permission('solicitude_show')
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.solicitudes.show', $element->id) }}" title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endpermission

                                    @permission('solicitude_edit')
                                        <a class="btn btn-sm btn-info" href="{{ route('admin.solicitudes.edit', $element->id) }}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endpermission

                                    @permission('solicitude_delete')
                                        <form action="{{ route('admin.solicitudes.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                        </form>
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

