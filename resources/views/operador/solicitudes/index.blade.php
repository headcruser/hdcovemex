@extends('layouts.panel')

@section('title','Solicitudes')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Gestinar Solicitudes</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestionar Solcicitudes</h3>
            </div>
            <div class="card-body">
                @include('operador.solicitudes.partials._filters')
                @include('operador.solicitudes.partials._table')
            </div>
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

