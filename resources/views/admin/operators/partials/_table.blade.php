<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th>ID </th>
                        <th>NOMBRE</th>
                        <th>EMAIL</th>
                        <th>ROLES</th>
                        <th>SOLICITUD</th>
                        <th>ASIGNACION</th>
                        <th ></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collection as $key => $element)
                        <tr data-entry-id="{{ $element->id }}">
                            <td>
                                {{ $element->id }}
                            </td>
                            <td>
                                {{ $element->usuario->nombre }}
                            </td>
                            <td>
                                {{ $element->usuario->email }}
                            </td>
                            <td>
                                {{ $element->usuario->nameRoleUser }}
                            </td>
                            <td>
                                {{ $element->notificar_solicitud_icon }}
                            </td>
                            <td>
                                {{ $element->notificar_asignacion_icon }}
                            </td>

                            <td class="py-0 align-middle text-center">
                                <div class="btn-group btn-group-sm">
                                    @permission('operator_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.operadores.show', $element->id) }}" title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endpermission

                                    @permission('operator_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.operadores.edit', $element->id) }}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endpermission

                                    @permission('operator_delete')
                                        <form class="btn btn-sm btn-danger d-inline-block" action="{{ route('admin.operadores.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-sm p-0 m-0 text-white" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endpermission
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <span class="pagination-info">Mostrando {{$collection->currentPage()}} de {{$collection->lastPage()}} páginas de {{$collection->total()}} registros</span>
    </div>
    <div class="col-6">
        <div class="float-right">
            {{ $collection->render() }}
        </div>
    </div>
</div>
