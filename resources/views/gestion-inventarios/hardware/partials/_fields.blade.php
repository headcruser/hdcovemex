<div class="row">
    <div class="col-md-6">
        <div class="form-group @error('descripcion') has-error @enderror">
            {!! Form::label('input-descripcion', 'Descripcion: *') !!}
            {!! Form::text('descripcion',null, ['id' => 'input-descripcion','class' => 'form-control','required' => true,'autocomplete' => 'off']) !!}

            <div class="help-block with-errors">
                @error('descripcion')
                <span>{{ $errors->first('descripcion') }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group @error('no_serie') has-error @enderror">
            {!! Form::label('input-no_serie', 'N° de serie: *') !!}
            {!! Form::text('no_serie',null, ['id' => 'input-no_serie','class' => 'form-control','required' => true,'autocomplete' => 'off']) !!}

            <div class="help-block with-errors">
                @error('no_serie')
                <span>{{ $errors->first('no_serie') }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group @error('proveedor') has-error @enderror">
            {!! Form::label('input-proveedor', 'Proveedor: *') !!}
            {!! Form::text('proveedor',null, ['id' => 'input-proveedor','class' => 'form-control','required' => true,'autocomplete' => 'off']) !!}

            <div class="help-block with-errors">
                @error('Proveedor')
                <span>{{ $errors->first('proveedor') }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group @error('marca') has-error @enderror">
            {!! Form::label('input-marca', 'Marca: *') !!}
            {!! Form::text('marca',null, ['id' => 'input-marca','class' => 'form-control','required' => true, 'autocomplete' => 'off']) !!}

            <div class="help-block with-errors">
                @error('marca')
                <span>{{ $errors->first('marca') }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group @error('id_tipo_hardware') has-error @enderror">
            {!! Form::label('input-id_tipo_hardware', 'Tipo de hardware: *') !!}
            {!! Form::select('id_tipo_hardware', [], null, ['id' => 'input-id_tipo_hardware','class' => 'form-control','required' => true,'style' => 'width: 100%;']) !!}

            <div class="help-block with-errors">
                @error('id_tipo_hardware')
                    <span>{{ $errors->first('id_tipo_hardware') }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group @error('fecha_compra') has-error @enderror">
            {!! Form::label('input-fecha_compra', 'Fecha de compra: *') !!}
            {!! Form::date('fecha_compra', null, ['id' => 'input-fecha_compra','class' => 'form-control','required' => true,'style' => 'width: 100%;']) !!}

            <div class="help-block with-errors">
                @error('fecha_compra')
                    <span>{{ $errors->first('fecha_compra') }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
