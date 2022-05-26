<div class="btn-group btn-group-sm">
    @permission('faq_categorias_edit')
        <a class="btn btn-sm btn-info"
            href="{{ route('admin.faqs.categorias.edit', $id) }}"
            title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('faq_categorias_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.faqs.categorias.destroy', $id) }}"
            title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
