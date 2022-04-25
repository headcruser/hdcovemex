@extends('layouts.panel')

@section('title','Eficiencia')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Reportes</li>
    <li class="breadcrumb-item active">Eficiencia</li>
</ol>
@endsection

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Reporte mensual</h3>
        </div>
        <div class="card-body">
            <div class="row pb-3">
                <div class="col-6">
                    <form id="form-report-excel" method="GET" action="{{ route('reporte.eficiencia.export') }}">
                        <button type="submit" class="btn btn-outline-secondary btn-flat"> <i class="far fa-file-excel"></i> Exportar Excel</button>
                    </form>
                </div>
                <div class="col-6 float-left text-right">
                    <form id="form-filter-efficiencia" method="GET" action="{{ route('reporte.eficiencia') }}">
                        <div class="form-inline form-dates">
                            <label for="from" class="form-label-sm">Fecha</label>&nbsp;
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="from" id="from" placeholder="Desde" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="to" id="to" placeholder="Hasta" autocomplete="off">
                            </div>
                            &nbsp;
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                @include('reportes.eficiencia.partials._table')
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
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
        };

        const from = "{{ request('from') }}",
            to = "{{ request('to') }}";

        const d = document,
            $form_eficiencia = d.getElementById('form-filter-efficiencia'),
            $form_report_excel = d.getElementById('form-report-excel')
            $input_from = $('#from'),
            $input_to = $('#to');

        $input_from.daterangepicker({
            singleDatePicker: true,
            startDate: (!from) ? moment().subtract(30, 'days'): from,
            locale: locale
        });

        $input_to.daterangepicker({
            singleDatePicker: true,
            locale: locale,
            startDate: (!to) ? moment(): to
        });

        d.addEventListener('submit',function(e) {
            if($form_eficiencia === e.target) {
                Swal.fire({
                    title: 'Filtrando el reporte',
                    html: 'Espere un momento por favor.',
                    allowEscapeKey:false,
                    allowOutsideClick:false,
                    allowEnterKey:false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                })
            }

            if ($form_report_excel == e.target) {
                let fromHiddenInput = document.createElement('input');
                fromHiddenInput.type = 'hidden';
                fromHiddenInput.name = 'from';
                fromHiddenInput.value = $input_from.val();

                let toHiddenInput = document.createElement('input');
                toHiddenInput.type = 'hidden';
                toHiddenInput.name = 'to';
                toHiddenInput.value = $input_to.val();

                $form_report_excel.appendChild(fromHiddenInput)
                $form_report_excel.appendChild(toHiddenInput)
            }
        });
    </script>
@endsection


