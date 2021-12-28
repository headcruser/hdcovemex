<div class="btn-group btn-group-sm">
    @permission('solicitude_show')
    <a class="btn btn-sm btn-primary"
        href="{{ route('operador.gestion-solicitudes.show', $id) }}" title="Ver">
        <i class="far fa-eye"></i>
    </a>
    @endpermission

    @if($model->estatus_id == 1 )
        @permission('solicitude_edit')
        <a class="btn btn-sm btn-info"
            href="{{ route('operador.gestion-solicitudes.edit', $id) }}"
            title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
        @endpermission
    @endif

    @permission('solicitude_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('operador.gestion-solicitudes.destroy', $id) }}"
            title="Cancelar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission

    @if($model->estatus_id == 1 )
        <a class="btn btn-xs btn-dark"
            data-action="cancelar"
            href="{{ route('operador.gestion-solicitudes.cancelar', $id) }}"
            title="Cancelar">
            <i class="fas fa-times"></i>
        </a>


        <a class="btn btn-xs btn-success"
            data-action="abrir-ticket"
            href="{{ route('operador.gestion-solicitudes.abrir-ticket', $id) }}"
            title="Abrir ticket">
            <i class="fas fa-check"></i>
        </a>
    @endif
</div>
