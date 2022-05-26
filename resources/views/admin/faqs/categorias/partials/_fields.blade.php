<div class="form-group @error('nombre') has-error @enderror">
    <label for="input-name">Nombre*</label>
    <input id="input-name"
        name="nombre"
        type="text"
        placeholder="Escribe aqui el nombre"
        aria-describedby="name-help"
        class="form-control @error('nombre') is-invalid @enderror""
        value="{{ old('nombre', $categoria->nombre) }}"
        autocomplete="off" required>

    <div id="name-help" class="error invalid-feedback">
        @error('nombre') {{ $message }} @enderror
    </div>
</div>
