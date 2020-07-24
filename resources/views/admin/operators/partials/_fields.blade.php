<div class="form-group @error('nombre') has-error @enderror">
    <label for="input-nombre">Nombre*</label>

    <input type="text"
        id="input-nombre"
        name="nombre"
        class="form-control"
        value="{{ old('nombre', optional($model->usuario)->nombre) }}"
        autocomplete="off"
        required>

    <div class="help-block with-errors">
        @error('nombre')
        <span>{{ $errors->first('nombre') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('email') has-error @enderror">
    <label for="input-email">Correo electronico*</label>

    <input type="email"
        id="input-email"
        name="email"
        class="form-control"
        value="{{ old('email', optional($model->usuario)->email) }}"
        autocomplete="off"
        required>

    <div class="help-block with-errors">
        @error('email')
        <span>{{ $errors->first('email') }}</span>
        @enderror
    </div>
</div>


<div class="form-group @error('password') has-error @enderror">
    <label for="input-password">Contraseña*</label>
    <input type="password" id="input-password" name="password" class="form-control"
        value="{{ old('password', '') }}" autocomplete="off"  @if($view_name == 'create')required @endif >
    <div class="help-block with-errors">
        @error('password')
        <span>{{ $errors->first('password') }}</span>
        @enderror
    </div>
</div>


<div class="form-group @error('roles') has-error @enderror">
    <label for="roles">Roles*
    <span class="btn btn-info btn-xs select-all">Seleccionar todo</span>
    <span class="btn btn-info btn-xs deselect-all">Desmarcar todo</span></label>
    <select name="roles[]" id="input-roles" class="form-control select2" multiple="multiple">
        @foreach($roles as $id => $roles)
            <option value="{{ $id }}"
                {{ (in_array($id, old('roles', [])) || optional( optional($model->usuario)->roles)->contains($id)) ? 'selected' : '' }}>{{ $roles }}
            </option>
        @endforeach
    </select>
    <div class="help-block with-errors">
        @error('roles')
            <span>{{ $errors->first('roles') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('departamento_id') has-error @enderror">
    <label for="input-departamento_id">Departamento*</label>
    <select name="departamento_id" id="input-departamento_id" class="form-control select2" required>
        @foreach($departamentos as $id => $departamento)
            <option value="{{ $id }}" {{ ( optional($model->usuario)->departamento ? $model->usuario->departamento->id : old('departamento_id')) == $id ? 'selected' : '' }}>{{ $departamento }}</option>
        @endforeach
    </select>
    <div class="help-block with-errors">
        @error('departamento_id')
            <span>{{ $errors->first('departamento_id') }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4">
        <div class="custom-control custom-checkbox">
          <input name="notificar_solicitud"
            class="custom-control-input"
            type="checkbox"
            id="notificar_solicitud"
            @if($model->notificar_solicitud) checked @endif>

          <label for="notificar_solicitud" class="custom-control-label">Notificar Solicitud</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="custom-control custom-checkbox">
          <input class="custom-control-input"
            type="checkbox"
            id="notificar_asignacion"
            name="notificar_asignacion"
            @if($model->notificar_asignacion) checked @endif>

          <label for="notificar_asignacion" class="custom-control-label">Notificar Asignacion Ticket</label>
        </div>
    </div>
  </div>
