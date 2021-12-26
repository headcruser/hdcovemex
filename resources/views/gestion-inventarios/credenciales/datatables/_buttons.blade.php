
<div class="btn-group btn-group-sm">

    <div class="input-group">
        <button type="button" class="btn btn-xs btn-primary text-white dropdown-toggle"
            data-toggle="dropdown"
            aria-expanded="false">
            <i class="fa fa-clone"></i>
        </button>
        <div class="dropdown-menu" style="">
            <a class="dropdown-item" data-value="{{ $usuario }}"  href="#">Inicio de sesión</a>
            <a class="dropdown-item" data-value="{{ $contrasenia }}" href="#">Contraseña</a>
        </div>
    </div>

    @permission('credenciales_edit')
        <a class="btn btn-xs btn-info"
            href="{{ route('gestion-inventarios.credenciales.edit', $id) }}" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endpermission

    @permission('credenciales_delete')
        <a class="btn btn-xs btn-danger"
            data-action="destroy"
            href="{{ route('gestion-inventarios.credenciales.destroy', $id) }}" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endpermission


</div>
