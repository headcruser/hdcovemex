@extends('layouts.panel')

@section('title','Gestion de personal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">
            Gestión de inventarios
        </li>
        <li class="breadcrumb-item active">Personal</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Gestión de personal</h3>
                <div class="card-tools">
                    <a href="{{ route('gestion-inventarios.personal.create') }}" class="btn btn-success btn-sm" title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </a>

                    <button class="btn btn-primary btn-sm" type="button" id="btn-importar-personal">
                        <i class="fas fa-upload" aria-hidden="true"></i>
                        Importar Personal
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row pb-4">
                    <div class="col-6">
                        <div class="form-inline form-search">
                            <div class="form-group">
                                {!! Form::label('select-departamento', 'Departamento: ', []) !!}&nbsp;
                                {!! Form::select('deparamentos', $departamentos , null, ['id' => 'select-departamento' , 'class' => 'custom-select custom-select-sm','data-filter']) !!}
                            </div>
                            &nbsp;&nbsp;
                            <div class="form-group">
                                <label class="form-label-sm">Empresa:</label>&nbsp;
                                <div class="btn-group">
                                    {!! Form::select('status', $sucursales , null, ['id' => 'select-sucursal' , 'class' => 'custom-select custom-select-sm','data-filter']) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <table id="tb-personal" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th># Impresión</th>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Departamento</th>
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

    @include('gestion-inventarios.personal.modals._importar_usuarios')
@endsection


@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/dist/js/dropify.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            const dom = {
                table: $('#tb-personal'),
                importar_personal:{
                    button: $("#btn-importar-personal"),
                    form: $("#form-importar-personal"),
                    modal:$("#modal-importar-personal"),
                    errors:$("#errores-importar-personal")
                }
            };

            $.fn.DataTable.ext.pager.numbers_length = 5;

            var dt = dom.table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
                ajax: {
                    url: "{{ route('gestion-inventarios.personal.datatables') }}",
                    type: "POST",
                    data: function (d) {
                        d.id_departamento = $('#select-departamento').val();
                        d.id_sucursal = $('#select-sucursal').val();
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
                    {data: 'id_impresion',name: 'id_impresion'},
                    {data: 'nombre',name: 'nombre'},
                    {data: 'sucursal.descripcion',name: 'sucursal.descripcion'},
                    {data: 'departamento.nombre',name: 'departamento.nombre'},
                    {data: 'buttons', name: 'buttons', orderable: false, searchable: false,className:'text-center'}
                ],
                order: [[ 2, "desc" ]],
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
            })

            $('select[data-filter]').on('change',function(){
                dt.draw();
            });

            var m_importar_personal = (function(d){
                const templates = {
                    errors : `<div class="alert alert-danger" role="alert">:message</div>`
                };

                var drEvent = $('.dropify').dropify({
                    messages: {
                        default: 'Arrastre o pulse para seleccionar un archivo',
                        replace: 'Arrastre o pulse para reemplazar archivo',
                        remove: 'Quitar',
                        error: 'Ups, ha ocurrido un error inesperado'
                    }
                });

                var loadFormData = function(){
                    var formData = new FormData();

                    var archivo = d.form.find('input[type=file]')[0].files[0];
                    formData.append('personal', archivo);

                    var data = d.form.serializeArray();
                    $.each(data,function(key,input){
                        formData.append(input.name,input.value);
                    });

                    return formData
                }

                var abrir_modal = function(e){
                    d.form[0].reset();
                    d.errors.html('')
                    d.modal.modal('show');
                    $(".dropify-clear").trigger("click");
                }

                var importar = function(e){
                    e.preventDefault();

                    d.modal.modal('hide');

                    Swal.fire({
                        title: 'Procesando',
                        html: 'Espere un momento por favor.',
                        allowEscapeKey:false,
                        allowOutsideClick:false,
                        allowEnterKey:false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        },
                    })

                    $.ajax({
                        method: 'POST',
                        url: e.target.action,
                        data: loadFormData(),
                        cache: false,
                        contentType: false,
                        processData: false,
                    })
                    .done(function(response) {

                        if(response.success){
                            d.form[0].reset();
                            $(".dropify-clear").trigger("click");

                            dt.ajax.reload( function(){
                                Swal.close();

                                Toast.fire({
                                    type: 'success',
                                    title: response.message || 'Archivo Importado correctamente',
                                });
                            }, false );
                        }
                    })
                    .fail(function(error){
                        setTimeout(() => {
                            const response = error.responseJSON;
                            let lista_errores = '';
                            let mensaje_error = '';

                            if (response) {
                                if (response.error) {
                                    let errors = response.details || [];
                                    lista_errores = errors.map((e)=>`<li class="text-white font-weight-bold">${e}</li>`).join('');

                                    mensaje_error =  response.error || 'Error al Importar el archivo';
                                }else{
                                    mensaje_error = response.message || 'Error al importar el archivo'
                                }
                            }else{
                                mensaje_error = 'Error al obtener la respuesta del servidor'
                            }


                            d.errors.html(templates.errors.replace(':message',`
                                <p class='py-2'>${mensaje_error}</p>

                                <ul>
                                    ${lista_errores}
                                </ul>
                            `));

                            Swal.close();
                            d.modal.modal('show');

                        }, 250);
                    })
                };

                var dropify_after_clear = function(event, element){
                    d.errors.html('');
                };

                // EVENTOS
                d.form.submit(importar);
                d.button.click(abrir_modal);
                drEvent.on('dropify.afterClear', dropify_after_clear);
            })(dom.importar_personal);
        });
    </script>
@endsection

