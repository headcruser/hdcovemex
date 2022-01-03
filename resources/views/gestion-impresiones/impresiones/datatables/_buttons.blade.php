<div class="btn-group btn-group-sm">
    {{-- @can('attribute_show') --}}
        <a class="btn btn-sm btn-primary" href="{{ route('gestion-impresiones.impresiones.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    {{-- @endcan --}}

    <a class="btn btn-sm btn-info"
        href="{{ route('gestion-impresiones.impresiones.edit', $id) }}"
        title="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>

    {{-- @can('attribute_delete') --}}
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            title="Eliminar"
            href="{{ route('gestion-impresiones.impresiones.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    {{-- @endcan --}}
</div>
