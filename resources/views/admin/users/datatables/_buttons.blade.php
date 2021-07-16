<div class="btn-group btn-group-sm">
    @permission('user_show')
        <a class="btn btn-xs btn-primary" href="{{ route('admin.usuarios.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission

    @permission('user_edit')
        <a class="btn btn-xs btn-info" href="{{ route('admin.usuarios.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('user_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.usuarios.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
