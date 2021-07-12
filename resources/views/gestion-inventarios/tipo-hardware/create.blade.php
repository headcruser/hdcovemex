@extends('layouts.panel')

@section('title','Crear Tipo de hardware')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Gestion Inventario </li>
        <li class="breadcrumb-item">
            <a href="{{ route('gestion-inventarios.tipo-hardware.index') }}">Tipo de hardware</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>

@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información</h3>
            </div>
            <div class="card-body">

                {!! Form::open([
                    'route'             => 'gestion-inventarios.tipo-hardware.store',
                    'method'            => 'POST',
                    'accept-charset'    => 'UTF-8',
                    'onsubmit'          =>'wait.modal("show")',
                    'enctype'           =>'multipart/form-data']) !!}

                    @include('gestion-inventarios.tipo-hardware.partials._fields')
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function() {
            $('form').submit(function(e){
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

