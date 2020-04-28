@extends('layouts.panel')

@section('title','Tickets')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Tickets</li>
</ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestionar Tickets</h3>
            </div>
            <div class="card-body">
                @include('operador.tickets.partials._filters')

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th>
                                    TICKET
                                </th>
                                <th>
                                    PRIORIDAD
                                </th>
                                <th>
                                    FECHA
                                </th>

                                <th>
                                    USUARIO
                                </th>
                                <th>
                                    NOMBRE
                                </th>

                                <th>
                                    DEPARTAMENTO
                                </th>

                                <th>
                                    TITULO
                                </th>

                                <th>
                                    ESTADO
                                </th>

                                <th>
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($collection as $element)
                                <tr>
                                    <td></td>
                                    <td>{{ $element->id }}</td>
                                    <td class="text-center"  style="background-color:{{ $element->colorPrioridad }};">
                                        <strong>{{ $element->nombrePrioridad }}</strong>
                                    </td>
                                    <td>{{ $element->fecha->format('d/m/Y H:i') }}</td>
                                    <td>{{ $element->empleado->usuario }}</td>
                                    <td>{{ $element->empleado->nombre }}</td>
                                    <td>{{ $element->empleado->departamento->nombre }}</td>
                                    <td>{{ $element->titulo }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-primary text-sm">
                                            {{ $element->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        @permission('ticket_show')
                                            <a class="btn btn-sm btn-primary" href="{{ route('operador.tickets.show', $element->id) }}" title="Ver">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        @endpermission

                                        @permission('ticket_edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('operador.tickets.edit', $element->id) }}" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endpermission

                                        @permission('ticket_delete')
                                            <form action="{{ route('operador.tickets.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endpermission
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No hay registros</td>
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

