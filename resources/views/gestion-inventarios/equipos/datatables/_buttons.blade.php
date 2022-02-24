<div class="btn-group btn-group-sm">
    <a class="btn btn-xs btn-primary"
        href="{{ route('gestion-inventarios.equipos.show', $id) }}" title="Ver">
        <i class="far fa-eye"></i>
    </a>

    <a class="btn btn-xs btn-danger"
        data-action="destroy"
        href="{{ route('gestion-inventarios.equipos.destroy', $id) }}" title="Eliminar">
        <i class="fas fa-trash-alt"></i>
    </a>
</div>
