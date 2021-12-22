<div class="btn-group btn-group-sm">
    @permission('solicitude_show')
    <a class="btn btn-sm btn-primary"
        href="{{ route('operador.gestion-solicitudes.show', $id) }}" title="Ver">
        <i class="far fa-eye"></i>
    </a>
    @endpermission

    @permission('solicitude_edit')
    <a class="btn btn-sm btn-info"
        href="{{ route('operador.gestion-solicitudes.edit', $id) }}"
        title="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>
    @endpermission

    @permission('solicitude_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('operador.gestion-solicitudes.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
