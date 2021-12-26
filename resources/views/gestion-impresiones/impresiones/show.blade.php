@extends('layouts.panel')

@section('title','Panel de impresiones')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i>  </a>
        </li>
        <li class="breadcrumb-item">Gestion Inventarios</li>
        <li class="breadcrumb-item"><a href="{{ route('gestion-impresiones.impresiones.index') }}">Impresiones</a></li>
        <li class="breadcrumb-item active">Ver #{{ $impresion->nombre_mes }}</li>
    </ol>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">Reporte del mes de {{ $impresion->nombre_mes }}</h3>

                    <p class="text-muted text-center">{{ $impresion->anio }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Fecha de creación</b> <a class="float-right">{{ optional($impresion->fecha)->format('d-m-Y') }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Creador por</b> <a class="float-right">{{ $impresion->usuario->nombre }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Negro</b> <a class="float-right">{{ $impresion->negro }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Color</b> <a class="float-right">{{ $impresion->color }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Total</b> <a class="float-right">{{ $impresion->total }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-6">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">Opciones de importación</h3>

                    <p class="text-muted text-center">Selecciona una de las opciones para cargar los registros de impresión</p>

                    <button id="btn-agregar-reporte" class="btn btn-primary btn-block">Importar con registros de impresion</button>
                    <button id="btn-importar-impresiones" class="btn btn-secondary btn-block">Importar mediante archivo excel</button>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">Herramientas</h3>

                    <p class="text-muted text-center">Verifica la salida de impresiones antes de precargarlo a base de datos</p>

                    <a href="{{ route('gestion-impresiones.impresiones.visualizar-impresiones') }}"
                        class="btn btn-dark btn-block btn-sm"
                        title="Visualizar impresiones">
                        Visualizar impresiones
                    </a>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    @if($detalles_por_impresora->count())
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        @foreach ($detalles_por_impresora as $impresora => $detalles)
                            <li class="nav-item">
                                <a class="nav-link @if ($loop->first) active @endif" id="custom-tabs-impresiones-{{ $loop->index }}" data-toggle="pill" href="#tab-impresiones-{{ $loop->index }}" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">{{ $impresora }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="tab-content-impresoras">
                        @foreach ($detalles_por_impresora as $impresora => $detalles)

                            <div class="tab-pane fade  @if ($loop->first) active show @endif" id="tab-impresiones-{{ $loop->index }}" role="tabpanel" aria-labelledby="custom-tabs-impresiones-{{ $loop->index }}">
                                <div class="row justify-content-center">
                                    @if ($detalles->sum('negro') > 0)
                                        <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-black">
                                            <div class="inner">
                                            <h3>{{ $detalles->sum('negro') }}</h3>

                                            <p>Total Impresiones Negro</p>
                                            </div>
                                        </div>
                                        </div>

                                    @endif

                                    @if ($detalles->sum('color') > 0)
                                        <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                            <h3>{{ $detalles->sum('color') }}</h3>
                                            <p>Total Impresiones Color</p>
                                            </div>
                                        </div>
                                        </div>
                                    @endif

                                    @if ($detalles->sum('total') > 0)
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-warning">
                                                <div class="inner">
                                                <h3>{{ $detalles->sum('total') }}</h3>

                                                <p>Total Impresiones</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-12 my-3">
                                        @if($impresoras_registradas->contains($detalles->first()->id_impresora))
                                            <button class="btn btn-primary btn-sm" data-action="agregar-impresiones" data-impresora="{{ $detalles->first()->id_impresora }}" data-nombre="{{ $impresora }}" >
                                                <i class="fas fa-plus-circle"></i> Agregar registro
                                            </button>

                                            <form class="btn btn-xs btn-danger" data-impresora="{{ $impresora }}" data-action="eliminacion-registros-impresiones" action="{{ route('gestion-impresiones.impresiones.eliminar-registros-impresiones',$impresion) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                {!! Form::hidden('id_impresora', $detalles->first()->id_impresora) !!}
                                                <button type="submit" class="btn btn-xs text-white" title="Eliminar"><i class="fas fa-trash-alt"></i> Eliminar Registros</button>
                                            </form>

                                            <button class="btn btn-secondary btn-sm" data-action="exportar-excel" data-impresora="{{ $detalles->first()->id_impresora }}" data-nombre="{{ $impresora }}" >
                                                <i class="fas fa-file-excel"></i> Descargar Reporte
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <table class="table table-bordered" data-impresora="{{ $detalles->first()->id_impresora }}">
                                    <thead>
                                        <tr>
                                            <th class="text-center">DEPARTAMENTO</th>
                                            <th>NOMBRE</th>
                                            <th># Impresión</th>
                                            <th>Negro</th>
                                            <th class="text-danger">Color</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $personal_por_departamento = $detalles->groupBy(function($detalle){
                                            return $detalle->personal->departamento->nombre;
                                        })->sortKeys();
                                    @endphp

                                    @foreach ($personal_por_departamento as $departamento => $detalles_por_departamento)
                                        <tbody>
                                            <tr class="text-center">
                                                <td class="bg-purple align-middle" rowspan="{{ $detalles_por_departamento->count() + 1 }}">{{ $departamento }}</td>
                                            </tr>
                                            @foreach ($detalles_por_departamento as $detalle)
                                                <tr>
                                                    <td>{{ $detalle->personal->nombre }}</td>
                                                    <td>{{ $detalle->id_impresion }}</td>
                                                    <td>{{ $detalle->negro }}</td>
                                                    <td>{{ $detalle->color }}</td>
                                                    <td>{{ $detalle->total }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button data-impresora="{{ $impresora }}"
                                                                data-id="{{ $detalle->id }}"
                                                                data-url="{{ route('gestion-impresiones.impresiones.eliminar-registro-impresiones',$detalle) }}"
                                                                data-method="POST"
                                                                data-type="DELETE"
                                                                data-action="eliminar-impresion"
                                                                title="Eliminar"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>

                                                            <button data-impresora="{{ $impresora }}"
                                                                data-id="{{ $detalle->id }}"
                                                                data-url="{{ route('gestion-impresiones.impresiones.actualizar-registro-impresiones',$detalle) }}"
                                                                data-method="POST"
                                                                data-type="PATCH"
                                                                data-action="actualizar-impresion"
                                                                data-object="{{ $detalle }}"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="text-bold bg-gray-light">
                                                <td  colspan="3" class="text-center text-uppercase">Total</td>
                                                <td>{{ $detalles_por_departamento->sum('negro') }}</td>
                                                <td class="text-danger">{{ $detalles_por_departamento->sum('color') }}</td>
                                                <td>{{ $detalles_por_departamento->sum('total') }}</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card -->
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="modal-agregar-registro-impresiones" data-keyboard="false"  data-backdrop="static" aria-hidden="true" tabindex='-1'>
        <div class="modal-dialog modal-lg">
          <div class="modal-content ">
            <div class="modal-header">
              <h4 class="modal-title">Agregar Registro de Impresones</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            {!! Form::open(['id' => 'form-asignar-registro-impresiones','route' =>['gestion-impresiones.impresiones.agregar-registro-impresiones', $impresion], 'accept-charset' => 'UTF-8', 'enctype' =>'multipart/form-data']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('id_impresora', 'Impresora') !!}
                        {!! Form::select('id_impresora', $impresoras, null, ['class' => 'form-control','data-impresora' => '','required' => true]) !!}
                    </div>

                    <div class="form-group @error('info') has-error @enderror">
                        {!! Form::label('info', 'Ingresa la información de la impresora') !!}
                        {!! Form::textarea('info', null, ['class' => 'form-control','cols' => '30','rows' => '15','title' => 'Información Impresiones','data-impresora' => '','required' => true]) !!}
                        <div class="help-block with-errors">
                            @error('info')
                                <span>{{ $errors->first('info') }}</span>
                            @enderror
                        </div>
                    </div>

                    <div id="d-errors-asignar-equipo" class="form-group"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            {!! Form::close() !!}
          </div>
          <!-- /.modal-content -->
        </div>
    </div>

    <div class="modal fade" id="modal-importar-impresiones" data-keyboard="false"  data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Importar registros de Impresion</b></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                {!! Form::open(['id' => 'form-importar-impresiones', 'route' => ['gestion-impresiones.impresiones.importar',$impresion], 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                    <div class="modal-body">
                        <p>Adjunta el archivo de importación Masiva con el siguiente formato</p>

                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr class="text-center">
                                    <td>id_impresion</td>
                                    <td>impresora</td>
                                    <td>negro</td>
                                    <td>color</td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="errores-importar-impresiones"></div>

                        <input class="dropify"
                            type="file"
                            name="impresiones"
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

    <div class="modal fade" id="modal-agregar-impresiones" data-keyboard="false"  data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar regristro de impresiones</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                {!! Form::open(['id' => 'form-agregar-impresiones', 'route' => ['gestion-impresiones.impresiones.crear-registro-impresiones',$impresion], 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('id_impresion','#ID IMPRESION') !!}
                            {!! Form::text('id_impresion', null, ['class' => 'form-control']) !!}
                            {!! Form::hidden('id_impresora', null) !!}
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('negro','Negro:') !!}
                                    {!! Form::number('negro', null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Impresiones en negro']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('color','Color:') !!}
                                    {!! Form::number('color', null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Impresiones en color']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary dim float-right" type="submit">Guardar</button>
                    </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-actualizar-impresiones" data-keyboard="false"  data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">actualizar regristro de impresiones</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                {!! Form::open(['id' => 'form-actualizar-impresiones', 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('impresora','Impresora:') !!}
                                    {!! Form::text('impresora', null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Impresora','disabled' => true]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('persona','Personal:') !!}
                                    {!! Form::text('persona', null, ['class' => 'form-control','autocomplete' => 'off','disabled' => true]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('negro','Negro:') !!}
                                    {!! Form::number('negro', null, ['id'=> 'update-input-negro','class' => 'form-control','autocomplete' => 'off','placeholder' => 'Impresiones en negro']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('color','Color:') !!}
                                    {!! Form::number('color', null, ['id'=> 'update-input-color','class' => 'form-control','autocomplete' => 'off','placeholder' => 'Impresiones en color']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary dim float-right" type="submit">Guardar</button>
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
    <script src="{{ mix('js/vendor/table-html/table-html.js') }}"></script>

    <script type="text/javascript">
        $(function(){
            const dom = {
                impresiones: {
                    btn_agregar: $('#btn-agregar-reporte'),
                    modal_agregar: $('#modal-agregar-registro-impresiones'),
                    form_agregar: $('#form-asignar-registro-impresiones'),
                    tab_content_impresoras : $("#tab-content-impresoras")
                },
                importar_impresiones:{
                    button: $("#btn-importar-impresiones"),
                    form: $("#form-importar-impresiones"),
                    modal:$("#modal-importar-impresiones"),
                    errors:$("#errores-importar-impresiones")
                },
                agregar_impresiones: {
                    modal:$("#modal-agregar-impresiones"),
                    form: $("#form-agregar-impresiones"),
                },
                actualizar_impresiones: {
                    modal:$("#modal-actualizar-impresiones"),
                    form: $("#form-actualizar-impresiones"),
                }
            }

            const m_impresiones = (function(d){
                d.btn_agregar.click(function() {
                    d.modal_agregar.modal('show');
                })

                d.form_agregar.submit(function(e){
                    d.modal_agregar.modal('hide');

                    Swal.fire({
                        title: 'Procesando',
                        html: 'Espere un momento por favor.',
                        allowEscapeKey:false,
                        allowOutsideClick:false,
                        allowEnterKey:false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    })
                })

                d.tab_content_impresoras.on('submit','form[data-action="eliminacion-registros-impresiones"]',function(e){
                    e.preventDefault();

                    Swal.fire({
                        title: `¿Deseas eliminar todos los registros de la impresora ${$(this).data('impresora')}?`,
                        text: "Una vez eliminado, no podrá recuperarse",
                        type: 'warning',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Eliminar',
                    }).then((result) => {
                        if (result.value) {
                            Swal.fire({
                                title: 'Procesando',
                                html: 'Espere un momento por favor.',
                                allowEscapeKey:false,
                                allowOutsideClick:false,
                                allowEnterKey:false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })

                            e.target.submit();
                        }
                    })
                })

                d.tab_content_impresoras.on('click','button[data-action="exportar-excel"]',function(e){
                    const id_impresora = $(this).data('impresora');
                    const nombre_impresora = $(this).data('nombre') || '';

                    const date = new Date().toLocaleDateString().replaceAll('/','-');
                    const filename = `reporte_impresiones_${date}_${nombre_impresora}.xls`;


                    const table = $(`table[data-impresora=${id_impresora}]`);

                    table.table2excel({
                        filename: filename
                    });
                });

                d.tab_content_impresoras.on('click','button[data-action="eliminar-impresion"]',function(e){
                    const $button = $(this);

                    Swal.fire({
                        title: `¿Deseas eliminar el registro?`,
                        text: "Una vez eliminado, no podrá recuperarse",
                        type: 'warning',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Eliminar',
                    }).then((result) => {
                        if (result.value) {
                            Swal.fire({
                                title: 'Procesando',
                                html: 'Espere un momento por favor.',
                                allowEscapeKey:false,
                                allowOutsideClick:false,
                                allowEnterKey:false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })

                            const $form = $('<form>', {
                                'method': $button.data('method'),
                                'action': $button.data('url'),
                            });

                            const $token = $('<input>', {
                                'type': 'hidden',
                                'name': '_token',
                                'value': $('meta[name="csrf-token"]').attr('content'),
                            });

                            const $method = $('<input>', {
                                'type': 'hidden',
                                'name': '_method',
                                'value': 'DELETE'
                            });

                            $form.append($token)
                                .append($method)
                                .appendTo('body');

                            $form[0].submit();
                        }
                    })
                });

            })(dom.impresiones);

            const m_importar_impresiones = (function(d){
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

                var abrir_modal = function(e){
                    d.form[0].reset();
                    d.errors.html('')
                    d.modal.modal('show');
                    $(".dropify-clear").trigger("click");
                }

                var importar = function(e){

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


                };

                var dropify_after_clear = function(event, element){
                    d.errors.html('');
                };

                // EVENTOS
                d.form.submit(importar);
                d.button.click(abrir_modal);
                drEvent.on('dropify.afterClear', dropify_after_clear);
            })(dom.importar_impresiones);

            const m_agregar_impresiones = (function(d,di){

                di.tab_content_impresoras.on('click','button[data-action="agregar-impresiones"]',function(e){
                    const $button = $(this);
                    const id_impresora = $button.data('impresora');

                    d.form[0].reset();
                    d.form[0].id_impresora.value = id_impresora;

                    d.modal.modal('show');
                });

                d.form.submit(function(e){
                    d.modal.modal('hide');

                    Swal.fire({
                        title: 'Procesando',
                        html: 'Espere un momento por favor.',
                        allowEscapeKey:false,
                        allowOutsideClick:false,
                        allowEnterKey:false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    })
                });

            })(dom.agregar_impresiones,dom.impresiones)

            const m_actualizar_impresiones = (function(d,ai){
                d.tab_content_impresoras.on('click','button[data-action="actualizar-impresion"]',function(e){
                    const $button = $(this);
                    const impresora = $button.data('impresora');
                    const impresion = $button.data('object');

                    ai.form[0].reset();

                    ai.form[0].negro.value = impresion.negro;
                    ai.form[0].color.value = impresion.color;
                    ai.form[0].persona.value = impresion.personal.nombre || '';
                    ai.form[0].impresora.value = impresora;

                    ai.form.attr('action',$button.data('url'));
                    ai.modal.modal('show');
                });

                ai.form.submit(function(e){
                    ai.modal.modal('hide');

                    Swal.fire({
                        title: 'Procesando',
                        html: 'Espere un momento por favor.',
                        allowEscapeKey:false,
                        allowOutsideClick:false,
                        allowEnterKey:false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    })
                });

            })(dom.impresiones,dom.actualizar_impresiones)
        });
    </script>
@endsection

