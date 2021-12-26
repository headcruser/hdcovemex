@extends('layouts.panel')

@section('title','Crear Reporte')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Gestion Inventario </li>
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
                <p>En esta sección puedes crear un nuevo repore donde podrás llevar el control de las impresiones</p>
                {!! Form::open([
                    'id'                => 'form-crear-impresiones',
                    'route'             => 'gestion-impresiones.impresiones.store',
                    'method'            => 'POST',
                    'accept-charset'    => 'UTF-8',
                    'enctype'           =>'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('mes', 'Mes') !!}
                                {!! Form::select('mes',$meses, today()->subMonth()->month, ['class' => 'form-control','required' => true]) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha de registro') !!}
                                {!! Form::date('fecha', today()->format('Y-m-d'), ['class' => 'form-control','required' => 'true']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                          {!! Form::checkbox('agregar_informacion_impresora', 1, null, ['id' => 'ckb-info-impresora','class' => 'form-check-input']) !!}
                          {!! Form::label('agregar_informacion_impresora', 'Agregar información Impresora') !!}
                        </div>
                      </div>

                    <fieldset id="seccion-impresora" style="{{ (old('agregar_informacion_impresora','0') == '0' )? 'display: none':''  }}">
                        <div class="form-group">
                            {!! Form::label('id_impresora', 'Impresora') !!}
                            {!! Form::select('id_impresora', $impresoras, null, ['class' => 'form-control','data-impresora' => '']) !!}
                        </div>
                        <div class="form-group @error('info') has-error @enderror">
                            {!! Form::label('info', 'Ingresa la información de la impresora') !!}
                            {!! Form::textarea('info', null, ['class' => 'form-control','cols' => '30','rows' => '15','title' => 'Información Impresiones','data-impresora' => '']) !!}
                            <div class="help-block with-errors">
                                @error('info')
                                    <span>{{ $errors->first('info') }}</span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        {!! Form::hidden('anio', today()->format('Y')) !!}
                        {!! Form::hidden('creado_por', auth()->id() ) !!}
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

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function() {
            const $form = $('#form-crear-impresiones');

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

            $("#ckb-info-impresora").change(function(e){
                $("#seccion-impresora").toggle(e.target.checked);
                $("[data-impresora]").attr('required',e.target.checked)
            })
        });

    </script>
@endsection

