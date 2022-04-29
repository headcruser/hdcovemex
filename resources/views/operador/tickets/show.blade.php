@extends('layouts.panel')

@section('title','Ver ticket')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('operador.tickets.index') }}">Tickets</a>
        </li>
        <li class="breadcrumb-item active">Ticket #{{ $model->id }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag"></i>
                        Detalle Ticket
                    </h3>
                </div>

                <div class="card-body">

                    @if($model->solicitud)
                    <fieldset class="section-border">
                        <legend class="section-border">Referencia Solicitud</legend>
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

                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <td>
                                    {{ $model->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    PRIORIDAD
                                </th>
                                <td style="background-color:{{ $model->colorPrioridad }}">
                                    <strong>{{ $model->nombrePrioridad }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    FECHA
                                </th>
                                <td>
                                    {{ $model->fecha->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    USUARIO
                                </th>

                                <td>
                                ({{ $model->empleado->usuario }}) {{ $model->empleado->nombre }}
                                </td>

                            </tr>
                            <tr>
                                <th>
                                    DEPARTAMENTO
                                </th>
                                <td>
                                    {{ $model->empleado->departamento->nombre }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    TITULO
                                </th>
                                <td>
                                    {{ $model->titulo }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    INCIDENTE
                                </th>
                                <td>
                                    {{ $model->incidente }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    ESTADO
                                </th>
                                <td>
                                    <span class="badge badge-primary text-sm">
                                        {{ $model->estado }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    COMENTARIOS
                                </th>
                                <td>
                                    <div style="height: 300px;overflow-y:auto;overflow-x:hidden">
                                        @forelse ($model->sigoTicket as $comentario)
                                            <div class="row">
                                                <div class="col">
                                                    <p class="font-weight-bold"><a href="mailto:  ">{{ $comentario->autor }}</a> ({{ $comentario->fecha }})</p>
                                                    <p>{{ $comentario->comentario }}</p>
                                                </div>
                                            </div>
                                            <hr />
                                        @empty
                                            <div class="row">
                                                <div class="col">
                                                    <p>No hay comentarios.</p>
                                                </div>
                                            </div>
                                            <hr />
                                        @endforelse
                                    </div>

                                    @if($model->estado == config('helpdesk.tickets.estado.alias.ABT'))
                                        <form id="form-comentario" class="mt-3" action="{{ route('operador.tickets.storeComentario', $model->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="ta-comentario_texto">Deja un comentario</label>
                                                <textarea class="form-control @error('comentario_texto') is-invalid @enderror" id="ta-comentario_texto" name="comentario_texto" rows="3" required>{{ old('comentario_texto','') }}</textarea>

                                                <div id="login-help" class="error invalid-feedback">
                                                    @error('comentario_texto') {{ $message }} @enderror
                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <button type="submit" class="btn btn-secondary"><i class="fas fa-paper-plane"></i> Enviar</button>
                                            </div>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">

                    @if($model->estado === config('helpdesk.tickets.estado.alias.ABT'))
                        <a class="btn btn-primary float-right" href="{{ route('operador.tickets.edit', $model) }}">
                            <i class="fas fa-pencil-alt"></i> Editar
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const $form = $('#form-comentario');

        $form.submit(function(e){
            Swal.fire({
                title: 'Procesando comentario',
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

