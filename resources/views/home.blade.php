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
<section class="content">
    <div class="container-fluid">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            Bienvenido! Por favor selecciona una opción del menú lateral izquierdo.
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @includeWhen(Entrust::hasRole('empleado'), 'resumen._empleado')
    </div>

</section>
@endsection

@section('scripts')
<script type="text/javascript">
</script>
@endsection
