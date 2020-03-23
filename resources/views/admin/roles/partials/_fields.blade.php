<div class="form-group @error('nombre') has-error @enderror">
    <label for="input-nombre">Nombre*</label>
    <input type="text" id="input-nombre" name="nombre" class="form-control" value="{{ old('nombre', $rol->nombre) }}"
        autocomplete="off" required>
    <div class="help-block with-errors">
        @error('nombre')
        <span>{{ $errors->first('nombre') }}</span>
        @enderror
    </div>
</div>
