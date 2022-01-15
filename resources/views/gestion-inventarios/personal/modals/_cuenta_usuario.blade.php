<div class="modal fade" id="modal-info" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title">Información <small>(*) Campos Requeridos</small></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        {!! Form::open(['id' => 'form-info', 'accept-charset' => 'UTF-8', 'enctype' =>'multipart/form-data']) !!}
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('titulo', 'Titulo:*') !!}
                {!! Form::text('titulo', null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui el titulo','required' => true]) !!}
                <small data-help class="form-text text-muted"></small>
            </div>

            <div class="form-group ">
                {!! Form::label('usuario', 'Usuario:') !!}

                <div class="input-group mb-3">
                    {!! Form::text('usuario',null, ['class' => 'form-control','placeholder' => 'Escribe aqui el inicio de sesion','title' => 'Inicio de sesión','autocomplete' => 'off']) !!}
                    <span class="input-group-append">
                        <button type="button" data-clipboard-target="#usuario" class="btn btn-default btn-flat clipboard" title="Copiar">
                          <i class="fa fa-clipboard"></i>
                        </button>
                    </span>
                </div>

                <small data-help class="form-text text-muted"></small>
            </div>

            <div class="form-group">
                <label for="contrasenia">Contraseña: <span id="btn-toogle-password" title="Ver/Ocultar"><i class="fa fa-eye"></i></span></label>
                <div class="input-group mb-3">
                    {!! Form::input('password', 'contrasenia', null , ['id' => 'contrasenia','class' => 'form-control','autocomplete' => 'off','title' => 'Contraseña','placeholder' =>'Escribe aqui la contraseña','autocomplete' => 'new-password']); !!}
                    <span class="input-group-append">
                        <button type="button" data-clipboard-target="#contrasenia" title="Copiar" class="btn btn-default btn-flat clipboard">
                          <i class="fa fa-clipboard"></i>
                        </button>
                    </span>
                </div>
                <small data-help class="form-text text-muted"></small>
            </div>

            <div class="form-group">
                {!! Form::label('descripcion', 'Descripcion:') !!}
                {!! Form::textarea('descripcion',null, ['id' => 'textarea-descripcion' ,'class' => 'form-control','rows' => 3,'placeholder' => 'Escribe una breve descripcion']) !!}
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
