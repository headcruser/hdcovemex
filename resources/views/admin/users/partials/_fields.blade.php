<div class="form-group @error('nombre') has-error @enderror">
    <label for="input-nombre">Nombre*</label>
    <input type="text" id="input-nombre" name="nombre" class="form-control" value="{{ old('nombre', $model->nombre) }}"
        autocomplete="off" required>
    <div class="help-block with-errors">
        @error('nombre')
        <span>{{ $errors->first('nombre') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('usuario') has-error @enderror">
    <label for="input-usuario">Usuario*</label>
    <input type="text" id="input-usuario" name="usuario" class="form-control" value="{{ old('usuario', $model->usuario) }}"
        autocomplete="off" required>
    <div class="help-block with-errors">
        @error('usuario')
        <span>{{ $errors->first('usuario') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('email') has-error @enderror">
    <label for="input-email">Correo electronico*</label>
    <input type="email" id="input-email" name="email" class="form-control" value="{{ old('email', $model->email) }}"
        autocomplete="off" required>
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

<div class="form-group">
     <div class="form-group" id="div_enviar_datos" @if ($model->exists) style="display:none" @endif>
        <label>
            <input type="checkbox" class="i-checks" name="enviar_datos"> Enviar datos por correo
        </label>
    </div>
</div>


<div class="form-group @error('roles') has-error @enderror">
    <label for="roles">Roles*
    <span class="btn btn-info btn-xs select-all">Seleccionar todo</span>
    <span class="btn btn-info btn-xs deselect-all">Desmarcar todo</span></label>
    <select name="roles[]" id="input-roles" class="form-control select2" multiple="multiple">
        @foreach($roles as $id => $roles)
            <option value="{{ $id }}"
                {{ (in_array($id, old('roles', [])) || $model->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}
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
            <option value="{{ $id }}" {{ ( $model->departamento ? $model->departamento->id : old('departamento_id')) == $id ? 'selected' : '' }}>{{ $departamento }}</option>
        @endforeach
    </select>
    <div class="help-block with-errors">
        @error('departamento_id')
            <span>{{ $errors->first('departamento_id') }}</span>
        @enderror
    </div>
</div>
