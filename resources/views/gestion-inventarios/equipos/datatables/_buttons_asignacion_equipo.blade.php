 <div class="btn-group btn-group-sm">
    <a class="btn btn-xs btn-info"
        data-action="editar-asignacion"
        data-object="{{ $model }}"
        href="{{ route('gestion-inventarios.equipos.editar_asignar_equipo',$id) }}"
        title="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <a class="btn btn-xs btn-danger"
        data-action="eliminar-asignacion"
        href="{{ route('gestion-inventarios.equipos.eliminar_asignar_equipo',$id) }}"
        title="Eliminar">
        <i class="fas fa-trash-alt"></i>
    </a>
</div>
