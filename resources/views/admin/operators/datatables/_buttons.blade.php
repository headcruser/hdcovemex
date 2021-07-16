<div class="btn-group btn-group-sm">
    @permission('operator_show')
        <a class="btn btn-xs btn-primary" href="{{ route('admin.operadores.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission

    @permission('operator_edit')
        <a class="btn btn-xs btn-info" href="{{ route('admin.operadores.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('operator_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.operadores.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
