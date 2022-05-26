<div class="btn-group btn-group-sm">
    {{-- @can('attribute_show') --}}
        <a class="btn btn-sm btn-primary" href="{{ route('gestion-impresiones.impresoras.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    {{-- @endcan --}}

    {{-- @can('attribute_edit') --}}
        <a class="btn btn-sm btn-info" href="{{ route('gestion-impresiones.impresoras.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    {{-- @endcan --}}

    {{-- @can('attribute_delete') --}}
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('gestion-impresiones.impresoras.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    {{-- @endcan --}}
</div>
