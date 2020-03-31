
<div class="form-group @error('name') has-error @enderror">
    <label for="input-name">Nombre*</label>
    <input id="input-name"
        name="name"
        type="text"
        placeholder="Ejemplo: PAS"
        aria-describedby="name-help"
        class="form-control @error('name') is-invalid @enderror""
        value="{{ old('name', $model->name) }}"
        autocomplete="off" required>

    <div id="name-help" class="error invalid-feedback">
        @error('name') {{ $message }} @enderror
    </div>
</div>

<div class="form-group @error('display_name') has-error @enderror">
    <label for="input-display_name">Alias*</label>
    <input id="input-display_name"
        name="display_name"
        type="text"
        aria-describedby="display_name-help"
        placeholder="Ejemplo: Pasado"
        class="form-control @error('display_name') is-invalid @enderror""
        value="{{ old('display_name', $model->display_name) }}"
        autocomplete="off" required>

    <div id="display_name-help" class="error invalid-feedback">
        @error('display_name') {{ $message }} @enderror
    </div>
</div>

<div class="form-group @error('color') has-error @enderror">
    <label for="input-color">Color*</label>
    <input id="input-color"
        name="color"
        type="text"
        aria-describedby="color-help"
        class="form-control colorpicker @error('color') is-invalid @enderror"
        value="{{ old('color', $model->color) }}"
        autocomplete="off" required>

    <div id="color-help" class="error invalid-feedback">
        @error('color') {{ $message }} @enderror
    </div>
</div>





