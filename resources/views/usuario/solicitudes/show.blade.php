@extends('layouts.panel')

@section('title','Detalle Solicitud #' .$model->id)

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

                @if(auth()->user()->hasRole('empleado'))
                    @if($model->status->name === 'PEN')
                        <div class="callout callout-warning">
                            <h5>Tu solicitud esta aún en revisión</h5>
                            <p>Te atenderemos a la brevedad posible.</p>
                        </div>
                    @endif

                    @if($model->status->name === 'PAS')
                        <div class="callout callout-info">
                            <h5>Tu solicitud esta en proceso</h5>
                            <p>Estamos trabajando en resolver tu solicitud</p>
                        </div>
                    @endif

                    @if($model->status->name === 'CAN')
                        <div class="callout callout-warning">
                            <h5>Tu solicitud ha sido Cancelada</h5>
                            <p>La solicitud que realizaste no pudo ser procesada</p>
                        </div>
                    @endif
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
                                <span class="badge badge-primary text-sm"  style="background-color:{{ $model->status->color }}">
                                    {{ $model->status->display_name }}
                                </span>
                            </td>
                        </tr>

                        @isset($model->media)
                            <tr>
                                <th>
                                    ARCHIVO ADJUNTO
                                </th>
                                <td>
                                    <p>
                                        <a href="{{ route('solicitudes.archivo',$model) }}" target="_blank" class="linked text-sm"><i class="fas fa-link mr-1"></i> {{ $model->media->name }} </a>
                                    </p>

                                </td>
                            </tr>
                        @endisset

                        @if( $model->ticket()->exists() )
                        <tr>
                            <th>
                                Comentarios
                            </th>
                            <td>
                                <div style="height: 300px;overflow-y:auto;overflow-x:hidden">
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
                                </div>

                                @if( $model->ticket()->exists() )
                                <form id="form-comentario" class="mt-3" action="{{ route('solicitudes.storeComentario', $model->id) }}" method="POST">
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
                                @endif
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
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
@endsection

