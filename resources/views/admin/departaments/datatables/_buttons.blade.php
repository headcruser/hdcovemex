<div class="btn-group btn-group-sm">
    @permission('departament_show')
        <a class="btn btn-sm btn-primary" href="{{ route('admin.departamentos.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission

    @permission('departament_edit')
        <a class="btn btn-sm btn-info" href="{{ route('admin.departamentos.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('departament_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.departamentos.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
