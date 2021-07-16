<div class="form-group @error('name') has-error @enderror">
    <label for="input-name">Nombre*</label>
    <input type="text" id="input-name" name="name" class="form-control" value="{{ old('name', $model->name) }}"
        autocomplete="off" required>
    <div class="help-block with-errors">
        @error('name')
        <span>{{ $errors->first('name') }}</span>
        @enderror
    </div>
</div>


<div class="form-group @error('display_name') has-error @enderror">
    <label for="input-display_name">Alias*</label>
    <input type="text" id="input-display_name" name="display_name" class="form-control" value="{{ old('display_name', $model->display_name) }}"
        autocomplete="off" required>
    <div class="help-block with-errors">
        @error('display_name')
        <span>{{ $errors->first('display_name') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('permisos') has-error @enderror">
    <label for="select-permisos">Permisos*
        <span class="btn btn-info btn-xs select-all">Seleccionar Todos</span>
        <span class="btn btn-info btn-xs deselect-all">Quitar Todos</span>
    </label>
    <select name="permisos[]" id="select-permisos" class="form-control select2" multiple="multiple" title="Selecciona un permisos" required>
        @foreach($permisos as $id => $permiso)
            <option value="{{ $id }}" {{ (in_array($id, old('permisos', [])) || $model->perms->contains($id)) ? 'selected' : '' }}>{{ $permiso }}</option>
        @endforeach
    </select>

    <div class="help-block with-errors">
        @error('permisos[]')
        <span>{{ $errors->first('display_name') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('description') has-error @enderror">
    <label for="input-description">Descripción</label>
    <textarea class="form-control" id="input-description" name="description" cols="30" rows="5" autocomplete="off">{{ old('description', $model->description) }}</textarea>

    <div class="help-block with-errors">
        @error('description')
        <span>{{ $errors->first('description') }}</span>
        @enderror
    </div>
</div>

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', (event) => {
        const $span_all = document.querySelector('.select-all');
        const $span_delete = document.querySelector('.deselect-all');
        const $select = document.getElementById('select-permisos');

        const selection = function($select,checked){
            const list = Array.from($select.options);

            list.forEach(option => {
                option.selected = (checked)? 'selected': '';
            });
        }

        $span_all.addEventListener('click',function(e){
            selection($select,true);
        });
        $span_delete.addEventListener('click',function(e){
            selection($select,false);
        });
    });
</script>
