<div class="btn-group btn-group-sm">
    @permission('role_show')
        <a class="btn btn-sm btn-primary" href="{{ route('admin.roles.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission

    @permission('role_edit')
        <a class="btn btn-sm btn-info" href="{{ route('admin.roles.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('role_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.roles.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
