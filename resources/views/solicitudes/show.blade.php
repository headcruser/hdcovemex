@extends('layouts.panel')

@section('title','Ver Solicitud')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('solicitudes.index') }}">Solicitudes</a>
        </li>
        <li class="breadcrumb-item active">Solicitud #{{ $model->id }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tag"></i>
                    Detalle solicitud
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
                                ESTATUS
                            </th>
                            <td>
                                <span class="badge badge-primary">
                                    {{ $model->status->display_name }}
                                </span>
                            </td>
                        </tr>


                        @isset($model->adjunto)
                            <tr>
                                <th>
                                    INCIDENTE
                                </th>
                                <td>
                                    <a class="linked" href="{{ route('solicitudes.archivo',$model) }}" target="_blank">{{ $model->nombre_adjunto }}</a>
                                </td>
                            </tr>
                        @endisset

                        <tr>
                            <th>
                                Comentarios
                            </th>
                            <td>
                                @forelse ($model->ticket->sigoTicket as $comentario)
                                    <div class="row">
                                        <div class="col">
                                            <p class="font-weight-bold"><a href="mailto:  ">{{ $comentario->autor }}</a> ({{ $comentario->fecha }})</p>
                                            <p>{{ $comentario->comentario }}</p>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr />
                                    @endif
                                @empty
                                    <div class="row">
                                        <div class="col">
                                            <p>No hay comentarios.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </td>
                        </tr>

                    </tbody>
                </table>

                <form class="mt-3" action="{{ route('solicitudes.storeComentario', $model->id) }}" method="POST">
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
            </div>

            <div class="card-footer">
                <a class="btn btn-default" href="{{ route('solicitudes.index') }}">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

