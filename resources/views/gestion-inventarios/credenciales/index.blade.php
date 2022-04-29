@extends('layouts.panel')

@section('title','Credenciales')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">
            Credenciales
        </li>
        <li class="breadcrumb-item active">Personal</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Gestión de credenciales</h3>
                    <div class="card-tools">
                        @permission('credenciales_create')
                        <a href="{{ route('gestion-inventarios.credenciales.create') }}" class="btn btn-success btn-sm" title="Crear">
                            <i class="fas fa-plus-circle"></i> Crear
                        </a>
                        @endpermission
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tb-credenciales" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>URL</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/clipboard/dist/clipboard.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            const dom = {
                table: $('#tb-credenciales'),
            };

            $.fn.DataTable.ext.pager.numbers_length = 5;

            var dt = dom.table.DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                autoWidth: false,
                dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-end'p>>",
                ajax: {
                    url: "{{ route('gestion-inventarios.credenciales.datatables') }}",
                    type: "POST",
                    data: function (d) {
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
                    {data: 'nombre',name: 'nombre'},
                    {data: 'usuario',name: 'usuario'},
                    {data: 'url',name: 'url'},
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
                            type: 'DELETE',
                            data: {},
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

            var clipboard = new ClipboardJS('.clipboard');

            clipboard.on('success', function(e) {
                Toast.fire({
                    type: 'success',
                    title: 'Copiado correctamente'
                });

                e.clearSelection();
            });

            clipboard.on('error', function(e) {
                Toast.fire({
                    type: 'danger',
                    title: 'Ocurrio un error al copiar el elemento'
                });
            });

            dom.table.on('click',"a.dropdown-item",function(e){
                e.preventDefault();
            });
        })
    </script>
@endpush

