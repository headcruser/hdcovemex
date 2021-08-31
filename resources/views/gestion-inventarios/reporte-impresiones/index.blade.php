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
{{-- <div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Genera Reporte de impresoras</h3>
                @if(session('tb_printer'))
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                      <div class="input-group-append">
                        <button id="btn-report" type="button" class="btn btn-primary" title="Imprimir">Imprimir Reporte</button>
                        <a class="btn btn-default" href="{{ route('gestion-inventarios.reporte-impresiones.index') }}">Regresar</a>
                      </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @if (!session('tb_printer'))
                            <form class="form" action="{{ route('gestion-inventarios.reporte-impresiones.calcular') }}" method="POST">
                                @csrf
                                <div class="form-group @error('info') has-error @enderror">
                                    <label>Ingresa la informacion de la impresora</label>
                                    <textarea id="info" class="form-control" name="info" cols="30" rows="15" required title="Información Impresiones">{{ old('info','') }}</textarea>
                                    <div class="help-block with-errors">
                                        @error('info')
                                            <span>{{ $errors->first('info') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Generar">
                            </form>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if (session('tb_printer'))
                            {!! session('tb_printer') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> --}}


{{--
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Genera Reporte de impresoras</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm">
                      <div class="input-group-append">
                        <button id="btn-report" type="button" class="btn btn-primary" title="Imprimir">Imprimir Reporte</button>
                      </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
          <div class="card-header d-flex p-0">
            <h3 class="card-title p-3"></h3>
            <ul class="nav nav-pills ml-auto p-2">
              <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Reporte Anual</a></li>
              <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Reporte por impresora</a></li>
              <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Reporte por departamento</a></li>
              <li class="nav-item">

              </li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                    <div class="table-responsive" style="height: 70vh">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    ID
                                </th>
                                @foreach ($meses as $id => $mes)
                                    <th colspan="3">
                                        {{ $mes }}
                                    </th>
                                @endforeach
                                <th>Total</th>
                            </thead>
                            <thead>
                                <tr class="text-bold bg-gray-light">
                                    <th colspan="2"></th>
                                    @foreach ($meses as $th => $mes)
                                        <th>Negro</th>
                                        <th class="text-danger">Color</th>
                                        <th>Total</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($personal_por_departamento as $departamento => $lista_personal)
                                <tbody>
                                    <tr>
                                        <td colspan="39" class="text-center bg-purple">{{ $departamento }}</td>
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
                                        <th colspan="2">TOTAL</th>
                                        @foreach ($meses as $id => $mes)
                                            <td>
                                                {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                                    return $item['departamento'] == $departamento;
                                                })->sum('negro') }}
                                            </td>
                                            <td>
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
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chart-total-por-impresora"></div>
                        </div>
                    </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <div class="row">
                    <div class="col-md-12">
                        <div id="chart-total-por-departamento"></div>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
      </div>
</div>
@endsection

@section('scripts')

    <script src="{{asset('highcharts/code/highcharts.js')}}"></script>
    <script src="{{asset('highcharts/code/modules/exporting.js')}}"></script>
    <script src="{{asset('highcharts/code/modules/export-data.js')}}"></script>
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
    </script>

    {{-- @if(session('tb_printer'))
        <script src="{{ mix('js/vendor/table-html/table-html.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                const d = document;
                const date = new Date().toLocaleDateString().replaceAll('/','-');
                const filename = `reporte_impresiones_${date}.xls`;

                const dom = {
                    btn_report: $('#btn-report'),
                    tb_report: $("#tbImpr"),
                };

                d.addEventListener('click',function(e) {
                    if (e.target === dom.btn_report[0]) {
                        dom.tb_report.table2excel({
                            filename: filename
                        });
                    }
                });
            });
        </script>
    @endif --}}
@endsection

