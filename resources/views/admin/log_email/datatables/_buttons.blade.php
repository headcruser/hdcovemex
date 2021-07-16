<div class="btn-group btn-group-sm">
    @permission('log_email_show')
        <a class="btn btn-sm btn-primary" href="{{ route('admin.log-email.show', $id) }}" title="Ver">
            <i class="far fa-eye"></i>
        </a>
    @endpermission


    @permission('log_email_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('admin.log-email.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission
</div>
