<div class="form-group @error('desacripcion') has-error @enderror">
    {!! Form::label('input-descripcion', 'Nombre: *') !!}
    {!! Form::text('descripcion',null, ['id' => 'input-descripcion','class' => 'form-control','required' => true]) !!}

    <div class="help-block with-errors">
        @error('descripcion')
        <span>{{ $errors->first('descripcion') }}</span>
        @enderror
    </div>
</div>


