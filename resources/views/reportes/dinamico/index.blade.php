@extends('layouts.panel')

@section('title','Reporte Dinámico')

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
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pivottable/pivot.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pivottable/pivot_lib.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Total de tickets atendidos por operador</h3>
            </div>
            <div class="card-body">
                <div class="row pb-3">

                    <div class="col align-self-start">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" onclick="javascript:window.location.reload();">
                                Actualizar <i class="fas fa-sync-alt"></i>
                            </button>

                            <button class='btn btn-sm btn-outline-secondary' id="btn-excel">
                                Excel <i class="fas fa-table"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col align-self-end ">
                        <form id="form-filter-efficiencia" method="GET" action="{{ route('reporte.reporte-dinamico') }}">
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
                <div id="reporte-dinamico" style="overflow-x: auto;width: 100%;"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/pivottable/pivot_lib.min.js') }}"></script>
    <script src="{{ asset('vendor/pivottable/pivot.min.js') }}"></script>
    <script src="{{ mix('js/vendor/table-html/table-html.js') }}"></script>

    <script>
        $(function(){
            let myRederers = {
                "Tabla": $.pivotUtilities.renderers["Table"],
                "Tabla con barras": $.pivotUtilities.renderers["Table Barchart"],
                "Heatmap": $.pivotUtilities.renderers["Heatmap"],
                "Heatmap por filas": $.pivotUtilities.renderers["Row Heatmap"],
                "Heatmap por columnas": $.pivotUtilities.renderers["Col Heatmap"]
            }

            let c3renderers = {
                "Grafico horizontal de barras": $.pivotUtilities.c3_renderers["Horizontal Bar Chart"],
                "Gráfico de barras apiladas horizontales": $.pivotUtilities.c3_renderers["Horizontal Stacked Bar Chart"],
                "Gráfico de barras": $.pivotUtilities.c3_renderers["Bar Chart"],
                "Heatmap por columnas": $.pivotUtilities.c3_renderers["Stacked Bar Chart"],
                "Gráfico de linea": $.pivotUtilities.c3_renderers["Line Chart"],
                "Gráfico de área": $.pivotUtilities.c3_renderers["Area Chart"],
                "Gráfico de dispersión": $.pivotUtilities.c3_renderers["Scatter Chart"],
            }

            const renderers = $.extend(
                myRederers,
                c3renderers
            );

            const tickets = @json($tickets);

            $("#reporte-dinamico").pivotUI(tickets,
                {
                    cols: ["operador"],
                    rows: ["id_usuario","usuario"],
                    sorters: {
                    },
                    renderers: renderers,
                    rendererName: "Tabla",
                },false,'es'
            );

            $("#btn-excel").click(function(e){
                var $ouputContainer = $("#reporte-dinamico");
                var $pivotTable = $ouputContainer.find("td table.pvtTable");
                var currentDate = moment().format('DD-MM-Y hh_mm_ss');

                if (!$pivotTable.length){
                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        text: 'Para descargar el reporte a excel, debes seleccionar la vista tabla',
                        width: 500
                    });
                    return;
                }

                 $pivotTable.table2excel({
                    name: "Consulta Dinamica",
                    filename: `Consulta Personal ${currentDate}`
                });
            });
        })
    </script>
@endsection


