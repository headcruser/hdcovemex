@extends('layouts.panel')

@section('title','Administrar Usuarios')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Administración </li>
    <li class="breadcrumb-item active">Usuarios</li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de usuarios</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.usuarios.create') }}"
                            class="btn btn-success btn-sm"
                            title="Crear">
                            Crear <i class="fas fa-plus-circle"></i>
                        </a>

                        <button class="btn btn-primary btn-sm" type="button" id="btn-importar-usuario">
                            <i class="fas fa-upload" aria-hidden="true"></i>
                            Importar Usuarios
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tb-usuarios" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>NOMBRE</th>
                                <th>USUARIO</th>
                                <th>EMAIL</th>
                                <th>DEPARTAMENTO</th>
                                <th>ROLES</th>
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

    <div class="onboarding-modal modal fade animated" id="modal-importar-usuario" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Importar usuarios</b></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                {!! Form::open(['id' => 'form-importar-usuario', 'route' => 'admin.usuarios.importar', 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                <div class="modal-body">
                    <p>Adjunta el archivo de importación Masiva con el siguiente formato</p>
                    <p><code>Nota:</code> La columna departamento debe existir, de lo contrario sera nulo</p>

                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr class="text-center">
                                <td>usuario_id</td>
                                <td>correo</td>
                                <td>usuario</td>
                                <td>departamento</td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="errores-importar-usuario"></div>

                    <input class="dropify"
                        type="file"
                        name="usuario"
                        data-allowed-file-extensions="xlsx xls"
                        data-max-file-size-preview="2M"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary dim float-right" type="submit"><i class="fas fa-upload"></i> Importar</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/dist/js/dropify.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            const dom = {
                table: $('#tb-usuarios'),
                importar_usuarios:{
                    button: $("#btn-importar-usuario"),
                    form: $("#form-importar-usuario"),
                    modal:$("#modal-importar-usuario"),
                    errors:$("#errores-importar-usuario")
                }
            };

            var dt = dom.table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                dom: "<'row'<'col-6 d-flex align-items-center'l><'col-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-7'i><'col-5 align-self-end d-flex justify-content-end'p>>",
                ajax: {
                    url: "{{ route('admin.usuarios.datatables') }}",
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
                    {data: 'email',name: 'email'},
                    {data: 'departamento.nombre',name: 'departamento.nombre'},
                    {data: 'roles', orderable: false, searchable: false,className:'text-center'},
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

            var m_importar = (function(d){
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
                    formData.append('usuario', archivo);

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
                        d.form[0].reset();
                        $(".dropify-clear").trigger("click");

                        dt.ajax.reload( function(){
                            Swal.close();

                            Toast.fire({
                                type: 'success',
                                title: response.message || 'Usuarios Importados correctamente',
                            });
                        }, false );
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

                                    mensaje_error =  response.error || 'Error al Importar al usuario';
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
            })(dom.importar_usuarios);
        })
    </script>
@endsection

