<div class="modal fade" id="modal-generar-firma" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title">Generar Firma <small>(*) Campos Requeridos</small></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        {!! Form::open(['id' => 'form-generar-firma', 'accept-charset' => 'UTF-8', 'enctype' =>'multipart/form-data']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre:*') !!}
                        {!! Form::text('nombre', $personal->nombre, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui el nombre','required' => true]) !!}
                        <small data-help class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group ">
                        {!! Form::label('puesto', 'Puesto:*') !!}
                        {!! Form::text('puesto', $personal->puesto, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui el puesto','required' => true]) !!}
                        <small data-help class="form-text text-muted"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('correo', 'Correo:*') !!}
                        {!! Form::email('correo',null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui el correo']) !!}
                        <small data-help class="form-text text-muted">Nota: En info del usuario titulo debe llevar <mark>Correo</mark> </small>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                     <div class="form-group">
                        {!! Form::label('extension', 'Ext.:*') !!}
                        {!! Form::text('extension',null, ['class' => 'form-control','placeholder' => 'Escribe aqui la ext. ']) !!}
                        <small data-help class="form-text text-muted">Nota: En info del usuario debe contener <mark>Ext.</mark></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="contenido-firma"></div>
                </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Generar</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
