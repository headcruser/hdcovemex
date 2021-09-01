@extends('layouts.panel')

@section('title','Ver usuario')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item">Administración</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">usuario #{{ $model->id }}</li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del usuario</h3>
                      <div class="card-tools">
                          <a href="{{ route('admin.usuarios.edit',$model) }}" class="btn btn-primary btn-xs" title="Editar">
                              Editar <i class="fas fa-pencil-alt"></i>
                          </a>
                      </div>
                  </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <td>
                                    {{ $model->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    NOMBRE
                                </th>
                                <td>
                                    {{ $model->nombre }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    USUARIO
                                </th>
                                <td>
                                    {{ $model->usuario }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    EMAIL
                                </th>
                                <td>
                                    {{ $model->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    DEPARTAMENTO
                                </th>
                                <td>
                                    {{ $model->departamento->nombre }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    ROLES
                                </th>
                                <td>
                                    @forelse($model->roles as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @empty
                                        <span class="badge badge-warning"> Sin Roles</span>
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Enviar Credenciales
                                </th>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="btn-enviar-datos-acceso">Envio de credenciales</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.usuarios.index') }}">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="onboarding-modal modal fade animated" id="modal-enviar-datos-acceso" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title">Importar Personal</b></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                {!! Form::open(['id' => 'form-enviar-datos-acceso', 'route' => ['admin.usuarios.enviar-datos-acceso',$model], 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('password', 'Contraseña') !!}
                        {!! Form::text('password',null, ['id' => 'input-password','class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui la nueva contraseña']) !!}
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary btn-xs" id="btn-generar-contrasenia">Generar nueva contraseña</button>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            {!! Form::checkbox('enviar_datos_acceso',1,null, ['class' => 'form-check-input']) !!}
                            {!! Form::label('enviar_datos_acceso', 'Enviar datos de acceso', ['class' => 'form-check-label']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-upload"></i> Enviar</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function(){
            const dom = {
                enviar_datos_acceso: {
                    btn_enviar: $("#btn-enviar-datos-acceso"),
                    modal_enviar: $("#modal-enviar-datos-acceso"),
                    form_enviar_datos_acceso: $("#form-enviar-datos-acceso"),
                },
                generar_contrasenia: {
                    btn_generar: $("#btn-generar-contrasenia"),
                    input_password: $("#input-password"),

                    ajax:{
                        generar_contrasenia: "{{ route('admin.usuarios.generar-passowrd') }}",
                    }
                }
            }

            const m_enviar_datos_acceso = (function(d){
                d.btn_enviar.click(function(){
                    d.form_enviar_datos_acceso[0].reset();
                    d.modal_enviar.modal('show');
                });

                d.form_enviar_datos_acceso.submit(function(e){
                    d.modal_enviar.modal('hide');

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

            })(dom.enviar_datos_acceso);

            const m_generar_contrasenia = (function(d){

                d.btn_generar.click(function(e){
                    $.ajax({
                        url: d.ajax.generar_contrasenia,
                        type: 'POST',
                        data: {},
                        success: function (response){
                           d.input_password.val(response.password);
                        },
                        error:function(error){
                            Toast.fire({
                                type: 'error',
                                title: 'Ups, hubo un error en el servidor'
                            });
                        }
                    });
                });
            })(dom.generar_contrasenia)

        })
    </script>
@endsection

