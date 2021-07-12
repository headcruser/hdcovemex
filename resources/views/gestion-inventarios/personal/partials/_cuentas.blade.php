<div class="row d-flex align-items-stretch">
    @foreach ($personal->cuentas as $cuenta)
        <div class="col-3" data-object="{{ $cuenta }}">
            <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                {{ $cuenta->titulo }}
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-12">
                    <p class="text-muted text-sm">{!! $cuenta->descripcion !!} </p>
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button data-option="eliminar" data-url="{{ route('gestion-inventarios.personal.eliminar_cuenta',$cuenta) }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                    <button data-option="editar" data-url="{{ route('gestion-inventarios.personal.actualizar_cuenta',$cuenta) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil-alt"></i> Editar
                    </button>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>
