<div class="row">
    <div class="col-md-6">
        <div class="form-group @error('descripcion') has-error @enderror">
            {!! Form::label('descripcion', 'Descripción*') !!}
            {!! Form::text('descripcion',null, ['id' => 'input-descripcion','placeholder' => 'Escribe la descripcion del equipo','class' => 'form-control','autocomplete' => 'off','required' => true]) !!}

            <div class="help-block with-errors">
                @error('descripcion')
                    <span>{{ $errors->first('descripcion') }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group @error('fecha_equipo') has-error @enderror">
            {!! Form::label('fecha_equipo', 'Fecha*') !!}
            {!! Form::date('fecha_equipo', null, ['id' => 'input-fecha_equipo','class' => 'form-control','required' => true]) !!}

            <div class="help-block with-errors">
                @error('fecha_equipo')
                    <span>{{ $errors->first('fecha_equipo') }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
