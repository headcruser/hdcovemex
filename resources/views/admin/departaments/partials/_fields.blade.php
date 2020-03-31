<div class="form-group">
    <label for="input-nombre">Nombre*</label>
    <input id="input-nombre"
        name="nombre"
        type="text"
        class="form-control @error('nombre') is-invalid @enderror"
        placeholder="Ejemplo: Embolsadora"
        aria-describedby="nombre-help"
        value="{{ old('nombre', $model->nombre) }}"
        autocomplete="off" required>

    <div id="nombre-help" class="error invalid-feedback">
        @error('nombre') {{ $message }} @enderror
    </div>
</div>
