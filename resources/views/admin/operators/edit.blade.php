@extends('layouts.panel')

@section('title','Editar Operador')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Administración </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.operadores.index') }}">Operadores</a>
    </li>
    <li class="breadcrumb-item active">Operador #{{ $model->id }}</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del operador</h3>
            </div>
            <div class="card-body">
                <form id="form-editar-operador" action="{{ route("admin.operadores.update", $model) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('admin.operators.partials._fields')
                    <div>
                        <a class="btn btn-default" href="{{ route('admin.operadores.index') }}">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Guardar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function() {
        const $form = $('#form-editar-operador');

        $form.submit(function(e){
            Swal.fire({
                title: 'Procesando',
                html: 'Espere un momento por favor.',
                allowEscapeKey:false,
                allowOutsideClick:false,
                allowEnterKey:false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            })
        });
    });

</script>
@endsection

