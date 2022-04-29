@extends('layouts.panel')

@section('title','Notificaciones')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item active">Notificaciones</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- TIMELINE -->
                    <div class="timeline">

                        <div class="time-label">
                            <span>
                                <a href="{{ route('notificaciones.delete') }}" class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault(); document.getElementById('form-notificaciones').submit();">
                                    Eliminar
                                </a>
                                <form action="{{ route('notificaciones.delete') }}" method="POST" style="display: none;" id="form-notificaciones">
                                    @csrf
                                </form>
                            </span>
                        </div>

                        <!-- NOTIFICACION -->
                        @forelse($notificacions as $notificacion)
                            <div>
                                <i class="fas fa-file bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i>  {{ $notificacion->data['fecha'] }} {{ $notificacion->data['hora'] }} </span>
                                    <h3 class="timeline-header"><a href="#">{{ $notificacion->data['creado_por'] }} </a> {{ $notificacion->data['titulo'] }}</h3>

                                    <div class="timeline-body">
                                        {{ $notificacion->data['detalle'] }}
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-primary btn-sm" href="{{ $notificacion->data['route'] }}">Mostrar</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div>
                                <i class="fas fa-times-circle bg-red"></i>
                                <div class="timeline-item">
                                    <div class="timeline-body">
                                        No tienes notificaciones
                                    </div>
                                </div>
                            </div>
                        @endforelse
                        <!-- END NOTIFICACION -->

                        <!-- END timeline-->
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                        <!-- END timeline-->

                    </div>
                    <!-- END TIMELINE -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush

