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
                                </div>
                            </fieldset>
                        @endif

                        <fieldset class="section-border">
                            <legend class="section-border">Datos del ticket</legend>

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
                                <label for="incidente">Incidente</label>

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
                        </fieldset>


                        <fieldset class="section-border">
                            <legend class="section-border">Información adicional</legend>

                            <div class="row">
                                <!-- PRIORIDAD -->
                                <div class="col-sm-6">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo Contacto</label>
                                        <select class="custom-select" name="contacto">
                                            @foreach ($tipo_contacto as $key => $value)
                                                <option value="{{ $value }}" @if($model->tipo == $value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- VISIBILIDAD -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Visibilidad mensajes</label>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="privado" id="privado" value="S" @if($model->privado == 'S') checked @endif>
                                            <label for="privado" class="custom-control-label">Privado</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ESTATUS -->
                                <div class="col-sm-6">
                                    {{-- CAMBIAR AL ESTATUS SOLO EN FINALIZADO Y CANCELADO --}}
                                    <div class="form-group">
                                        <label for="estatus">Estatus</label>
                                        <select class="custom-select" name="estado">
                                            @foreach ($estados as $key => $value)
                                                <option value="{{ $key }}" @if($model->estado == $key) selected @endif >{{ $value }}</option>
                                            @endforeach
                                        </select>
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

@endsection

