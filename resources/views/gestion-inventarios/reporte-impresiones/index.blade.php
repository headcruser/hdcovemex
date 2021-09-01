@extends('layouts.panel')

@section('title','Reporte Impresoras')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Herramientas </a>
    </li>
    <li class="breadcrumb-item active">Impresoras</li>
</ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3"></h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Reporte Anual</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Reporte por impresora</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Reporte por departamento</a></li>
                        <li class="nav-item"></li>
                    </ul>
                </div>

                <div class="card-body">

                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_1">
                            <button class="btn btn-secondary btn-sm mb-4" id="btn-descargar-excel">
                                <i class="fas fa-file-excel"></i> Descargar Reporte
                            </button>

                            <div class="table-responsive" style="height: 70vh">
                                <table id="tb-reporte-mensual" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;" class="text-center p-3">
                                                DEPARTAMENTOS
                                            </th>
                                            <th rowspan="2" style="vertical-align: middle;" class="text-center">
                                                NOMBRE
                                            </th>
                                            <th rowspan="2" style="vertical-align: middle;" class="text-center">
                                                ID
                                            </th>
                                            @foreach ($meses as $id => $mes)
                                                <th class="text-center" colspan="3">
                                                    {{ $mes }}
                                                </th>
                                            @endforeach
                                            <th rowspan=2>TOTAL ANUAL</th>
                                        </tr>

                                        <tr class="text-bold bg-gray-light">
                                            @foreach ($meses as $th => $mes)
                                                <th>Negro</th>
                                                <th class="text-danger">Color</th>
                                                <th>Total</th>
                                            @endforeach
                                        </tr>
                                    </thead>



                                    @foreach ($personal_por_departamento as $departamento => $lista_personal)
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: middle;" rowspan="{{ $lista_personal->count() + 1 }}" class="text-center bg-purple">{{ $departamento }}</td>
                                            </tr>

                                            @php
                                                $total_anual = 0;
                                            @endphp

                                            @foreach ($lista_personal as $personal)
                                                <tr>
                                                    <td class="text-nowrap">{{ $personal->nombre }}</td>
                                                    <td>{{ $personal->id_impresion }}</td>
                                                    @php
                                                        $total_por_personal = 0;
                                                    @endphp
                                                    @foreach ($meses as $id => $mes)
                                                        <td>{{ $reporte[$mes][$personal->id_impresion]['negro'] }}</td>
                                                        <td>{{ $reporte[$mes][$personal->id_impresion]['color'] }}</td>
                                                        <td>{{ $reporte[$mes][$personal->id_impresion]['total'] }}</td>
                                                        @php
                                                            $total_por_personal += $reporte[$mes][$personal->id_impresion]['total'];
                                                        @endphp
                                                    @endforeach
                                                    <td class="text-bold">{{ $total_por_personal }}</td>
                                                    @php
                                                        $total_anual+= $total_por_personal;
                                                    @endphp
                                                </tr>
                                            @endforeach

                                            <tr class="text-bold bg-gray-light">
                                                <th colspan="3" class="text-center">TOTAL</th>
                                                @foreach ($meses as $id => $mes)
                                                    <td>
                                                        {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                                            return $item['departamento'] == $departamento;
                                                        })->sum('negro') }}
                                                    </td>
                                                    <td class="text-danger">
                                                        {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                                            return $item['departamento'] == $departamento;
                                                        })->sum('color') }}
                                                    </td>
                                                    <td>
                                                        {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                                            return $item['departamento'] == $departamento;
                                                        })->sum('total') }}
                                                    </td>
                                                @endforeach
                                                <td>
                                                    {{ $total_anual }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="chart-total-por-impresora"></div>
                                    </div>
                                </div>
                        </div>

                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="chart-total-por-departamento"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{asset('highcharts/code/highcharts.js')}}"></script>
    <script src="{{asset('highcharts/code/modules/exporting.js')}}"></script>
    <script src="{{asset('highcharts/code/modules/export-data.js')}}"></script>
    <script src="{{ mix('js/vendor/table-html/table-html.js') }}"></script>

    <script type="text/javascript">

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

        $(function(){
            Highcharts.chart('chart-total-por-impresora', {
                lang: langHighChart,
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'column'
                },
                title: {
                    text: 'TOTAL ANUAL POR IMPRESORA'
                },
                subtitle: {
                    text: `Total <b> {{ $agrupado_por_impresora->sum('total') }}</b>`
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    // pointFormat: '{series.name}: <b>{point.y}</b>'
                    // headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    // pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    //     '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    // footerFormat: '</table>',
                    // shared: true,
                    // useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                    // pie: {
                    //     allowPointSelect: true,
                    //     cursor: 'pointer',
                    //     dataLabels: {
                    //         enabled: false
                    //     },
                    //     showInLegend: true
                    // }
                },
                series: [
                    @foreach ($agrupado_por_impresora as $impresora => $reporte )
                        {
                            name: "{{ $impresora }}",
                            data: [Number("{{ $reporte['total'] }}")]
                        },
                    @endforeach
                ]
                // series: [{
                //     name: 'impresoras',
                //     colorByPoint: true,
                //     data: [
                //         {
                //             name: "TGAB",
                //             y: Number(100),
                //             color: '#E44E1F',
                //         },
                //     ],
                // }],
                // legend: {
                //     align: 'right',
                //     verticalAlign: 'top',
                //     layout: 'vertical',
                //     x: -50,
                //     y: 120,
                //     symbolPadding: 0,
                //     symbolWidth: 0.1,
                //     symbolHeight: 0.1,
                //     symbolRadius: 0,
                //     useHTML: true,
                //     symbolWidth: 0,
                //     labelFormatter: function() {
                //         return '<div style="width:350px;"><span style="float:left; margin-left:10px"><div style="height:40px;background-color:' + this.color + ';"></span><span style="float:right;padding:9px">' +this.name +': '+ this.y +  '</span></div>';
                //     },
                //     itemStyle: {
                //         color: '#ffffff',
                //         fontWeight: 'bold',
                //         fontSize: '19px'
                //     }
                // },
            });
        })

        $(function(){
            Highcharts.chart('chart-total-por-departamento', {
                lang: langHighChart,
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'column'
                },
                title: {
                    text: 'TOTAL ANUAL POR DEPARTAMENTO'
                },
                subtitle: {
                    text: `Total <b> {{ $impresiones_por_departamento->sum('total') }}</b>`
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                    @foreach ($impresiones_por_departamento as $departamento => $reporte )
                        {
                            name: "{{ $departamento }}",
                            data: [Number("{{ $reporte['total'] }}")]
                        },
                    @endforeach
                ]
            });
        })

        $(function(){
            $("#btn-descargar-excel").click(function(e){
                const id_impresora = $(this).data('impresora');

                const date = new Date().toLocaleDateString().replaceAll('/','-');
                const filename = `reporte_anual_${date}.xls`;


                const table = $("#tb-reporte-mensual");

                table.table2excel({
                    filename: filename
                });
            });
        })
    </script>
@endsection

