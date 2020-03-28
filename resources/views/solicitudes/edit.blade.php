@extends('layouts.panel')

@section('title','Crear Solicitud')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Solicitudes</li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="form-solicitud" method="POST" action="{{ route('solicitudes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">Motivo de la solicitud</div>

                    <div class="card-body">

                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <input id="input-titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" title="Titulo" value="{{ old('titulo',$model->titulo) }}" required autocomplete="off">
                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="incidente">Detalle</label>

                                <textarea class="form-control @error('incidente') is-invalid @enderror" id="ta-incidente" name="incidente" rows="5"  required>{{ old('incidente', $model->incidente) }}</textarea>
                                @error('incidente')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group @error('estatus_id') has-error @enderror">
                                <label for="select-estatus_id">Estado*</label>
                                <select name="esatus_id" id="select-permisos" class="form-control select2"  title="Selecciona un permisos" required>
                                    @foreach($statuses as $id => $status)
                                        <option value="{{ $id }}" {{ (in_array($id,  $statuses) ) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>

                                <div class="help-block with-errors">
                                    @error('')
                                    <span>{{ $errors->first('display_name') }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="attachments">Adjuntar Archivo</label>

                                <div class="row">
                                    <!--UPLOAD BOOSTRAP THEME-->
                                    <!--===================================================-->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input input__file" id="customFile" name="archivo">
                                            <label class="custom-file-label" for="customFile">Elije el archivo</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="file-details" id="file_preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--===================================================-->
                                    <!--END UPLOAD BOOSTRAP THEME-->
                                </div>
                                @error('attachments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                    </div>

                    <div class="card-footer">

                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary " form="form-solicitud"> <i class="fas fa-save"></i> Guardar</button>
                            <button type="reset" class="btn btn-default "><i class="fas fa-trash-alt"></i> Limpiar</button>
                        </div>

                        <a href="{{ route('solicitudes.index') }}" class="btn btn-default"> <i class="fas fa-arrow-left"></i> Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')

@endsection

