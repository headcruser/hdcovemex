@extends('layouts.panel')

@section('title','Listar FAQ´s')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> Administración </li>
         <li class="breadcrumb-item">
            <a href="{{ route('admin.faqs.faq.index') }}">FAQs</a>
        </li>
        <li class="breadcrumb-item active">FAQ</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de FAQ (Preguntas frecuentes)</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.faqs.faq.create') }}"
                            class="btn btn-success btn-sm"
                            title="Crear">
                            Crear <i class="fas fa-plus-circle"></i>
                        </a>

                         <a href="{{ route('admin.faqs.faq.orden') }}"
                            class="btn btn-success btn-default"
                            title="Crear">
                            Orden <i class="fa fa-fw fa-align-center"></i></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tb-faqs" class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>Pregunta</th>
                                <th>Categoria</th>
                                <th>Totales</th>
                                <th>Creado</th>
                                <th>Visible</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            const dom = {
                table: $('#tb-faqs'),
            };

            $.fn.DataTable.ext.pager.numbers_length = 5;

            var dt = dom.table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
                ajax: {
                    url: "{{ route('admin.faqs.faq.datatables') }}",
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
                    {data: 'pregunta',name: 'pregunta'},
                    {data: 'nombre_categoria',name: 'categoria.nombre'},
                    {data: 'totales',name: 'totales', className:'text-center'},
                    {data: 'creado',name: 'created_at'},
                    {data: 'visible',name: 'visible', className:'text-center'},
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
            })
        })
    </script>
@endpush
