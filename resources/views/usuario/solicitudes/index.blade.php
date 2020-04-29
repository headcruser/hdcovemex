@extends('layouts.panel')

@section('title','Solicitudes')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Solicitudes</li>
</ol>
@endsection

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mis Solicitudes</h3>
            <div class="card-tools">
                <a href="{{ route('solicitudes.create') }}"
                    class="btn btn-success btn-sm"
                    title="Crear">
                    Crear <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">

            @include('usuario.solicitudes.partials._filters')

            @include('usuario.solicitudes.partials._table')

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const locale = {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizar",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
    }

    const from = "{{ request('from') }}",
          to = "{{ request('to') }}";

    $('#from').daterangepicker({
        singleDatePicker: true,
        startDate: (!from) ? moment().subtract(6, 'days'): from,
        locale: locale
    });

    $('#to').daterangepicker({
        singleDatePicker: true,
        locale: locale,
        startDate: (!to) ? moment(): to
    });
</script>
@endsection

