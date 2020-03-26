<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
        <thead>
            <tr>
                <th width="10"></th>
                <th>ID </th>
                <th>ROL</th>
                <th>NOMBRE</th>
                <th>ACCIONES</th>
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
                        {{ $element->name }}
                    </td>
                    <td>
                        {{ $element->display_name }}
                    </td>

                    <td>
                        @permission('role_show')
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.roles.show', $element->id) }}" title="Ver">
                                <i class="far fa-eye"></i>
                                {{-- {{ trans('global.view') }} --}}
                            </a>
                        @endpermission

                        @permission('role_edit')
                            <a class="btn btn-sm btn-info" href="{{ route('admin.roles.edit', $element->id) }}" title="Editar">
                                {{-- {{ trans('global.edit') }} --}}
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endpermission

                        @permission('role_delete')
                            <form action="{{ route('admin.roles.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        @endpermission

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
