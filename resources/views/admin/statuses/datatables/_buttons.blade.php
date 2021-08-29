<div class="btn-group btn-group-sm">
    @permission('status_show')
        <a class="btn btn-sm btn-primary" href="{{ route('admin.estatus.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission

    @permission('status_edit')
        <a class="btn btn-sm btn-info" href="{{ route('admin.estatus.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('status_delete')

        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.estatus.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
