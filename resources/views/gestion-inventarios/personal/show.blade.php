@extends('layouts.panel')

@section('title','Pefil del personal')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> <a href="#">
       Gestión de inventarios </a>
    </li>
    <li class="breadcrumb-item"> <a href="{{ route('gestion-inventarios.personal.index') }}">
        Personal </a>
     </li>
    <li class="breadcrumb-item active">Personal</li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/theme/avatar.png') }}" alt="{{ $personal->nombre }}">
              </div>

              <h3 class="profile-username text-center">{{ $personal->nombre }}</h3>

              <p class="text-muted text-center">{{ $personal->departamento->nombre }}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Sucursal</b> <a class="float-right">{{ $personal->sucursal->descripcion }}</a>
                </li>
                <li class="list-group-item">
                    <b>ID Impresion</b> <a class="float-right">{{ $personal->id_impresion }}</a>
                  </li>
              </ul>

              <a href="{{ route('gestion-inventarios.personal.edit',$personal) }}" class="btn btn-primary btn-block"><b>Editar</b></a>
            </div>
            <!-- /.card-body -->
          </div>
    </div>

    <div class="col-8" id="contenedor-info-personal">
        {{-- <div class="card card-solid">
            <div class="card-header">
                <h3 class="card-title">Información del Personal</h3>
                <div class="card-tools">

                </div>
            </div>
            <div class="card-body pb-0" id="lista-info">

            </div>
        </div> --}}


        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="informacion-tab" data-toggle="pill" href="#tab-pane-informacion" role="tab" aria-controls="tab-pane-informacion" aria-selected="false">Informacion</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="equipo-tab" data-toggle="pill" href="#tab-pane-equipos" role="tab" aria-controls="tab-pane-equipos" aria-selected="false">Equipo</a>
                </li>
              </ul>
            </div>

            <div class="card-body">
              <div class="tab-content" id="tab-content-personal">
                <div class="tab-pane fade active show" id="tab-pane-informacion" role="tabpanel" aria-labelledby="informacion-tab">
                    <h4>Información del usuario</h4>
                    <button id="btn-agregar-info" data-url="{{ route('gestion-inventarios.personal.agregar_cuenta') }}" class="btn btn-success btn-sm" title="Crear">
                        Crear <i class="fas fa-plus-circle"></i>
                    </button>
                    <div id="lista-info" class="pt-2">
                        @include('gestion-inventarios.personal.partials._cuentas')
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pane-equipos" role="tabpanel" aria-labelledby="equipo-tab">
                    <h4>Asignacion de equipo</h4>
                   <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Serial Equipo</th>
                                <th>Fecha entrega</th>
                                <th>Carta Responsiva</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personal->equipos_asignados as $equipo)
                                <tr>
                                    <td>{{ $equipo->equipo->uid }}</td>
                                    <td>{{ $equipo->fecha_entrega->format('d-m-Y') }}</td>
                                    <td>{{ $equipo->carta_responsiva }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                   </table>
                </div>
              </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.col -->
  </div>

  <div class="modal fade" id="modal-info" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title">Información</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        {!! Form::open(['id' => 'form-info', 'accept-charset' => 'UTF-8', 'enctype' =>'multipart/form-data']) !!}
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('titulo', 'Titulo:*') !!}
                {!! Form::text('titulo', null, ['class' => 'form-control','autocomplete' => 'off','required' => true]) !!}
                <small data-help class="form-text text-muted"></small>
            </div>
            <div class="form-group">
                {!! Form::label('descripcion', 'Descripcion:*') !!}
                {!! Form::textarea('descripcion',null, ['id' => 'textarea-descripcion' ,'class' => 'form-control','rows' => 3,'required' => true]) !!}
                <small data-help class="form-text text-muted"></small>
            </div>
            {!! Form::hidden('id_personal', $personal->id) !!}
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


@section('scripts')
    <script type="text/javascript">
        const m_personal = (function(){
            const dom =  {
                contenedor_info:$("#contenedor-info-personal"),
                listar_info:$("#lista-info"),
                modal_info: $("#modal-info"),
                form_info:$("#form-info"),
                btn_agregar_info:$("#btn-agregar-info")
            }

            const listarCuentas = function(){
                return $.ajax({
                    method: 'POST',
                    url: "{{ route('gestion-inventarios.personal.listar_cuentas') }}",
                    data: {
                        id_personal: "{{ $personal->id }}"
                    },
                    dataType: 'json'
                });
            }



            dom.btn_agregar_info.click(function(e){
                dom.form_info.find(`[data-help]`).html('')
                dom.form_info.trigger('reset');

                dom.modal_info.data('url',$(this).data('url'));
                dom.modal_info.modal('show');
            });

            dom.contenedor_info.on('click','button[data-option="eliminar"]',function(e) {
                const $button = $(this);

                Swal.fire({
                    title: '¿Deseas eliminar este registro?',
                    text: "El registro se eliminara de forma permanente",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if(result.value) {

                        $.ajax({
                            method: 'POST',
                            url: $button.data('url'),
                            dataType: 'json'
                        })
                        .done(function(response) {
                            listarCuentas()
                                .done(function(res) {
                                    dom.listar_info.html(res.template || '');

                                    Toast.fire({
                                        type: 'success',
                                        title: response.message,
                                    })
                                }).fail(function(error) {
                                    Toast.fire({
                                        type: 'error',
                                        title: 'Ups, ocurrio un error',
                                    })
                                });

                        }).fail(function(error) {
                            Toast.fire({
                                type: 'error',
                                title: 'Ups, ocurrio un error',
                            })
                        });

                    }
                })
            });

            dom.contenedor_info.on('click','button[data-option="editar"]',function(e){
                dom.form_info.find(`[data-help]`).html('')
                dom.form_info.trigger('reset');

                const cuenta = $(this).closest('div[data-object]').data('object');
                dom.form_info.find('[name="titulo"]').val(cuenta.titulo)
                dom.form_info.find('[name="descripcion"]').val(cuenta.descripcion)

                dom.modal_info.data('url',$(this).data('url'));
                dom.modal_info.modal('show');
            });

            dom.form_info.submit(function(e){
                e.preventDefault();
                dom.modal_info.modal('hide');

                var formData = new FormData(this);

                $.ajax({
                    method: 'POST',
                    url: dom.modal_info.data('url'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                })
                .done(function(response) {

                    listarCuentas()
                        .done(function(res) {
                            dom.listar_info.html(res.template || '');

                            Toast.fire({
                                type: 'success',
                                title: response.message,
                            })
                        }).fail(function(error) {
                            Toast.fire({
                                type: 'error',
                                title: 'Ups, ocurrio un error',
                            })
                        });
                }).fail(function(error) {
                    const errors = error.responseJSON.errors || {}

                    for (const key in errors) {
                        if (Object.hasOwnProperty.call(errors, key)) {
                            dom.form_info.find(`[name=${key}]`).next().html(errors[key])
                        }
                    }

                    dom.modal_info.modal('show');
                })
            });

        })();
    </script>
@endsection

