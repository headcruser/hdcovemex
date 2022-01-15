<div class="row d-flex align-items-stretch">
    @foreach ($personal->cuentas as $cuenta)
        <div class="col" data-object="{{ $cuenta }}">
            <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                {{ $cuenta->titulo }}
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-12">
                    <p class="text-muted text-sm">{!! $cuenta->usuario !!} </p>
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <div class="btn-group btn-group-sm">
                        <div class="input-group">
                            <button type="button" class="btn btn-sm btn-dark text-white dropdown-toggle"
                                data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa fa-clone"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item clipboard" data-clipboard-text="{{ $cuenta->usuario }}"  href="#">Usuario</a>
                                <a class="dropdown-item clipboard" data-clipboard-text="{{ $cuenta->contrasenia }}" href="#">Contraseña</a>
                            </div>
                        </div>
                        <button data-option="editar" title="Editar" data-url="{{ route('gestion-inventarios.personal.actualizar_cuenta',$cuenta) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-pencil-alt"></i>
                        </button>

                        <button data-option="eliminar" title="Eliminar" data-url="{{ route('gestion-inventarios.personal.eliminar_cuenta',$cuenta) }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>
