<div class="btn-group btn-group-sm">
    {{-- @can('attribute_show') --}}
        <a class="btn btn-sm btn-primary" href="{{ route('gestion-inventarios.impresiones.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    {{-- @endcan --}}

    {{-- @can('attribute_delete') --}}
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('gestion-inventarios.impresiones.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    {{-- @endcan --}}
</div>
