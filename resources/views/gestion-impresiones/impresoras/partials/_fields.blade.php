<div class="form-group @error('nombre') has-error @enderror">
    {!! Form::label('nombre', 'Nombre:*') !!}
    {!! Form::text('nombre',null, ['class' => 'form-control','placeholder' => 'Nombre de la impresora','required' => true]) !!}

    <div class="help-block with-errors">
        @error('nombre')
            <span>{{ $errors->first('nombre') }}</span>
        @enderror
    </div>
</div>

<div class="form-group  @error('descripcion') has-error @enderror">
    {!! Form::label('descripcion', 'Descripcion:*') !!}
    {!! Form::text('descripcion',null, ['class' => 'form-control','placeholder' => 'Descripción de la impresora','required' => true]) !!}

    @error('descripcion')
        <span>{{ $errors->first('descripcion') }}</span>
    @enderror
</div>

<div class="form-group @error('nip') has-error @enderror">
    {!! Form::label('nip', 'NIP:*') !!}
    {!! Form::text('nip',null, ['class' => 'form-control','placeholder' => 'Escribe un nip que identifique a la impresora','required' => true]) !!}

    @error('nip')
        <span>{{ $errors->first('nip') }}</span>
    @enderror
</div>

<div class="form-group @error('ip') has-error @enderror">
    {!! Form::label('ip', 'ip:*') !!}
    {!! Form::text('ip',null, ['class' => 'form-control','placeholder' => 'Escribe la dirección de la impresora','required' => true]) !!}

    @error('ip')
        <span>{{ $errors->first('ip') }}</span>
    @enderror
</div>
