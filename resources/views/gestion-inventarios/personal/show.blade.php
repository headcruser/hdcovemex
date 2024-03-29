@extends('layouts.panel')

@section('title','Pefil del personal')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
@endsection

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
    <div class="col-12 col-sm-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/theme/avatar.png') }}" alt="{{ $personal->nombre }}">
              </div>

              <h3 class="profile-username text-center">{{ $personal->nombre }}</h3>

              <p class="text-muted text-center">{{ $personal->departamento->nombre }}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Puesto</b> <a class="float-right">{{ $personal->puesto }}</a>
                </li>
                <li class="list-group-item">
                  <b>Sucursal</b> <a class="float-right">{{ $personal->sucursal->descripcion }}</a>
                </li>
                <li class="list-group-item">
                    <b>ID Impresión</b> <a class="float-right">{{ $personal->id_impresion }}</a>
                  </li>
              </ul>

              <a href="{{ route('gestion-inventarios.personal.edit',$personal) }}" class="btn btn-primary btn-block"><b>Editar</b></a>
              <button id="btn-generar-firma" class="btn btn-info btn-block">Generar Firma</button>
            </div>
            <!-- /.card-body -->
          </div>
    </div>

    <div class="col-12 col-sm-8" id="contenedor-info-personal">
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
                   <div class="row">
                       @foreach ($equipos_asignados as $equipo)
                            <div class="col-12 d-flex align-items-stretch flex-column">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-header text-muted border-bottom-0">
                                            {{ $equipo->equipo->descripcion }}
                                        </div>

                                        <div class="card-body pt-0">
                                            <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="lead"><b> {{ $equipo->equipo->tipo }}</b></h2>
                                                        <p class="text-muted text-sm"><b>Marca: </b> {{ $equipo->equipo->marca }} </p>
                                                        <p class="text-muted text-sm"><b>S.O: </b> {{ $equipo->equipo->sistema_operativo }} </p>
                                                        <p class="text-muted text-sm"><b>Procesador: </b> {{ $equipo->equipo->procesador }} </p>
                                                        <p class="text-muted text-sm"><b>memoria: </b> {{ $equipo->equipo->memoria }} </p>
                                                        @if($equipo->carta_responsiva)
                                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-link"></i></span> <a href="{{ asset(Storage::url($equipo->carta_responsiva)) }}" target="_blank" class="btn-link">Carta Responsiva</a></li>
                                                            </ul>
                                                        @endif
                                                    </div>
                                                    <div class="col-5 text-center">

                                                    </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <div class="text-right">
                                                <a href="{{ route('gestion-inventarios.equipos.show',$equipo->id_equipo) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-search"></i> Ver Equipo
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                       @endforeach
                   </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.col -->
  </div>

  @include('gestion-inventarios.personal.modals._cuenta_usuario')
  @include('gestion-inventarios.personal.modals._generar-firma')
@endsection

@push('scripts')
    <script src="{{ asset('vendor/clipboard/dist/clipboard.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.min.js') }}"></script>

    <script type="text/javascript">
        const m_personal = (function(){
            const dom =  {
                contenedor_info:$("#contenedor-info-personal"),
                listar_info:$("#lista-info"),
                modal_info: $("#modal-info"),
                form_info:$("#form-info"),
                btn_agregar_info:$("#btn-agregar-info"),

                toogle_password: document.querySelector("#btn-toogle-password"),
                clipboard:{
                    password: {
                        input:  document.querySelector("#contrasenia"),
                        clipboard: document.querySelector("#btn-contrasenia-clipboard"),
                    },
                    usuario: {
                        input:  document.querySelector("#usuario"),
                        clipboard: document.querySelector("#btn-usuario-clipboard")
                    },
                },
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

                dom.form_info.find('[name="descripcion"]').summernote('destroy');
                dom.form_info.find('[name="descripcion"]').summernote({
                    height: 250,
                    lang: 'es-ES',
                    codemirror: {
                        theme: 'monokai'
                    },
                    code: '',
                });

                dom.form_info.find('[name="descripcion"]').summernote('code', null);

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
                dom.form_info.find('[name="usuario"]').val(cuenta.usuario)
                dom.form_info.find('[name="contrasenia"]').val(cuenta.contrasenia)
                dom.form_info.find('[name="descripcion"]').val(cuenta.descripcion)

                dom.form_info.find('[name="descripcion"]').summernote('destroy');
                dom.form_info.find('[name="descripcion"]').summernote({
                    height: 250,
                    lang: 'es-ES',
                    codemirror: {
                        theme: 'monokai'
                    }
                });

                dom.modal_info.data('url',$(this).data('url'));
                dom.modal_info.modal('show');
            });

            dom.contenedor_info.on('click',"a.dropdown-item",function(e){
                e.preventDefault();
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

            dom.toogle_password.addEventListener('click',function(e){
                const isInputTypePassword = dom.clipboard.password.input.getAttribute('type') === 'password';
                const type = isInputTypePassword ? 'text' : 'password';

                dom.clipboard.password.input.setAttribute('type', type);
                this.innerHTML = isInputTypePassword ? `<i class="fa fa-eye-slash"></i>`:`<i class="fa fa-eye"></i>`;
            });

            // GENERAR FIRMA
            $("#btn-generar-firma").click(function(e){
                $("#form-generar-firma").trigger('reset');

                const info  = Array.from(dom.contenedor_info.find('[data-title]')).map(item => {
                    return {
                        title: $(item).data('title'),
                        info: $(item).closest('div[data-object]').data('object')
                    }
                });

                const correo = info.find(item => item.title  === 'correo') || {title: '', info:{}};

                const ext = info.find(item => {
                    const title = (item.title || '').toLowerCase();
                    return title.includes('ext.')
                } ) || {title: '', info:{}};


                $("#form-generar-firma").find('input[name="correo"]').val(correo.info.usuario || '');
                $("#form-generar-firma").find('input[name="extension"]').val(ext.info.usuario || '');

                generar_firma({
                    nombre: $("#form-generar-firma").find('input[name="nombre"]').val(),
                    puesto: $("#form-generar-firma").find('input[name="puesto"]').val() ,
                    correo: correo.info.usuario || '',
                    extension:ext.info.usuario || '',
                })



                $('#modal-generar-firma').modal('show');
            })

            $("#form-generar-firma").submit(function(e){
                e.preventDefault();

                const formData = new FormData(this);
                const data = Object.fromEntries(formData)

                delete data._token;

                generar_firma(data);
            });

            function generar_firma({ nombre = '',correo ='',puesto='',extension=''})
            {
                const params = $.param({nombre,correo,puesto,extension});
                const route = "{{ route('gestion-inventarios.personal.generar-firma') }}" +'?' + params;

                $("#contenido-firma").html(`<iframe scrolling='auto' type='text/html' scroll='auto' src='${route}' width='100%' height='156px' align='center'></iframe>`);
            }
        })();
    </script>
@endpush
