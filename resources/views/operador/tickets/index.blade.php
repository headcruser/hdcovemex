@extends('layouts.panel')

@section('title','Tickets')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Tickets</li>
</ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestionar Tickets</h3>

                <div class="card-tools">
                    <a href="{{ route('operador.tickets.create') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>
                </div>

            </div>
            <div class="card-body">
                @include('operador.tickets.partials._filters')

                @include('operador.tickets.partials._table')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

