<div class="btn-group btn-group-sm">
    @permission('ticket_show')
        <a class="btn btn-sm btn-primary"
            href="{{ route('operador.tickets.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission



    @if($proceso == config('helpdesk.tickets.proceso.alias.EPS'))
        @permission('ticket_edit')
            <a class="btn btn-sm btn-info" href="{{ route('operador.tickets.edit', $id) }}"
                title="Editar">
                <i class="fas fa-pencil-alt"></i>
            </a>
        @endpermission

        @permission('ticket_delete')
            <a class="btn btn-xs btn-danger"
                data-action="destroy"
                href="{{ route('operador.tickets.destroy', $id) }}" title="Eliminar">
                <i class="fas fa-trash-alt"></i>
            </a>
        @endpermission

        <a class="btn btn-xs btn-dark"
            data-action="cancelar-ticket"
            href="{{ route('operador.tickets.cancelar-ticket', $id) }}"
            title="Cancelar">
            <i class="fas fa-times"></i>
        </a>

        <a class="btn btn-xs btn-success"
            data-action="finalizar-ticket"
            href="{{ route('operador.tickets.finalizar-ticket', $id) }}"
            title="Finalizar">
            <i class="fas fa-check"></i>
        </a>
    @endif
</div>
