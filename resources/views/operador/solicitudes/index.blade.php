@extends('layouts.panel')

@section('title','Solicitudes')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

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
                    <h3 class="card-title">Gestionar Solicitudes</h3>
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
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        const locale = {
            "format": "YYYY-MM-DD",
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

        const STATUS = {
            INGRESADO: 1
        };

        const dom = {
            table: $('#tb-solicitudes'),
            filters: {
                status: $("#select-status"),
                departamento: $("#select-departamento"),
                limpiar: $("#btn-limpiar"),
            }
        };

        dom.filters.status.val(STATUS.INGRESADO);

        $('.datepicker').daterangepicker({
            changeMonth: true,
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: locale,
            changeYear: true,
        });

        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            dt.draw()
        });

        $('.datepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dt.draw()
        });

        var dt = dom.table.DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            dom: "<'row'<'col-6 d-flex align-items-center'l><'col-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-7'i><'col-5 align-self-end d-flex justify-content-end'p>>",
            ajax: {
                url: "{{ route('operador.gestion-solicitudes.datatables') }}",
                type: "POST",
                data: function (d) {
                    d.status = dom.filters.status.val();
                    d.departamento = dom.filters.departamento.val();
                    d.from = $("#startdate").val();
                    d.to = $("#enddate").val();
                },
                beforeSend: function(xhr,type) {
                if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    }
                },
                complete: function() {
                },
            },
            pageLength: 10,
            responsive: true,
            columns: [
                {data: 'id',name: 'id'},
                {data: 'titulo',name: 'titulo'},
                {data: 'fecha',name: 'fecha'},
                {data: 'empleado.nombre',name: 'empleado.nombre'},
                {data: 'empleado.departamento.nombre',name: 'empleado.departamento.nombre'},
                {data: 'label_status',name: 'label_status',className:'text-center',searchable: false},
                {data: 'buttons', name: 'buttons', orderable: false, searchable: false,className:'text-center'}
            ],
            order: [[ 0, "desc" ]],
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
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
            },
            drawCallback: function (settings) {
                $("[data-toggle='tooltip']").tooltip();
            },
        });

        dom.table.on('click',"a[data-action='destroy']",function(e){
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: '¿Desesas eliminar este registro?',
                text: "Una vez eliminado, no podrá recuperarse",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function (response){
                            dt.ajax.reload( function(){
                                Toast.fire({
                                    type: 'success',
                                    title: response.message || 'Registro eliminado correctamente',
                                });
                            }, false )
                        },
                        error:function(error){
                            Toast.fire({
                                type: 'error',
                                title: 'Ups, hubo un error en el servidor'
                            });
                        }
                    });
                }
            })
        });

        var searchWait = 0;
        var searchWaitInterval;

        $('.dataTables_filter input')
            .unbind()
            .bind('input', function(e) {
                var item = $(this);
                searchWait = 0;
                if (!searchWaitInterval) searchWaitInterval = setInterval(function() {
                    if (searchWait >= 3) {
                        clearInterval(searchWaitInterval);
                        searchWaitInterval = '';
                        searchTerm = $(item).val();
                        dt.search(searchTerm).draw();
                        searchWait = 0;
                    }
                    searchWait++;
                }, 200);

            });

        dom.filters.status.change(function(e){
            dt.draw();
        });

        dom.filters.departamento.change(function(e){
            dt.draw();
        });

        dom.filters.limpiar.click(function(){
            $("#startdate").val('');
            $("#enddate").val('');
            dom.filters.status.val(STATUS.INGRESADO);
            dom.filters.departamento.val('');

            dt.draw();
        });
    </script>
@endsection

