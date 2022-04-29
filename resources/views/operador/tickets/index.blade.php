@extends('layouts.panel')

@section('title','Tickets')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item active">Tickets</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestionar Tickets</h3>

                <div class="card-tools">
                    <a href="{{ route('operador.tickets.create') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>
                </div>

            </div>
            <div class="card-body">
                @include('operador.tickets.partials._filters')

                @include('operador.tickets.partials._table')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

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
        }

        const dom = {
            table: $('#tb-tickets'),
            filters: {
                status: $("#status"),
                operador: $("#operator_id"),
                proceso: $("#proceso"),
                from: $('#from'),
                to:  $('#to'),
                btn_fecha: $("#btn-filtrar-fecha"),
            }
        };


        dom.filters.from.daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: locale
        });

        dom.filters.to.daterangepicker({
            singleDatePicker: true,
            locale: locale,
            autoUpdateInput: false,
        });

        $.fn.DataTable.ext.pager.numbers_length = 5;

        var dt = dom.table.DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
            ajax: {
                url: "{{ route('operador.tickets.datatables') }}",
                type: "POST",
                data: function (d) {
                    d.proceso = dom.filters.proceso.val();
                    d.operador = dom.filters.operador.val();
                    d.from =  dom.filters.from.val();
                    d.to = dom.filters.to.val();
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
                {data: 'nombre_prioridad',name: 'nombre_prioridad'},
                {data: 'fecha',name: 'fecha'},
                {data: 'empleado.usuario',name: 'empleado.usuario'},
                {data: 'empleado.nombre',name: 'empleado.nombre'},
                {data: 'titulo',name: 'titulo'},
                {data: 'proceso',name: 'proceso', searchable: false, className:'text-center'},
                {data: 'buttons', name: 'buttons', orderable: false, searchable: false,className:'text-center'}
            ],
            order: [[ 0, "desc" ]],
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se encontro ningún registro",
                "info": "_TOTAL_ registros. (Página _PAGE_ de _PAGES_)",
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
            drawCallback: function (settings) {
                $("[data-toggle='tooltip']").tooltip();
            },
            createdRow: function ( row, data, index ) {
                $('td', row).eq(1).css("background-color",data.color_prioridad);
            }
        });

        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            dt.draw()
        });

        $('.datepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dt.draw()
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
                            _method:'DELETE'
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

        dom.table.on('click',"a[data-action='finalizar-ticket']",function(e){
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: '¿Desesas finalizar este registro?',
                html: `
                    <div class="form-group">
                        <label>Comentario</label>
                        <textarea id="ticket-comentario" class="form-control" row="5" placeholder="Escribe aqui tus comentarios" title="comentario" ></textarea>
                    </div>
                `,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Finalizar',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            comentario: $("#ticket-comentario").val(),
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

        dom.table.on('click',"a[data-action='cancelar-ticket']",function(e){
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: '¿Desesas cancelar este ticket?',
                html: `
                    <div class="form-group">
                        <label>Comentario</label>
                        <textarea id="ticket-comentario-cancelacion" class="form-control" row="5" placeholder="Escribe aqui tus comentarios" title="comentario" ></textarea>
                    </div>
                `,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Finalizar',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            comentario: $("#ticket-comentario-cancelacion").val(),
                        },
                        success: function (response){
                            dt.ajax.reload( function(){
                                Toast.fire({
                                    type: 'success',
                                    title: response.message || 'Registro Cancelado correctamente',
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

        $(document.body).on('change','select[data-filter="select"]',function(e){
            dt.draw();
        });

        dom.filters.btn_fecha.click(function(){
            dt.draw();
        });
    </script>
@endpush

