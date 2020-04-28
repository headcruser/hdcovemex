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

                                <form class="mt-3" action="{{ route('operador.tickets.storeComentario', $model->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="ta-comentario_texto">Deja un comentario</label>
                                        <textarea class="form-control @error('comentario_texto') is-invalid @enderror" id="ta-comentario_texto" name="comentario_texto" rows="3" required>{{ old('comentario_texto','') }}</textarea>

                                        <div id="login-help" class="error invalid-feedback">
                                            @error('comentario_texto') {{ $message }} @enderror
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar</button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                    </tbody>
                </table>


            </div>

            <div class="card-footer">
                <a class="btn btn-default" href="{{ route('operador.tickets.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

