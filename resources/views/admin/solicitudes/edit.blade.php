@extends('layouts.panel')

@section('title','Editar Solicitud')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Administración</li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.solicitudes.index') }}">Solicitudes</a>
    </li>
    <li class="breadcrumb-item active">Editar</li>
</ol>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="form-solicitud" method="POST" action="{{ route('admin.solicitudes.update',$model) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        Motivo de la solicitud
                    </div>

                    <div class="card-body">

                            <div class="form-group">
                                <label for="titulo">Titulo*</label>
                                <input id="input-titulo"
                                    type="text"
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    name="titulo"
                                    title="Titulo"
                                    aria-describedby="titulo-help"
                                    value="{{ old('titulo',$model->titulo) }}"  autocomplete="off" required>

                                <div id="titulo-help" class="error invalid-feedback">
                                    @error('titulo') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="incidente">Detalle</label>

                                <textarea  id="ta-incidente"
                                    name="incidente"
                                    title="Incidente"
                                    class="form-control @error('incidente') is-invalid @enderror"
                                    aria-describedby="incidente-help"
                                    rows="5"  required>{{ old('incidente', $model->incidente) }}</textarea>

                                <div id="incidente-help" class="error invalid-feedback">
                                    @error('incidente') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-file-archivo">Adjuntar Archivo</label>

                                <div class="row">
                                    <!--UPLOAD BOOSTRAP THEME-->
                                    <!--===================================================-->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="custom-file">
                                            <input id="input-file-archivo"
                                                    name="archivo"
                                                    type="file"
                                                    class="custom-file-input input__file"
                                                    aria-describedby="archivo-help" >
                                            <label class="custom-file-label" for="input-file-archivo">Elije el archivo</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="file-details" id="file_preview">
                                                    @if($model->adjunto)
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <div class="media-block">
                                                                    <div class="media-left">
                                                                        <i class="fas fa-file" style='font-size: 2.5em'></i>
                                                                    </div>
                                                                    <div class="media-body mar-top pad-lft">
                                                                        <p class="text-main text-bold mar-no text-overflow"><a class="linked" href="{{ route('solicitudes.archivo',$model) }}" target="_blank">{{ $model->nombre_adjunto }}</a></p>
                                                                        <span class="text-danger text-sm"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--===================================================-->
                                    <!--END UPLOAD BOOSTRAP THEME-->
                                </div>

                                <div id="archivo-help" class="error invalid-feedback">
                                    @error('archivo') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select-estatus_id">Estatus*</label>
                                <select id="select-permisos"
                                    name="esatus_id"
                                    class="form-control select2 @error('incidente') is-invalid @enderror"
                                    aria-describedby="estatus_id-help"
                                    title="Selecciona un permisos" required>
                                    @foreach($statuses as $id => $status)
                                        <option value="{{ $id }}" {{ (in_array($id,  $statuses) ) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div id="estatus_id-help" class="error invalid-feedback">
                                    @error('estatus_id') {{ $message }} @enderror
                                </div>
                            </div>
                    </div>

                    <div class="card-footer">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary " form="form-solicitud"> <i class="fas fa-save"></i> Guardar</button>
                            <button type="reset" class="btn btn-default "><i class="fas fa-trash-alt"></i> Limpiar</button>
                        </div>
                        <a href="{{ route('admin.solicitudes.index') }}" class="btn btn-default"> <i class="fas fa-arrow-left"></i> Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')

@endsection

