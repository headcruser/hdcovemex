@extends('layouts.panel')

@section('title','Dashboard')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio </a>
        </li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                Bienvenido! Por favor selecciona una opción del menú lateral izquierdo.
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection

