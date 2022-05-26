<div class="form-group @error('pregunta') has-error @enderror">
        {!! Form::label('pregunta', 'Pregunta:*') !!}
        {!! Form::text('pregunta', null, ['class' => 'form-control' ,'placeholder' => 'Escribe aqui la pregunta ', 'title' => 'Pregunta','autocomplete' => 'off','required' => true]) !!}

    <div id="name-help" class="error invalid-feedback">
        @error('pregunta') {{ $message }} @enderror
    </div>
</div>

<div class="form-group @error('id_categoria_faq') has-error @enderror">
        {!! Form::label('id_categoria_faq', 'Pregunta:*') !!}
        {!! Form::select('id_categoria_faq',$categorias, null, ['class' => 'form-control' ,'placeholder' => 'Selecciona una categoria ', 'title' => 'Pregunta','required' => true]) !!}

    <div id="name-help" class="error invalid-feedback">
        @error('id_categoria_faq') {{ $message }} @enderror
    </div>
</div>

<div class="form-group @error('visible') has-error @enderror">
    <div class="form-check pl-0">
        {!! Form::checkbox('visible', $model->visible, ['class' => 'form-check-input' ,'placeholder' => 'Selecciona una categoria ', 'title' => 'Pregunta','required' => true]) !!}
        {!! Form::label('visible', 'Visible',['class' => 'form-check-label']) !!}
    </div>

    <div id="name-help" class="error invalid-feedback">
        @error('visible') {{ $message }} @enderror
    </div>
</div>

<div class="form-group @error('respuesta') has-error @enderror">
    {!! Form::label('respuesta', 'Respuesta:') !!}
    {!! Form::textarea('respuesta',null, ['class' => 'form-control','autocomplete' => 'off','title','placeholder' => 'Respuesta']) !!}

    <div class="help-block with-errors">
        @error('nota')
            <span class="text-danger">{{ $errors->first('nota') }}</span>
        @enderror
    </div>
</div>
