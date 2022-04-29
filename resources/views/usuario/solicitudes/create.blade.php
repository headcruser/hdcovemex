@extends('layouts.panel')

@section('title','Crear Solicitud')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
                <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('solicitudes.index') }}">Solicitudes</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!--SECCION INFORMACION DE USUARIO -->
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-user"></i> Datos del usuario
                                    <small class="float-right">fecha: {{ now()->format('d/m/Y') }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <strong>Nombre</strong> <br>
                                <strong>Telefono</strong><br>
                                <strong>Correo Electrónico</strong><br>
                                <strong>Departamento</strong><br>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                {{ auth()->user()->nombre }} ({{ auth()->user()->usuario }}) <br>
                                {{ auth()->user()->telefono }} <br>
                                {{ auth()->user()->email }} <br>
                                {{ auth()->user()->departamento->nombre }} <br>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!--SECCION SOLICITUD  -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <form id="form-solicitud" method="POST" action="{{ route('solicitudes.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">Motivo de la solicitud</div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="input-titulo">Titulo</label>
                                    <input id="input-titulo" name="titulo" type="text"
                                        class="form-control @error('titulo') is-invalid @enderror" title="Titulo"
                                        aria-describedby="titulo-help" value="{{ old('titulo') }}" autocomplete="off" required>

                                    <div id="titulo-help" class="error invalid-feedback">
                                        @error('titulo') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="incidente">Detalle</label>

                                    <textarea class="form-control @error('incidente') is-invalid @enderror" id="ta-incidente"
                                        name="incidente" aria-describedby="incidente-help" rows="5"
                                        required>{{ old('incidente') }}</textarea>

                                    <div id="incidente-help" class="error invalid-feedback">
                                        @error('incidente') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="attachments">Adjuntar Archivo</label>

                                    <div class="row">
                                        <!--UPLOAD BOOSTRAP THEME-->
                                        <!--===================================================-->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input input__file" id="input-file-archivo"
                                                    name="archivo">
                                                <label class="custom-file-label" for="input-file-archivo">Elije el archivo</label>
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

                                    <div id="archivo-help" class="error invalid-feedback">
                                        @error('archivo') {{ $message }} @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">

                                <div class="btn-group float-right">
                                    <button type="submit" class="btn btn-primary " form="form-solicitud"> <i
                                            class="fas fa-save"></i> Guardar</button>
                                    <button type="reset" class="btn btn-default"><i class="fas fa-trash-alt"></i> Limpiar</button>
                                </div>

                                <a href="{{ route('solicitudes.index') }}" class="btn btn-default"> <i
                                        class="fas fa-arrow-left"></i> Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const uploadFile = (function(){

            const container = document.getElementById('file_preview'),
                form = document.getElementById('form-solicitud')
                removeFile = document.getElementById('remove_file'),
                inputFile = document.getElementById('input-file-archivo');


            $(inputFile).change(function(e){
                var firstFile = this.files[0],
                    template = previewTemplate(firstFile);

                clearContainerFile()
                container.insertAdjacentHTML('beforeend',template);
            })

            $(form).bind("reset", function() {
                clearContainerFile()
            });

            $(removeFile).on('click',function(e){
                clearContainerFile()
            })

            function clearContainerFile(){
                container.innerHTML = null;
            }

            function parseFile(infoFile, fsExt = ['Bytes', 'KB', 'MB', 'GB'])
            {
                var _size = infoFile.size,
                indexFsExt =0;

                while( _size > 900) {
                    _size/= 1024;
                    indexFsExt ++;
                }

                return {
                    name:infoFile.name,
                    size: (Math.round(_size*100)/100),
                    fsExt: fsExt[indexFsExt]
                }
            }

            function previewTemplate(file)
            {
                var infoFile =  parseFile(file);
                return `
                <div class="media">
                    <div class="media-body">
                        <div class="media-block">
                            <div class="media-left">
                                <i class="fas fa-file" style='font-size: 2.5em'></i>
                            </div>
                            <div class="media-body mar-top pad-lft">
                                <p class="text-main text-bold mar-no text-overflow">${infoFile.name}</p>
                                <span class="text-danger text-sm"></span>
                                <p class="text-sm font-weight-light">${infoFile.size} ${infoFile.fsExt}</p>
                            </div>
                        </div>
                    </div>
                </div>`;
            }
        })();

        const $form = $('#form-solicitud');

        $form.submit(function(e){
            Swal.fire({
                title: 'Procesando solicitud!',
                html: 'Espere un momento por favor.',
                allowEscapeKey:false,
                allowOutsideClick:false,
                allowEnterKey:false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            })
        });
    </script>
@endpush
