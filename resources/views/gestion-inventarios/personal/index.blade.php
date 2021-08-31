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
            <table id="tb-personal" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th># Impresión</th>
                        <th>Nombre</th>
                        <th>Sucursal</th>
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


  <div class="onboarding-modal modal fade animated" id="modal-importar-personal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">Importar Personal</b></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            {!! Form::open(['id' => 'form-importar-personal', 'route' => 'gestion-inventarios.personal.importar', 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
            <div class="modal-body">
                <p>Adjunta el archivo de importación Masiva con el siguiente formato</p>
                <p><code>Nota:</code> Las clumnas de sucursal deben existir para poder vincularlas, en caso contrario las dejará vacias</p>

                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr class="text-center">
                            <td>nombre</td>
                            <td>id_impresion</td>
                            <td>sucursal</td>
                            <td>departamento</td>
                        </tr>
                    </tbody>
                </table>

                <div id="errores-importar-personal"></div>

                <input class="dropify"
                    type="file"
                    name="personal"
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
            // INDISPENSABLE
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const dom = {
                table: $('#tb-personal'),
                importar_personal:{
                    button: $("#btn-importar-personal"),
                    form: $("#form-importar-personal"),
                    modal:$("#modal-importar-personal"),
                    errors:$("#errores-importar-personal")
                }
            };

            var dt = dom.table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                ajax: {
                    url: "{{ route('gestion-inventarios.personal.datatables') }}",
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
                        d.form[0].reset();
                        $(".dropify-clear").trigger("click");

                        dt.ajax.reload( function(){
                            Swal.close();

                            Toast.fire({
                                type: 'success',
                                title: 'Registro eliminado correctamente',
                            });
                        }, false );
                    })
                    .fail(function(error){
                        setTimeout(() => {
                            var message = error.responseJSON.error || 'Error Al Importar al personal';
                            var errors = error.responseJSON.details || []

                            if(errors) {
                                var display_erorrs = errors.map((e)=>`<li class="text-white font-weight-bold">${e}</li>`).join('');
                                d.errors.html(templates.errors.replace(':message',`
                                    <ul>
                                        ${display_erorrs}
                                    </ul>
                                `));
                            }else{
                                d.errors.html(templates.errors.replace(':message',`
                                    <ul>
                                        ${error.responseJSON.message || 'Error al importar el personal'}
                                    </ul>
                                `));
                            }

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

