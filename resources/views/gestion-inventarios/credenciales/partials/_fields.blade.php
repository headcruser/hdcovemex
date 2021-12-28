<div class="form-group @error('nombre') has-error @enderror">
    {!! Form::label('nombre', 'Nombre: *') !!}
    {!! Form::text('nombre',null, ['class' => 'form-control','autocomplete' => 'off','placeholder' => 'Escribe aqui el nombre','title'=>'Nombre','required' => true]) !!}

    <div class="help-block with-errors">
        @error('nombre')
        <span class="text-danger">{{ $errors->first('nombre') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('usuario') has-error @enderror">
    {!! Form::label('usuario', 'Inicio de sesión:') !!}

    <div class="input-group mb-3">
        {!! Form::text('usuario',null, ['class' => 'form-control','placeholder' => 'Escribe aqui el inicio de sesion','title' => 'Inicio de sesión','autocomplete' => 'off']) !!}
        <span class="input-group-append">
            <button type="button" data-clipboard-target="#usuario" class="btn btn-default btn-flat clipboard">
              <i class="fa fa-clipboard"></i>
            </button>
        </span>
    </div>

    <div class="help-block with-errors">
        @error('usuario')
        <span class="text-danger">{{ $errors->first('usuario') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('contrasenia') has-error @enderror">

    <label for="contrasenia">Contraseña: <span id="btn-toogle-password"><i class="fa fa-eye"></i></span></label>
    <div class="input-group mb-3">
        {!! Form::input('password', 'contrasenia', old('credencial',$credencial->contrasenia) , ['id' => 'contrasenia','class' => 'form-control','autocomplete' => 'off','title' => 'Contraseña','placeholder' =>'Escribe aqui la contraseña','autocomplete' => 'new-password']); !!}
        <span class="input-group-append">
            <button type="button" data-clipboard-target="#contrasenia" class="btn btn-default btn-flat clipboard">
              <i class="fa fa-clipboard"></i>
            </button>
        </span>
    </div>

    <div class="help-block with-errors">
        @error('contrasenia')
            <span class="text-danger">{{ $errors->first('contrasenia') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('url') has-error @enderror">
    {!! Form::label('url', 'URL:') !!}
    {!! Form::text('url',null, ['class' => 'form-control','autocomplete' => 'off','title','placeholder' => 'Escribe la URL']) !!}

    <div class="help-block with-errors">
        @error('url')
            <span class="text-danger">{{ $errors->first('url') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('nota') has-error @enderror">
    {!! Form::label('nota', 'Nota:') !!}
    {!! Form::textarea('nota',null, ['class' => 'form-control','autocomplete' => 'off','title','placeholder' => 'Nota']) !!}

    <div class="help-block with-errors">
        @error('nota')
            <span class="text-danger">{{ $errors->first('nota') }}</span>
        @enderror
    </div>
</div>

<script src="{{ asset('vendor/clipboard/dist/clipboard.min.js') }}"></script>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', (event) => {
        const dom = {
            toogle_password: document.querySelector("#btn-toogle-password"),
            clipboard:{
                password: {
                    input:  document.querySelector("#contrasenia"),
                    clipboard: document.querySelector("#btn-contrasenia-clipboard"),
                },
                usuario: {
                    input:  document.querySelector("#usuario"),
                    clipboard: document.querySelector("#btn-usuario-clipboard")
                },
            },
        };

        dom.toogle_password.addEventListener('click',function(e){
            const isInputTypePassword = dom.clipboard.password.input.getAttribute('type') === 'password';
            const type = isInputTypePassword ? 'text' : 'password';

            dom.clipboard.password.input.setAttribute('type', type);
            this.innerHTML = isInputTypePassword ? `<i class="fa fa-eye-slash"></i>`:`<i class="fa fa-eye"></i>`;
        });

        var clipboard = new ClipboardJS('.clipboard');

        clipboard.on('success', function(e) {
            Toast.fire({
                type: 'success',
                title: 'Copiado correctamente'
            });

            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            Toast.fire({
                type: 'danger',
                title: 'Ocurrio un error al copiar el elemento'
            });
        });
    });
</script>



