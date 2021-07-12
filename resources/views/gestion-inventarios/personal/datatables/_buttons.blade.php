
<div class="btn-group btn-group-sm">
    <a class="btn btn-xs btn-primary"
        href="{{ route('gestion-inventarios.personal.show', $id) }}" title="Ver">
        <i class="far fa-eye"></i>
    </a>

    <a class="btn btn-xs btn-info"
        href="{{ route('gestion-inventarios.personal.edit', $id) }}"
        title="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <a class="btn btn-xs btn-danger"
        data-action="destroy"
        href="{{ route('gestion-inventarios.personal.destroy', $id) }}"
        title="Eliminar">
        <i class="fas fa-trash-alt"></i>
    </a>
</div>
