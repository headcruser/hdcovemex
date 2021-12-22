@extends('layouts.panel')

@section('title','Editar Ticket')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('operador.tickets.index') }}">Tickets</a>
    </li>
    <li class="breadcrumb-item active">Editar</li>
</ol>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="form-ticket" method="POST" action="{{ route('operador.tickets.update',$model) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Ticket #{{ $model->id }}</div>
                        <div class="card-tools">
                            <div class="card-title">
                                Fecha: {{ $model->fecha->format('d/m/Y h:i:s ') }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- MOSTRAR SOLO SI SE ASIGNO UN TICKET UNA SOLICITUD --}}
                        @if($model->solicitud)
                            <fieldset class="section-border">
                                <legend class="section-border">Actividad</legend>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>Solicitud <strong>#{{ $model->solicitud->id }}</strong></h4>
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="{{ $model->empleado->avatar }}" alt="user_{{ $model->empleado->usuario }}">
                                                    <span class="username">
                                                        <a href="#">{{ $model->empleado->nombre }}</a>
                                                    </span>
                                                    <span class="description"><i class="fas fa-home"></i> {{ $model->empleado->departamento->nombre }} | <i class="fas fa-envelope"></i> {{ $model->empleado->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label>Titulo*</label>
                                        <input
                                            type="text"
                                            title="Titulo"
                                            class="form-control"
                                            readonly
                                            aria-describedby="titulo-help"
                                            value="{{ old('titulo',$model->solicitud->titulo) }}"  autocomplete="off" required>
                                    </div>

                                    <div class="form-group row">
                                        <label for="incidente">Incidente</label>
                                        <textarea
                                            title="Incidente"
                                            class="form-control"
                                            aria-describedby="incidente-help"
                                            readonly
                                            rows="5"  required>{{ old('incidente', $model->solicitud->incidente) }}</textarea>
                                    </div>

                                    @if($model->solicitud->media->exists)
                                        <div class="form-group">
                                            <label>Adjunto</label>
                                            <p>
                                                <a href="{{ route('operador.gestion-solicitudes.archivo',$model->solicitud) }}" target="_blank" class="linked text-sm"><i class="fas fa-link mr-1"></i> {{ $model->solicitud->media->name }} </a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        @endif

                        <fieldset class="section-border">
                            <legend class="section-border">Datos del ticket</legend>

                            <div class="form-group">
                                <label for="incidente">Incidente</label>

                                <textarea  id="ta-incidente"
                                    name="incidente"
                                    title="Incidente"
                                    class="form-control @error('incidente') is-invalid @enderror"
                                    aria-describedby="incidente-help"
                                    placeholder="Describe el incidente"
                                    readonly
                                    rows="2" >{{ old('incidente', $model->incidente) }}</textarea>

                                <div id="incidente-help" class="error invalid-feedback">
                                    @error('incidente') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comentario">Comentario</label>

                                <textarea  id="ta-comentario"
                                    name="comentario"
                                    title="comentario"
                                    class="form-control @error('comentario') is-invalid @enderror"
                                    aria-describedby="comentario-help"
                                    placeholder="Escribe tu observación"
                                    rows="5" >{{ old('comentario', '') }}</textarea>

                                <div id="comentario-help" class="error invalid-feedback">
                                    @error('comentario') {{ $message }} @enderror
                                </div>
                            </div>
                        </fieldset>


                        <fieldset class="section-border">
                            <legend class="section-border">Información adicional</legend>

                            <div class="row">
                                <!-- PRIORIDAD -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Prioridad</label>
                                        <select class="custom-select" name="prioridad">
                                            @foreach ($prioridad as $key => $value)
                                                <option value="{{ $key }}" @if($value == 'Baja') selected @endif >{{ $key }} - {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- TIPO_CONTACTO -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipo Actividad</label>
                                        <select class="custom-select" name="contacto" id="select-tipo">
                                            @foreach ($tipo_contacto as $key => $value)
                                                <option value="{{ $value }}" @if(old('contacto',$model->tipo) == $value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- SUBTIPO|ACTIVIDAD -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="select-subtipo" >Actividad</label>
                                        <select class="custom-select" name="sub_tipo" id="select-subtipo">
                                            @foreach ($actividad as $key => $value)
                                                <option value="{{ $value }}" @if(old('sub_tipo',$model->sub_tipo) == $value ) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- VISIBILIDAD -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Proceso</label>
                                        <select class="custom-select" name="proceso" id="s-proceso">
                                            @foreach ($procesos as $key => $value)
                                                <option value="{{ $value }}" @if($model->proceso == $value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- ESTATUS -->
                                <div class="col-sm-6">
                                    {{-- CAMBIAR AL ESTATUS SOLO EN FINALIZADO Y CANCELADO --}}
                                    <div class="form-group">
                                        <label for="estatus">Estatus</label>
                                        <select class="custom-select" name="estado">
                                            @foreach ($estados as $key => $value)
                                                <option value="{{ $key }}" @if(old('estado',$model->estado) == $key) selected @endif >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Visibilidad mensajes</label>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="privado" id="privado" value="S" @if($model->privado == 'S') checked @endif>
                                            <label for="privado" class="custom-control-label">Privado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>

                    <div class="card-footer">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary" form="form-ticket"> <i class="fas fa-save"></i> Guardar</button>
                        </div>
                        <a href="{{ route('operador.tickets.index') }}" class="btn btn-default"> <i class="fas fa-arrow-left"></i> Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
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

        const editTicket = (function(){
            const d = document;

            const dom = {
                'select_tipo':d.getElementById('select-tipo'),
                'select_subtipo':d.getElementById('select-subtipo'),
                'form_ticket': d.getElementById('form-ticket'),
            },
            apiSubtipo = "{{ route('api.attributes.subtipo') }}",
            objectSelectSubtipo = new selectElement(dom.select_subtipo);

            // Events
            d.addEventListener('change',async function(e) {
                if (dom.select_tipo == e.target) {

                    let element = e.target,
                        value =  element.options[element.selectedIndex].value

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
                        console.error(error);
                    }
                }
            });

            d.addEventListener('submit',function(e){
                if(dom.form_ticket === e.target){
                    Swal.fire({
                        title: 'Procesando ticket',
                        html: 'Espere un momento por favor.',
                        allowEscapeKey:false,
                        allowOutsideClick:false,
                        allowEnterKey:false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    })
                }
            });

        })()
    </script>
@endsection

