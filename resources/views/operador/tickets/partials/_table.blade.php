<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
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

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collection as $element)
                    <tr>
                        <td class="align-middle"">{{ $element->id }}</td>
                        <td class="text-center align-middle" style="background-color:{{ $element->colorPrioridad }};">
                            <strong>{{ $element->nombrePrioridad }}</strong>
                        </td>
                        <td class="align-middle"">{{ $element->fecha->format('d/m/Y') }}</td>
                        <td class="align-middle"">{{ $element->empleado->usuario }}</td>
                        <td class="align-middle"">{{ $element->empleado->nombre }}</td>
                        <td class="align-middle"">{{ $element->empleado->departamento->nombre }}</td>
                        <td class="align-middle"">{{ $element->titulo }}</td>
                        <td class="text-center align-middle"">
                            <span class="badge badge-primary text-sm">
                                {{ $element->estado }}
                            </span>
                        </td>
                        <td class="py-0 align-middle text-center">
                            <div class="btn-group btn-group-sm">
                                @permission('ticket_show')
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('operador.tickets.show', $element->id) }}" title="Ver">
                                    <i class="far fa-eye"></i>
                                </a>
                                @endpermission

                                @permission('ticket_edit')
                                <a class="btn btn-sm btn-info" href="{{ route('operador.tickets.edit', $element->id) }}"
                                    title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @endpermission

                                @permission('ticket_delete')
                                <form class="btn btn-sm btn-danger"
                                    action="{{ route('operador.tickets.destroy', $element->id) }}" method="POST"
                                    onsubmit="return confirm('Deseas eliminar el registro');"
                                    style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 m-0 text-white" title="Eliminar"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                                @endpermission
                            </div>
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

<div class="row">
    <div class="col-6">
        <span class="pagination-info">Mostrando {{ $collection->currentPage()}} de {{$collection->lastPage()}} páginas
            de {{$collection->total()}} registros</span>
    </div>
    <div class="col-6">
        <div class="float-right">
            {{ $collection->render() }}
        </div>
    </div>
</div>
