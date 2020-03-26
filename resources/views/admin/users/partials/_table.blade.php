<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
        <thead>
            <tr>
                <th width="10"></th>
                <th>ID </th>
                <th>NOMBRE</th>
                <th>EMAIL</th>
                <th>DEPARTAMENTO</th>
                <th>ROLES</th>
                <th>ACCIONES    </th>
            </tr>
        </thead>
        <tbody>
            @foreach($collection as $key => $element)
                <tr data-entry-id="{{ $element->id }}">
                    <td></td>
                    <td>
                        {{ $element->id }}
                    </td>
                    <td>
                        {{ $element->nombre }}
                    </td>
                    <td>
                        {{ $element->email }}
                    </td>
                    <td>
                        {{ $element->departamento->nombre }}
                    </td>
                    <td>
                        @forelse($element->roles as $key => $item)
                            <span class="badge badge-info">{{ $item->name }}</span>
                        @empty
                            <span class="badge badge-warning"> Sin Roles</span>
                        @endforelse
                    </td>
                    <td>
                        @permission('user_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.usuarios.show', $element->id) }}" title="Ver">
                                <i class="far fa-eye"></i>
                                {{-- {{ trans('global.view') }} --}}
                            </a>
                        @endpermission

                        @permission('user_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.usuarios.edit', $element->id) }}" title="Editar">
                                {{-- {{ trans('global.edit') }} --}}
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endpermission

                        @permission('user_delete')
                            <form action="{{ route('admin.usuarios.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-xs btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        @endpermission

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
