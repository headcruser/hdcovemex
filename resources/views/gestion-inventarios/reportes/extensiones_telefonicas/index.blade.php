@extends('layouts.panel')

@section('title','Extensiones Telefonicas')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Gestión Inventarios </li>
        <li class="breadcrumb-item">Reportes</li>
        <li class="breadcrumb-item active">Ext. Tel.</li>
    </ol>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Extensiones Registradas en <mark>Personal</mark></h3>
            </div>
            <div class="card-body">
                <div class="row pb-2">
                    <div class="col align-self-start">
                        <label>
                            {!! Form::select('sucursal',$sucursales, request('sucursal'), ['class' => 'custom-select custom-select-sm','form' => 'form-filter-sucursales','placeholder' => 'Todas las sucursales']) !!}
                        </label>
                    </div>

                    <div class="col align-self-end ">
                        <form id="form-filter-sucursales" class="mb-1" method="GET" action="{{ route('gestion-inventarios.reportes.extensiones-telefonicas.index') }}">
                            <div class="form-inline form-dates">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                            </div>
                        </form>
                    </div>

                </div>

                <table class="table table-bordered table-striped" id="tb-extensiones" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Sucursal</th>
                            <th>Ext. Telefonica</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($extensiones as $extension)
                            <tr>
                                <td> <a class="btn-link" href="{{ route('gestion-inventarios.personal.show',$extension->id_personal) }}">{{ $extension->nombre }}</a> </td>
                                <td>{{ $extension->departamento }}</td>
                                <td>{{ $extension->sucursal }}</td>
                                <td>{{ $extension->extension }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendor/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


    <script type="text/javascript">
        $('#tb-extensiones').DataTable({
            paging: false,
            info: false,
            dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'B><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
            buttons: [
                {
                    title:'PDF_Extensiones',
                    extend: 'pdfHtml5',
                    className:'btn-sm' ,
                    text: 'PDF',
                     customize : function(doc){
                        var colCount = new Array();

                        $('#tb-extensiones').find('tbody tr:first-child td').each(function(){
                            if ($(this).attr('colspan')) {
                                for(var i=1;i<=$(this).attr('colspan');i++) {
                                    colCount.push('*');
                                }
                            }else{ colCount.push('*'); }
                        });

                        // 👉 [*,*,*,*] ESPECIFICA QUE LA COLUMNA TENGA 100%
                        doc.content[1].table.widths = colCount;
                    }
                },
            ],
            order: [[ 0, "asc" ]],
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se encontro ningún registro",
                "info": "Mostrando del _START_ al _END_ de _TOTAL_ registros. (Página _PAGE_ de _PAGES_)",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "<i class='fa fa-chevron-right'></i>",
                    "previous": "<i class='fa fa-chevron-left'></i>"
                },
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
            },
        } );
    </script>
@endpush
