
<div class="btn-group btn-group-sm">

    <a class="btn btn-xs btn-info"
        href="{{ route('gestion-inventarios.sucursales.edit', $id) }}" title="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <a class="btn btn-xs btn-danger"
        data-action="destroy"
        href="{{ route('gestion-inventarios.sucursales.destroy', $id) }}" title="Eliminar">
        <i class="fas fa-trash-alt"></i>
    </a>
</div>
