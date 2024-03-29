@extends('layouts.panel')

@section('title','Detalle del equipo')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/x-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{asset('vendor/dropify/dist/css/dropify.min.css') }}"  >
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <style>
        /* SOLUCION PARA VISUALIZAR LOS ICONOS DEL CALENDARIO SELECT2 */
        .icon-arrow-left:before {content: "\2190 ";}
        .icon-arrow-right:before {content: "\2192 ";}
    </style>
    @parent
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item"> <a href="#">
        Gestión de inventarios </a>
        </li>
        <li class="breadcrumb-item"> <a href="{{ route('gestion-inventarios.equipos.index') }}">
            Equipo </a>
        </li>
        <li class="breadcrumb-item active">Detalle equipo</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $equipo->uid }}</h3>

                <p class="text-muted text-center">
                    <a class="editable_descripcion_equipo"
                        data-name="descripcion"
                        data-type="textarea"
                        data-value="{{ $equipo->descripcion }}"
                        data-pk="{{ $equipo->id }}"
                        data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                        data-placeholder="Descripcion"> {{ $equipo->descripcion }} </a>
                    </p>

                <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Fecha de creación</b> <a class="float-right">{{ $equipo->fecha_equipo->format('d-m-Y') }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tipo</b>
                            <a class="float-right editable_tipo_equipo"
                                data-name="tipo"
                                data-type="select"
                                data-value="{{ $equipo->tipo }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Tipo"> {{ $equipo->tipo }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>Marca</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="marca"
                                data-type="text"
                                data-value="{{ $equipo->marca }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Marca"> {{ $equipo->marca }} </a>
                        </li>

                        <li class="list-group-item">
                            <b>Modelo</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="modelo"
                                data-type="text"
                                data-value="{{ $equipo->modelo }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Modelo"> {{ $equipo->modelo }} </a>
                        </li>
                        <li class="list-group-item">
                            <b># Serie</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="no_serie"
                                data-type="text"
                                data-value="{{ $equipo->no_serie }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Serie"> {{ $equipo->no_serie }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>S.O</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="sistema_operativo"
                                data-type="text"
                                data-value="{{ $equipo->sistema_operativo }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="S.O"> {{ $equipo->sistema_operativo }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>Procesador</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="procesador"
                                data-type="text"
                                data-value="{{ $equipo->procesador }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Procesador"> {{ $equipo->procesador }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>Memoria</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="memoria"
                                data-type="text"
                                data-value="{{ $equipo->memoria }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Memoria"> {{ $equipo->memoria }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>Almacenamiento</b>
                            <a class="float-right editable_informacion_equipo"
                                data-name="almacenamiento"
                                data-type="text"
                                data-value="{{ $equipo->almacenamiento }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Memoria"> {{ $equipo->almacenamiento }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>Fecha Compra</b>
                            <a class="float-right editable_fecha_compra_equipo"
                                data-name="fecha_compra"
                                data-type="date"
                                data-value="{{ optional($equipo->fecha_compra)->format('Y-m-d') }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Fecha Compra"> {{ optional($equipo->fecha_compra)->format('d-m-Y') }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>Estatus</b>
                            <a class="float-right editable_status_equipo"
                                data-name="status"
                                data-type="select"
                                data-value="{{ $equipo->status }}"
                                data-pk="{{ $equipo->id }}"
                                data-url="{{ route('gestion-inventarios.equipos.actualizar_informacion') }}"
                                data-placeholder="Status"> {{ $equipo->status }} </a>
                        </li>
                </ul>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-12 col-sm-8" id="contenedor-info-personal">
            <div class="card card-solid">
                <div class="card-header">
                    <h3 class="card-title">Componentes del equipo</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary" id="btn-agregar-compoentes-equipo">Agregar componente</button>
                    </div>
                </div>
                <div class="card-body" id="lista-info">
                    <table class="table table-bordered" id="tb-componentes-equipo">
                        <thead>
                            <tr>
                                <th>#</th>
                                <td>Hardware</td>
                                <td># Serie</td>
                                <td>Marca</td>
                                <td>Observacion</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                <div class="card card-solid">
                    <div class="card-header">
                        <h3 class="card-title">Historial de asignación</h3>
                        <div class="card-tools">
                            <button id="btn-asignar-equipo" class="btn btn-secondary">Asignar equipo</button>
                        </div>
                    </div>
                    <div class="card-body" id="lista-historial-asignacion">
                        <table class="table table-bordered" id="tb-historial-asignacion">
                            <thead>
                                <tr>
                                    <th>Personal</th>
                                    <th>Departamento</th>
                                    <th>Fecha de asignacion</th>
                                    <th>Observaciones</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal fade" id="modal-componentes-equipo" data-keyboard="false"  data-backdrop="static" aria-hidden="true" tabindex='-1'>
        <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
            <h4 class="modal-title">Componente del equipo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            {!! Form::open(['id' => 'form-componentes-equipo', 'accept-charset' => 'UTF-8', 'enctype' =>'multipart/form-data']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('id_hardware', 'Hardware:*') !!}
                    {!! Form::select('id_hardware',[], null, ['id' => 'select-id_hardware', 'class' => 'form-control','autocomplete' => 'off','required' => true,'style' => 'width:100%']) !!}
                    <small data-help class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    {!! Form::label('observacion', 'Observación:*') !!}
                    {!! Form::textarea('observacion',null, ['id' => 'ta-observacion' ,'class' => 'form-control','rows' => 3]) !!}
                    <small data-help class="form-text text-muted"></small>
                </div>
                <div id="d-errors-componentes-equipo" class="form-group"></div>
                {!! Form::hidden('id_equipo', $equipo->id) !!}
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-asignar-equipo" data-keyboard="false"  data-backdrop="static" aria-hidden="true" tabindex='-1'>
        <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
            <h4 class="modal-title">Asignación de equipo <small>(*) Campos Obligatorios</small></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            {!! Form::open(['id' => 'form-asignar-equipo', 'accept-charset' => 'UTF-8', 'enctype' =>'multipart/form-data']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('id_personal', 'Usuario:*') !!}
                    {!! Form::select('id_personal',[], null, ['id' => 'select-id_personal', 'class' => 'form-control','autocomplete' => 'off','required' => true,'style' => 'width:100%']) !!}
                    <small data-help class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    {!! Form::label('fecha_entrega', 'Fecha de entrega:') !!}
                    {!! Form::date('fecha_entrega', null, ['class' => 'form-control','autocomplete' => 'off','style' => 'width:100%']) !!}
                    <small data-help class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    {!! Form::label('observaciones', 'Observaciónes:') !!}
                    {!! Form::textarea('observaciones',null, ['class' => 'form-control','rows' => 3, 'placeholder' => 'Motivo de entrega']) !!}
                    <small data-help class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    {!! Form::label('input-carta-responsiva', 'Carta Responsiva:') !!}
                    <input type="file" id="input-carta-responsiva" class="dropify-carta-respnsiva" name="carta_responsiva" accept="image/*,.pdf"/>
                    <small id="ver-link-archivo" class="form-text"> <a href="#" class="btn-link" target="_blank" rel="noopener noreferrer">Ver archivo</a></small>
                </div>

                <div id="d-errors-asignar-equipo" class="form-group"></div>
                {!! Form::hidden('id_equipo', $equipo->id) !!}
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('vendor/x-editable/js/x-editable.min.js') }}"></script>
    <script src="{{asset('vendor/dropify/dist/js/dropify.min.js') }}"></script>

    <script type="text/javascript">
        // 👉 CONFIGURACION DE PLUGINGS
        $(function() {
            $.fn.size = function() {
                return this.length;
            }

            const CONFIG_DATEPICKER = {
               	days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                monthsTitle: "Meses",
                clear: "Borrar",
                weekStart: 1,
            }

            $.fn.bdatepicker.dates['en'] = CONFIG_DATEPICKER;
        });

        const m_equipos = (function(){
            const dom =  {
                contenedor_info:$("#contenedor-info-personal"),
                tb_componentes_equipo: $("#tb-componentes-equipo"),
                modal_componentes_equipo: $("#modal-componentes-equipo"),
                form_componentes_equipo: $("#form-componentes-equipo"),
                btn_agregar_compoentes_equipo:$("#btn-agregar-compoentes-equipo"),

                btn_asignar_equipo: $("#btn-asignar-equipo"),
                modal_asignar_equipo:$("#modal-asignar-equipo"),
                form_asignar_equipo: $("#form-asignar-equipo"),
                tb_historial_asignacion: $("#tb-historial-asignacion"),
            }

            // 👉 XEDITABLE
            $('.editable').on('shown', function(e, editable) {
                $('.editable-submit').html('<i class="fas fa-check fa-1x"></i>');
                $('.editable-cancel').html('<i class="fas fa-times"></i>');
            });

            $('.editable_descripcion_equipo').editable({
                'emptytext': 'Vacio',
                'onblur': 'ignore'
            });

            $('.editable_informacion_equipo').editable({
                'emptytext': 'Vacio',
                'onblur': 'ignore'
            });

            $('.editable_tipo_equipo').editable({
                emptytext: 'Vacio',
                onblur: 'ignore',
                 source: [
                    @foreach ($tipo as $tipo)
                        {value: '{{ $tipo }}', text: '{{ $tipo }}'},
                    @endforeach
                ],
            });

            $('.editable_status_equipo').editable({
                emptytext: 'Vacio',
                onblur: 'ignore',
                source: [
                    @foreach ($estatus as  $item)
                        {value: '{{ $item }}', text: '{{ $item }}'},
                    @endforeach
                ],
            });

            $('.editable_fecha_compra_equipo').editable({
                emptytext: 'Vacio',
                onblur: 'ignore',
                format: 'yyyy-mm-dd',
                viewformat: 'dd-mm-yyyy',
                datepicker: {
                    weekStart: 1,
                    orientation: 'bottom right',
                    language: 'en',
                },
            });

            // GESTION DE COMPONENTES DEL EQUIPO
            $('#select-id_hardware').select2({
                dropdownParent: dom.modal_componentes_equipo,
                languaje: "es",
                placeholder: "Selecciona el hardware",
                ajax: {
                    method: 'POST',
                    data:
                    function (params) {
                        return {
                            term: params.term,
                            page: params.page || 1,
                            no_asignado: true
                        }
                    },
                    url: '{{ route("gestion-inventarios.hardware.select2") }}',
                    dataType: 'json',
                    cache: false,
                    delay:250,
                    beforeSend:function(xhr,type){
                        xhr.setRequestHeader('X-CSRF-Token',$('meta[name="csrf-token"]').attr('content'))
                    }
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function(option){
                    if (option.loading) {
                        return option.text;
                    }


                    return `${option.descripcion} || ${option.no_serie || 'Sin serie'} || ${option.marca || 'Sin Marca'} || ${option.proveedor || 'Sin Proveedor'}`;
                },
                templateSelection:function(option) {
                    if (option.loading) {
                        return option.text;
                    }

                    if (!option.descripcion) {
                        return option.text;
                    }

                    return `${option.descripcion || ''}`;
                }
            });

            var dt = dom.tb_componentes_equipo.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
                ajax: {
                    url: "{{ route('gestion-inventarios.equipos.datatables_componentes_equipo') }}",
                    type: "POST",
                    data: function (d) {
                        d.id_equipo = "{{ $equipo->id }}"
                    },
                    beforeSend: function(xhr,type) {
                    if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                    complete: function() {
                    },
                },
                responsive: true,
                columns: [
                    {data: 'id',name: 'id'},
                    {data: 'hardware.descripcion',name: 'hardware.descripcion'},
                    {data: 'hardware.no_serie',name: 'hardware.no_serie'},
                    {data: 'hardware.marca',name: 'hardware.marca'},
                    {data: 'observacion',name: 'observacion'},
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

            dom.btn_agregar_compoentes_equipo.click(function(e){
                dom.modal_componentes_equipo.modal('show');
                dom.modal_componentes_equipo.data('url',"{{ route('gestion-inventarios.equipos.agregar_componente_equipo') }}")
                dom.modal_componentes_equipo.data('metodo',"POST");
                dom.modal_componentes_equipo.find("#d-errors-componentes-equipo").html(null);

                dom.form_componentes_equipo.trigger('reset');
                $('#select-id_hardware').val(null).trigger('change');
            });

            dom.tb_componentes_equipo.on('click',"a[data-action='destroy']",function(e){
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

            dom.tb_componentes_equipo.on('click',"a[data-action='update']",function(e){
                e.preventDefault();

                dom.modal_componentes_equipo.find("#d-errors-componentes-equipo").html(null);

                const url_buscar = $(this).attr('href');
                const url_actualizar = $(this).data('update');

                $.ajax({
                    url: url_buscar,
                    type: 'POST',
                    data: {},
                    success: function (response){
                        dom.modal_componentes_equipo.data('url',url_actualizar)
                        dom.modal_componentes_equipo.data('metodo',"PUT");

                        dom.modal_componentes_equipo.modal('show');
                        dom.modal_componentes_equipo.find('#form-componentes-equipo [name="observacion"]').val(response.data.observacion);

                       var result = `${response.data.hardware.descripcion} || ${response.data.hardware.no_serie} || ${response.data.hardware.marca} || ${response.data.hardware.proveedor}`;
                       var newOption = new Option(result, response.data.id_hardware, false, false);
                       $('#select-id_hardware').empty().append(newOption).trigger('change');
                    },
                    error:function(error){
                        Toast.fire({
                            type: 'error',
                            title: 'Ups, hubo un error en el servidor'
                        });
                    }
                });
            });

            dom.form_componentes_equipo.submit(function(e){
                e.preventDefault();
                dom.modal_componentes_equipo.modal('hide');

                var url = dom.modal_componentes_equipo.data('url');
                var method = dom.modal_componentes_equipo.data('metodo');

                var formData = new FormData(this);

                if (method == 'PUT'){
                    formData.append('_method',method);
                }

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                })
                .done(function(response) {
                    dt.ajax.reload( function(){
                        Toast.fire({
                            type: 'success',
                            title: response.message || 'Componente agregado correctamente'
                        })
                    }, false );
                }).fail(function(error) {
                    const errors = error.responseJSON;

                    if (errors) {
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                dom.form_componentes_equipo.find(`[name=${key}]`).next().html(errors[key])
                            }
                        }
                    }else{
                        dom.modal_componentes_equipo.find("#d-errors-componentes-equipo").addClass('text-danger').html('Error al enviar la información');
                    }

                    dom.modal_componentes_equipo.modal('show');
                })
            });

            // 👉 ASIGNACION DE EQUIPO
            var droppy = $('.dropify-carta-respnsiva').dropify({
                messages: {
                    default: 'Arrastre o pulse para seleccionar imagen',
                    replace: 'Arrastre o pulse para reemplazar imagen',
                    remove: 'Quitar',
                    error: 'Ups, ha ocurrido un error inesperado'
                }
            });

            var dt_historial_asignacion = dom.tb_historial_asignacion.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                dom: "<'row'<'col-xs-12 col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-start'l><'col-xs-12 col-sm-6'f>><'row'<'col-12 table-responsive p-0'tr>><'row'<'col-xs-12 col-sm-7'i><'col-xs-12 col-sm-5 align-self-end d-flex justify-content-center justify-content-sm-end'p>>",
                ajax: {
                    url: "{{ route('gestion-inventarios.equipos.datatables_asignar_equipo') }}",
                    type: "POST",
                    data: function (d) {
                        d.id_equipo = "{{ $equipo->id }}"
                    },
                    beforeSend: function(xhr,type) {
                    if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                    complete: function() {
                        $('.editable_observaciones_equipo_asignado').editable({
                            'emptytext': 'Vacio',
                            'onblur': 'ignore'
                        });

                        $('.editable_observaciones_equipo_asignado').on('save', function(e, params) {
                            const $btn_editar = $(this).closest('tr').find('[data-action="editar-asignacion"]');
                            $btn_editar.attr('data-object',JSON.stringify(params.response.equipo || {}));
                        });

                        $('.editable_fecha_entrega_equipo_asignado').editable({
                            emptytext: 'Vacio',
                            onblur: 'ignore',
                            format: 'yyyy-mm-dd',
                            viewformat: 'dd-mm-yyyy',
                            datepicker: {
                                weekStart: 1,
                                orientation: 'bottom right',
                                language: 'en',
                            },
                        });

                        $('.editable_fecha_entrega_equipo_asignado').on('save', function(e, params) {
                            const $btn_editar = $(this).closest('tr').find('[data-action="editar-asignacion"]');
                            $btn_editar.attr('data-object',JSON.stringify(params.response.equipo || {}));
                        });

                        $('.editable_status_equipo_asignado').editable({
                            emptytext: 'Vacio',
                            onblur: 'ignore',
                            source: [
                                {value: 'Asignado', text: 'Asignado'},
                                {value: 'Inactivo', text: 'Inactivo'},
                            ],
                        });
                    },
                },
                pageLength: 10,
                responsive: true,
                columns: [
                    {data: 'personal.nombre',name: 'personal.nombre'},
                    {data: 'personal.departamento.nombre',name: 'personal.departamento.nombre'},
                    {data: 'fecha_entrega',name: 'fecha_entrega'},
                    {data: 'observaciones',name: 'observaciones'},
                    {data: 'status',name: 'status'},
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

            dom.btn_asignar_equipo.click(function(e){
                dom.form_asignar_equipo[0].reset();
                $('#select-id_personal').empty().trigger('change');
                $("#ver-link-archivo").hide();
                $("#ver-link-archivo").find('.btn-link').attr('href','#');

                $(".dropify-clear").trigger("click");

                dom.form_asignar_equipo.attr('method','POST')
                dom.form_asignar_equipo.attr('action',"{{ route('gestion-inventarios.equipos.asignar_equipo') }}")
                dom.modal_asignar_equipo.modal('show');
            });

            dom.tb_historial_asignacion.on('click','[data-action="editar-asignacion"]',function(e){
                e.preventDefault();
                const data = JSON.parse($(this).attr('data-object'));

                dom.form_asignar_equipo[0].reset();
                dom.form_asignar_equipo.find("[name='observaciones']").val(data.observaciones);
                dom.form_asignar_equipo.find("[name='fecha_entrega']").val(data.format_fecha_entrega);
                dom.form_asignar_equipo.attr('method','PUT')
                dom.form_asignar_equipo.attr('action',$(this).attr('href'));

                if(data.id_personal){
                    var newOption = new Option(data.personal.nombre, data.id_personal, false, false);
                    $('#select-id_personal').empty().append(newOption).trigger('change');
                }

                drEvent = droppy.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();



                if (data.carta_responsiva) {
                    const url = "{{ asset(Storage::url('_url')) }}".replace('_url',data.carta_responsiva);
                    drEvent.settings.defaultFile = url

                    $("#ver-link-archivo").show();
                    $("#ver-link-archivo").find('.btn-link').attr('href',url);
                }else{
                    $("#ver-link-archivo").hide();
                    $("#ver-link-archivo").find('.btn-link').attr('href','#');
                }

                drEvent.destroy();
                drEvent.init();


                dom.modal_asignar_equipo.modal('show');
            })

            dom.form_asignar_equipo.submit(function(e){
                e.preventDefault();

                dom.modal_asignar_equipo.modal('hide');

                var formData = new FormData(this);

                const url = $(this).attr('action');
                const isOtherMethod = ($(this).attr('method') != 'POST');
                const method = 'POST';

                if(isOtherMethod){
                    formData.append('_method',$(this).attr('method'));
                }

                $.ajax({
                    method: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                })
                .done(function(response) {
                    dt_historial_asignacion.ajax.reload( function(){
                        Toast.fire({
                            type: 'success',
                            title: response.message || 'Equipo asignado correctamente',
                        });
                    }, false );
                }).fail(function(error) {
                    const errors = error.responseJSON.errors || {}

                    for (const key in errors) {
                        if (Object.hasOwnProperty.call(errors, key)) {
                            dom.form_asignar_equipo.find(`[name=${key}]`).next().html(errors[key])
                        }
                    }
                    dom.modal_asignar_equipo.modal('show');
                });
            });

            dom.tb_historial_asignacion.on('click','[data-action="eliminar-asignacion"]',function(e){
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
                                dt_historial_asignacion.ajax.reload( function(){
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

            $('#select-id_personal').select2({
                dropdownParent: dom.modal_asignar_equipo,
                languaje: "es",
                placeholder: "Selecciona el personal",
                ajax: {
                    method: 'POST',
                    data:
                    function (params) {
                        return {
                            term: params.term,
                            page: params.page || 1,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    url: '{{ route("gestion-inventarios.personal.select2") }}',
                    dataType: 'json',
                    cache: false,
                    delay:250,
                    beforeSend:function(xhr,type){
                        xhr.setRequestHeader('X-CSRF-Token',$('meta[name="csrf-token"]').attr('content'))
                    }
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function(option){
                    if (option.loading) {
                        return option.text;
                    }

                    return option.nombre||option.text;
                },
                templateSelection:function(option){
                    if(option.loading) {
                        return option.text;
                    }

                    return option.nombre||option.text;
                }
            });
        })();

    </script>
@endpush

