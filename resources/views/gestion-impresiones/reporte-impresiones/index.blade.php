@extends('layouts.panel')

@section('title','Reporte Impresoras '.$anio)

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
                    <h3 class="card-title p-3">
                    </h3>
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

                            <div class="row pb-2">
                                <div class="col-md-6">
                                    {!! Form::open(['id' => 'form-filtrar','method' => 'GET','route' => ['gestion-impresiones.reporte-impresiones.index'], 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                                        <label>Filtro por Año: &nbsp;</label>
                                        <label>
                                            {!! Form::select('anio', $anios, $anio, ['class' => 'custom-select custom-select-sm form-control form-control-sm']) !!}
                                        </label>
                                        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-md-6 text-right">
                                    <div>
                                        <button class="btn btn-secondary btn-sm mb-4" id="btn-descargar-excel">
                                            <i class="fas fa-file-excel"></i> Descargar Reporte
                                        </button>

                                        <button class="btn btn-default btn-sm mb-4" id="btn-enviar-correo">
                                            <i class="fas fa-mail-bulk"></i> Enviar por correo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @include('gestion-impresiones.reporte-impresiones.partials._table')
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


    <div class="modal fade" id="modal-enviar-reporte-anual" data-keyboard="false"  data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Enviar Reporte Anual</b></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                {!! Form::open(['id' => 'form-enviar-reporte-anual', 'route' => 'gestion-impresiones.reporte-impresiones.enviar-reporte-anual', 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <button id="btn-agregar-cc" type="button" class="btn btn-link float-right"">Agregar CC</button>

                            {!! Form::label('email', 'Correo:*') !!}
                            {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'Escribe aqui el correo','title' => 'Correo','required' => true,'autocomplete' => 'off']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::hidden('anio', $anio) !!}
                        </div>
                        <div id="correos-cc">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

@endsection

@push('scripts')

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

        $(function(){
            $("#btn-enviar-correo").click(function(e){
                $("#modal-enviar-reporte-anual").modal('show');
            });

            $('#btn-agregar-cc').click(function(){
                $('#correos-cc').append(`
                    <div class="form-group">
                        <label for="email_copia[]">CC:</label>

                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email_copia[]" placeholder="Ingresar Email CC" autocomplete="off" title="Email CC" required/>

                            <div class="input-group-prepend">
                                <button type="button" data-action="eliminar-cc" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $("#correos-cc").on('click','button[data-action="eliminar-cc"]',function(e){
                $(this).closest('div.form-group').remove();
            });

            $("#form-enviar-reporte-anual").submit(function(e){
                $("#modal-enviar-reporte-anual").modal('hide');

                Swal.fire({
                    title: 'Procesando',
                    html: 'Espere un momento por favor.',
                    allowEscapeKey:false,
                    allowOutsideClick:false,
                    allowEnterKey:false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });

            });
        });

        $(function(){
            $("#form-filtrar").submit(function(){
                Swal.fire({
                    title: 'Procesando',
                    html: 'Espere un momento por favor.',
                    allowEscapeKey:false,
                    allowOutsideClick:false,
                    allowEnterKey:false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            });
        })
    </script>
@endpush

