<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID </th>
                        <th>NOMBRE</th>
                        <th>USUARIO</th>
                        <th>EMAIL</th>
                        <th>DEPARTAMENTO</th>
                        <th>ROLES</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collection as $key => $element)
                        <tr data-entry-id="{{ $element->id }}">
                            <td></td>
                            <td class="align-middle">
                                {{ $element->id }}
                            </td>
                            <td class="align-middle" >
                                {{ $element->nombre }}
                            </td>
                            <td class="align-middle">
                                {{ $element->usuario }}
                            </td>
                            <td class="align-middle">
                                {{ $element->email }}
                            </td>
                            <td class="align-middle">
                                {{ $element->departamento->nombre }}
                            </td>
                            <td class="align-middle text-center">
                                @forelse($element->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @empty
                                    <span class="badge badge-warning"> Sin Roles</span>
                                @endforelse
                            </td>

                            <td class="py-0 align-middle text-center">
                                <div class="btn-group btn-group-sm">
                                    @permission('user_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.usuarios.show', $element->id) }}" title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endpermission

                                    @permission('user_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.usuarios.edit', $element->id) }}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endpermission

                                    @permission('user_delete')
                                        <form class="btn btn-sm btn-danger" action="{{ route('admin.usuarios.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
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
