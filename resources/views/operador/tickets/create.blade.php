@extends('layouts.panel')

@section('title','Crear Ticket')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('operador.tickets.index') }}">Tickets</a>
        </li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="form-solicitud" method="POST" action="{{ route('operador.tickets.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">Motivo Ticket</div>

                    <div class="card-body">
                        <fieldset class="section-border">
                            <legend class="section-border">Datos del ticket</legend>

                            <div class="form-group">
                                <label for="input-titulo">Titulo</label>
                                <input id="input-titulo"
                                    name="titulo"
                                    type="text"
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    title="Titulo"
                                    aria-describedby="titulo-help"
                                    value="{{ old('titulo',$model->titulo) }}" autocomplete="off" required >

                                <div id="titulo-help" class="error invalid-feedback">
                                    @error('titulo') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ta-incidente">Observacion</label>

                                <textarea class="form-control @error('incidente') is-invalid @enderror"
                                    id="ta-incidente"
                                    name="incidente"
                                    aria-describedby="incidente-help"
                                    rows="5"  required>{{ old('incidente',$model->incidente) }}</textarea>

                                <div id="incidente-help" class="error invalid-feedback">
                                    @error('observacion') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="attachments">Adjuntar Archivo</label>

                                <div class="row">
                                    <!--UPLOAD BOOSTRAP THEME-->
                                    <!--===================================================-->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input input__file" id="input-file-archivo" name="archivo">
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
                        </fieldset>

                        <fieldset class="section-border">
                            <legend class="section-border">Información adicional</legend>

                            <div class="row">
                                <!-- PRIORIDAD -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="select-prioridad">Prioridad</label>
                                        <select class="custom-select" name="prioridad" id="select-prioridad">
                                            @foreach ($prioridad as $key => $value)
                                                <option value="{{ $key }}" @if( old('prioridad','Baja') == 'Baja') selected @endif >{{ $key }} - {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- ESTATUS -->
                                <div class="col-sm-6">
                                    {{-- CAMBIAR AL ESTATUS SOLO EN FINALIZADO Y CANCELADO --}}
                                    <div class="form-group">
                                        <label for="select-estado">Estatus</label>
                                        <select class="custom-select" name="estado" id="select-estado">
                                            @foreach ($estados as $key => $value)
                                                <option value="{{ $key }}" @if( old('estado', $model->estado) == $key) selected @endif >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- TIPO ATENCION -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="select-tipo" >Atención</label>
                                        <select class="custom-select" name="tipo" id="select-tipo">
                                            <option value="" >Selecciona el tipo de atención</option>
                                            @foreach ($tipo_contacto as $key => $value)
                                                <option value="{{ $value }}" @if( old('tipo',$model->tipo) == $value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- SUBTIPO|ACTIVIDAD -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="select-subtipo" >Actividad</label>
                                        <select class="custom-select" name="sub_tipo" id="select-subtipo">
                                            @foreach ($actividad as $key => $value)
                                                <option value="{{ $value }}" @if(old('sub_tipo',$model->sub_tipo) == $value ) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- ASIGNADO -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="select-asignado_a" >Asignado a </label>
                                        <select class="custom-select" name="asignado_a" id="select-asignado_a">
                                            <option value="" >Selecciona a un operador</option>
                                            @foreach ($asignado as $key => $value)
                                                <option value="{{ $key }}" @if(old('asignado_a',$model->asignado_a) == $value ) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- CONTACTO -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="select-prioridad">Contacto</label>
                                        <select class="custom-select" name="contacto" id="select-contacto">
                                            @foreach ($contacto as $key => $value)
                                                <option value="{{ $key }}" @if( old('contacto','Personal') == 'Personal') selected @endif >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <!-- VISIBILIDAD -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label >Visibilidad mensajes</label>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="privado" id="ckb-privado" value="S" @if(old('privado',$model->privado) == 'S') checked @endif>
                                            <label for="ckb-privado" class="custom-control-label">Privado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-footer">

                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary " form="form-solicitud"> <i class="fas fa-save"></i> Guardar</button>
                            <button type="reset" class="btn btn-default"><i class="fas fa-trash-alt"></i> Limpiar</button>
                        </div>

                        <a href="{{ route('operador.tickets.index') }}" class="btn btn-default"> <i class="fas fa-arrow-left"></i> Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')
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

        const selectElement = (function(element){

            if(!element || !element instanceof HTMLElement){
                throw "Select no es un elemento HTML"
            }

            let select = element;


			function addOption(text = '',value = '',attrs = [] )
			{
				let option = document.createElement("option");
				option.text = text;
				option.value = value;

				select.add(option, '');

                for (let attr of Object.keys(attrs) ) {
                    option.setAttribute(attr, attrs[attr]);
                }
			}

			function clearOptions()
			{
				let options = Array.from(select.options);

				options.forEach(option => {
					option.remove();
					option.selected = false;
				});
            }

            function addFromCollection(collection) {
                for (let key in collection) {
                    if (collection[key].hasOwnProperty('text') && collection[key].hasOwnProperty('value')) {
                        addOption( collection[key]['text'],collection[key]['value']);
                    }
                }
            }

            return {addOption,clearOptions,addFromCollection};

        })


        const createTicket = (function(){

            const dom = {
                'select_tipo':document.getElementById('select-tipo'),
                'select_subtipo':document.getElementById('select-subtipo')
            }
            const apiSubtipo = "{{ route('api.attributes.subtipo') }}" ;
            const objectSelectSubtipo = new selectElement(dom.select_subtipo);


            // Events
            dom.select_tipo.addEventListener('change',async function(e){
                let element = e.target;
                let value =  element.options[element.selectedIndex].value

                if (!value) {
                    objectSelectSubtipo.clearOptions();
                    objectSelectSubtipo.addOption('Selecciona antes el tipo de atención','',{"selected":"selected"});
                    return;
                }

                try {
                    const response  = await axios.post(apiSubtipo,{
                        tipo: value
                    })

                    let subList = response.data.list;

                    let listElements = subList.map(function(element){
                        var object = [];

                        object['text'] = element.value;
                        object['value'] =element.value;

                        return object
                    });

                    objectSelectSubtipo.clearOptions();
                    objectSelectSubtipo.addFromCollection(listElements);
                    objectSelectSubtipo.addOption('Selecciona el tipo de atención','',{"selected":"selected"});

                } catch (error) {
                    if(error.response){
                        console.log(error.response)
                    }else{
                        console.error(error)
                    }
                }
            });


        })()
    </script>
@endsection

