<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
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

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collection as $element)
                    <tr>
                        <td>{{ $element->id }}</td>
                        <td>{{ $element->titulo }}</td>
                        <td>{{ $element->fecha->format('d/m/Y') }}</td>
                        <td>{{ $element->empleado->nombre }}</td>
                        <td>{{ $element->empleado->departamento->nombre }}</td>
                        <td class="text-center">
                            <span class="badge badge-primary text-sm"
                                style="background-color:{{ $element->status->color }}">
                                {{ $element->status->display_name }}
                            </span>
                        </td>
                        <td class="py-0 align-middle text-center">
                            <div class="btn-group btn-group-sm">
                                @permission('solicitude_show')
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('operador.gestion-solicitudes.show', $element->id) }}" title="Ver">
                                    <i class="far fa-eye"></i>
                                </a>
                                @endpermission

                                @permission('solicitude_edit')
                                <a class="btn btn-sm btn-info"
                                    href="{{ route('operador.gestion-solicitudes.edit', $element->id) }}"
                                    title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @endpermission

                                @permission('solicitude_delete')
                                <form class="btn btn-sm btn-danger"
                                    action="{{ route('operador.gestion-solicitudes.destroy', $element->id) }}"
                                    method="POST" onsubmit="return confirm('Deseas eliminar el registro');"
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
                        <td colspan="7" class="text-center">No hay solicitudes</td>
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
