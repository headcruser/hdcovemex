<div class="row">
    <div class="col-md-6">
        <div class="form-group @error('nombre') has-error @enderror">
            {!! Form::label('input-nombre', 'Nombre: *') !!}
            {!! Form::text('nombre',null, ['id' => 'input-nombre','class' => 'form-control','required' => true,'autocomplete' => 'off']) !!}

            <div class="help-block with-errors">
                @error('nombre')
                <span>{{ $errors->first('nombre') }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group @error('id_impresion') has-error @enderror">
            {!! Form::label('id_impresion', 'ID Impresion:') !!}
            {!! Form::number('id_impresion',null, ['id' => 'input-id_impresion','min' => 0,'class' => 'form-control','autocomplete' => 'off']) !!}

            <div class="help-block with-errors">
                @error('id_impresion')
                <span>{{ $errors->first('id_impresion') }}</span>
                @enderror
            </div>
        </div>

    </div>
</div>

<div class="form-group @error('puesto') has-error @enderror">
    {!! Form::label('puesto', 'Puesto:') !!}
    {!! Form::text('puesto',null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui el puesto']) !!}

    <div class="help-block with-errors">
        @error('puesto')
            <span>{{ $errors->first('puesto') }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group @error('id_sucursal') has-error @enderror">
            {!! Form::label('input-id_sucursal', 'Sucursal: *') !!}
            {!! Form::select('id_sucursal', [], null, ['id' => 'input-id_sucursal','class' => 'form-control select2bs4','required' => true,'style' => 'width: 100%;']) !!}
            <div class="help-block with-errors">
                @error('id_sucursal')
                    <span>{{ $errors->first('id_sucursal') }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group @error('id_departamento') has-error @enderror">
            {!! Form::label('input-id_departamento', 'Departamento: *') !!}
            {!! Form::select('id_departamento', [], null, ['id' => 'input-id_departamento','class' => 'form-control select2bs4','required' => true,'style' => 'width: 100%;']) !!}

            <div class="help-block with-errors">
                @error('id_departamento')
                    <span>{{ $errors->first('id_departamento') }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>


