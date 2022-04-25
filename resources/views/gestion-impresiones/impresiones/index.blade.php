@extends('layouts.panel')

@section('title','Gestion de Impresiones')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Gestion de Inventarios </li>
    <li class="breadcrumb-item active">Impresiones</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de reportes de impresiones</h3>
                <div class="card-tools">
                    <a href="{{ route('gestion-impresiones.impresiones.create') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>

                    <button type="button"
                        id="btn-generar-reportes"
                        class="btn btn-primary btn-sm"
                        title="Generar Reportes">
                        Crear Reportes del año
                    </button>

                    <a href="{{ route('gestion-impresiones.impresiones.visualizar-impresiones') }}"
                        class="btn btn-secondary btn-sm"
                        title="Visualizar impresiones">
                        Visualizar impresiones
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-auto" >
                        <div class="form-group">
                            <label>Año:</label>
                            <label>
                                {!! Form::select('anio', $years, null, ['id' => 'select-anio','class' => 'custom-select custom-select-sm w-100']) !!}
                            </label>
                        </div>
                    </div>
                    <div class="col-auto" >
                        <div class="form-group">
                            <label>Mes:</label>
                            <label>
                                {!! Form::select('mes', $months, null, ['id' => 'select-mes','class' => 'custom-select custom-select-sm w-100']) !!}
                            </label>
                        </div>
                    </div>
                </div>


                <table id="tb-impresiones" class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th>ID </th>
                            <th>MES </th>
                            <th>FECHA REGISTRO </th>
                            <th>NEGRO </th>
                            <th>COLOR </th>
                            <th>TOTAL</th>
                            <th>AUTOR</th>
                            <th>ACCIONES</th>
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

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            const dom = {
                table: $('#tb-impresiones'),
                filters: {
                    anio: $("#select-anio"),
                    mes: $("#select-mes"),
                },
                btn_generar_reportes: $("#btn-generar-reportes"),
            };

            $.fn.DataTable.ext.pager.numbers_length = 5;

            dom.filters.anio.val(moment().year());

            var dt = dom.table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
                ajax: {
                    url: "{{ route('gestion-impresiones.impresiones.datatables') }}",
                    type: "POST",
                    data: function (d) {
                        d.anio = dom.filters.anio.val();
                        d.mes = dom.filters.mes.val();
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
                    {data: 'id',name: 'id',visible:false},
                    {data: 'mes',name: 'mes'},
                    {data: 'fecha',name: 'fecha'},
                    {data: 'negro',name: 'negro'},
                    {data: 'color',name: 'color'},
                    {data: 'total',name: 'total'},
                    {data: 'usuario.nombre',name: 'usuario.nombre'},
                    {data: 'buttons', name: 'buttons', orderable: false, searchable: false,className:'text-center'}
                ],
                order: [[ 1, "desc" ]],
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

            dom.filters.anio.change(function(){
                dt.draw();
            });

            dom.filters.mes.change(function(){
                dt.draw();
            });

            dom.btn_generar_reportes.click(function(e){
                Swal.fire({
                    title: 'Crear Informes del año',
                    html:`
                        <p class="text-muted">Unicamente se daran de alta los informes que no hayan sido creados</p>
                        <div class="form-group">
                            <input type="number" id="input-reporte-anio" class="form-control" min="1900" max="2099" step="1" value="{{ now()->addYear()->year }}"/>
                        </div>
                    `,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:'Aceptar',
                    confirmButtonAriaLabel: 'Aceptar',
                    cancelButtonText:'Cancelar',
                    cancelButtonAriaLabel: 'Cancelar'
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('gestion-impresiones.impresiones.generar-reportes') }}",
                            type: 'POST',
                            data: {
                                anio: $("#input-reporte-anio").val(),
                            },
                            success: function (response){
                                if(response.success){
                                    dt.ajax.reload( function(){
                                        Toast.fire({
                                            type: 'success',
                                            title: response.message || 'Registro eliminado correctamente',
                                        });
                                    }, false )
                                }
                            },
                            error:function(error){
                                Toast.fire({
                                    type: 'error',
                                    title: 'Ups, hubo un error en el servidor'
                                });
                            }
                        });


                    }
                });
            })
        })
    </script>
@endsection

