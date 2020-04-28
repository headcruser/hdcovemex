@extends('layouts.panel')

@section('title','Editar Solicitud')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Administración</li>
    <li class="breadcrumb-item">
        <a href="{{ route('operador.gestion-solicitudes.index') }}">Solicitudes</a>
    </li>
    <li class="breadcrumb-item active">Editar</li>
</ol>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="col-md-12">
            <form id="form-solicitud" method="POST" action="{{ route('operador.gestion-solicitudes.update',$model) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        Solicitud de soporte # {{ $model->id }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4>Información del usuario</h4>
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

                        <div class="form-group">
                            <label for="titulo">Estatus</label>
                            <span class="badge badge-primary text-sm"  style="background-color:{{ $model->status->color }}">
                                {{ $model->status->display_name }}
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="titulo">Titulo</label>
                            <input id="input-titulo"
                                type="text"
                                class="form-control"
                                name="titulo"
                                title="Titulo"
                                aria-describedby="titulo-help"
                                value="{{ old('titulo',$model->titulo) }}" autocomplete="off" readonly>
                        </div>



                        <div class="form-group">
                            <label for="incidente">Incidente</label>

                            <textarea  id="ta-incidente"
                                name="incidente"
                                title="Incidente"
                                class="form-control"
                                aria-describedby="incidente-help"
                                rows="5"
                                readonly>{{ old('incidente', $model->incidente) }}</textarea>
                        </div>

                        @if($model->adjunto)
                        <div class="form-group">
                            <label for="input-file-archivo">Adjuntar Archivo</label>

                            <div class="row">
                                <!--UPLOAD BOOSTRAP THEME-->
                                <!--===================================================-->
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-details" id="file_preview">

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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="archivo-help" class="error invalid-feedback">
                                @error('archivo') {{ $message }} @enderror
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        {{-- MODIFICAR MODELO PARA REPRESENTAR ESTO MEJOR --}}
                        @if($model->estatus_id == 1 )
                            <div class="btn-group float-right" id="input-group-submit">
                                <span class="icon-input-btn">
                                    <span class="fa fa-file text-white"></span> <input type="submit" class="btn btn-primary" name="abrir-ticket"  data-action="ticket" value="Abrir ticket">

                                <span class="icon-input-btn">
                                    <span class="fa fa-window-close"></span> <input type="submit" class="btn btn-default" name="cancelar-solicitud" data-action="solicitud" value="Cancelar S.">
                                </span>
                            </div>
                        @endif

                        <a href="{{ route('operador.gestion-solicitudes.index') }}" class="btn btn-default"> <i class="fas fa-arrow-left"></i> Regresar</a>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>

    const solicitudModule = (function () {

        const form = document.getElementById('form-solicitud'),
              submitList = form.querySelectorAll('input[type="submit"]');

        const messages = {
            solicitud: {
                'title' : '¿Deseas cancelar la solicitud?',
                'html'  : 'La solicitud será <b>cancelada</b>',
                'confirm': 'Si, Cancelar solicitud'
            },
            ticket:{
                'title' : '¿Deseas abrir un ticket?',
                'html'  : 'La solicitud sera asignada a un <b>ticket</b>,',
                'confirm': 'Si, Abrir Ticket!'
            }
        };

        function bindSubmitHandler(e) {
            this.form.submitValue = this.value;
            this.form.actionEvent = this.dataset.action;
            this.form.inputName = this.name;
        }

        function assignEvents() {
            for (let i = 0; i < submitList.length; i++) {
                el = submitList[i];

                if (el.type === 'submit') {
                    el.onclick = bindSubmitHandler;
                }
            }

            form.onsubmit = onsubmitHandler;
        }

        async function onsubmitHandler(e) {
            e.preventDefault();
            let submitValue = this.submitValue,
                message = messages[this.actionEvent],
                form = this;


            const { value: result } = await Swal.fire({
                type:'question',
                title: message.title,
                html: message.html,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: message.confirm,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
            });

            if(!result){
                return false;
            }

            var input = createInputHidden(this.inputName,submitValue)
            form.appendChild(input);
            form.submit()
        }

        function createInputHidden(name,value) {
            let input = document.createElement("input");

            input.setAttribute("type", "hidden");
            input.setAttribute("name", name);
            input.setAttribute("value", value );

            return input;
        }



        assignEvents();
    }());
</script>
@endsection

