@extends('layouts.panel')

@section('title','Editar Reporte')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Gestion Impresiones</li>
        <li class="breadcrumb-item">
            <a href="{{ route('gestion-impresiones.impresiones.index') }}">Impresiones</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del reporte</h3>
                </div>
                <div class="card-body">
                    <p>En esta sección puedes editar la información del reporte</p>

                    {!! Form::model($impresion ,[
                        'id'                => 'form-impresiones',
                        'route'             => ['gestion-impresiones.impresiones.update',$impresion],
                        'method'            => 'PUT',
                        'accept-charset'    => 'UTF-8',
                        'enctype'           =>'multipart/form-data']) !!}

                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('mes', 'Mes') !!}
                                    {!! Form::select('mes',$meses, null, ['class' => 'form-control','required' => true]) !!}
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('fecha', 'Fecha de registro') !!}
                                    {!! Form::date('fecha', null, ['class' => 'form-control','required' => 'true']) !!}
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('anio', 'Año') !!}
                                    {!! Form::number('anio',null, ['class' => 'form-control','required' => 'true']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function() {
            const $form = $('#form-impresiones');

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
@endpush

