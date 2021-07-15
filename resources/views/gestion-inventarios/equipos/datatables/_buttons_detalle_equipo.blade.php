<div class="btn-group btn-group-sm" data-id="{{ $id }}">
    <a class="btn btn-xs btn-info"
        data-action="update"
        data-update="{{ route('gestion-inventarios.equipos.actualizar_componente_equipo',$id) }}"
        href="{{ route('gestion-inventarios.equipos.buscar_componente_equipo',$id) }}" title="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <a class="btn btn-xs btn-danger"
        data-action="destroy"
        href="{{ route('gestion-inventarios.equipos.eliminar_componente_equipo', $id) }}" title="Eliminar">
        <i class="fas fa-trash-alt"></i>
    </a>
</div>
