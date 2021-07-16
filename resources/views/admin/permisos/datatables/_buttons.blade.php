<div class="btn-group btn-group-sm">
    @permission('permission_show')
        <a class="btn btn-sm btn-primary" href="{{ route('admin.permisos.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission

    @permission('permission_edit')
        <a class="btn btn-sm btn-info" href="{{ route('admin.permisos.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('permission_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.permisos.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
