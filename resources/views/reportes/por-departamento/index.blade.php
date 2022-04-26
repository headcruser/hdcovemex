@extends('layouts.panel')

@section('title','Reporte por departamento')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Reportes</li>
        <li class="breadcrumb-item active">Dinámico</li>
    </ol>
@endsection

@section('styles')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Total de tickets por departamento</h3>
            </div>
            <div class="card-body">
                <div class="row pb-3">

                    <div class="col align-self-start">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" onclick="javascript:window.location.reload();">
                                Actualizar <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <label>
                            {!! Form::select('estado', $estados, request('estado'), ['class' => 'custom-select custom-select-sm','form' => 'form-filter-efficiencia']) !!}
                        </label>
                    </div>

                    <div class="col align-self-end ">
                        <form id="form-filter-efficiencia" method="GET" action="{{ route('reporte.por-departamento') }}">
                            <div class="form-inline form-dates">
                                <label for="from" class="form-label-sm">Fecha</label>&nbsp;
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" name="fecha-inicial" id="fecha-inicial" placeholder="Desde" autocomplete="off" value="{{ request('fecha-inicial',now()->startOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" name="fecha-final" id="fecha-final" placeholder="Hasta" autocomplete="off" value="{{ request('fecha-final',now()->endOfMonth()->format('Y-m-d')) }}">
                                </div>
                                &nbsp;
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div id="chart-total-por-departamento"></div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Departamento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($por_departamento as $item)
                            <tr>
                                <td>{{ $item['departamento'] }}</td>
                                <td>{{ $item['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('highcharts/code/highcharts.js')}}"></script>
    <script src="{{asset('highcharts/code/modules/exporting.js')}}"></script>
    <script src="{{asset('highcharts/code/modules/export-data.js')}}"></script>

    <script>
        $(function(){
            const langHighChart = {
                loading:              'Espere...',
                exportButtonTitle:    'Exportar',
                printButtonTitle:     'Imprimir',
                printChart:           'Imprimir gráfica',
                downloadCSV:          'Descargar CSV',
                downloadXLS:          'Descargar XLS',
                downloadPNG:          'Descargar Imagen PNG',
                downloadJPEG:         'Descargar imagen JPEG',
                downloadPDF:          'Descargar documento PDF',
                downloadSVG:          'Descargar imagen SVG',
                openInCloud:          'Abrir grafica en la nube',
                viewData:             'Ver tabla de datos',
            };

            Highcharts.chart('chart-total-por-departamento', {
                lang: langHighChart,
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'column'
                },
                title: {
                    text: `TOTAL POR DEPARTAMENTO  <b>(${$('[name="estado"] option:selected').text()})</b>`
                },
                subtitle: {
                    text: `Total <b> {{ $por_departamento->sum('total') }}</b>`
                },
                yAxis: {
                    title: {
                        text: 'TICKETS'
                    }
                },
                xAxis: {
                    title: {
                        text: 'DEPARTAMENTOS'
                    }
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true
                        }
                    },
                },
                series: [
                    @foreach ($por_departamento as $departamento )
                        {
                            name: "{{ $departamento['departamento'] }}",
                            data: [parseInt("{{ $departamento['total'] }}")]
                        },
                    @endforeach
                ]
            });
        })
    </script>
@endsection


