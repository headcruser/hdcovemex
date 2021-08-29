
<div class="form-group @error('attribute') has-error @enderror">
    <label for="select-attribute">Atributo* </label>
    <select name="attribute" id="select-attribute" class="form-control select2" title="Selecciona una categoria" required>
        @foreach($categorias as $key => $categoria)
            <option value="{{ $categoria }}" {{ (in_array($categoria, old('attribute', [])) ) ? 'selected' : '' }}>{{ $categoria }}</option>
        @endforeach
    </select>

    <div class="help-block with-errors">
        @error('attribute')
            <span>{{ $errors->first('attribute') }}</span>
        @enderror
    </div>
</div>



<div class="form-group @error('value') has-error @enderror">
    <label for="input-value">Valor*</label>
    <input type="text" id="input-value" name="value" class="form-control" value="{{ old('value', $model->value) }}"
        autocomplete="off" required>
    <div class="help-block with-errors">
        @error('value')
            <span>{{ $errors->first('value') }}</span>
        @enderror
    </div>
</div>

