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
        {!! Form::text('usuario',null, ['class' => 'form-control','placeholder' => 'Escribe aqui el inicio de sesion','title' => 'Inicio de sesión','autocomplete' => 'off','required' => true]) !!}
        <span class="input-group-append">
            <button id="btn-usuario-clipboard" type="button" class="btn btn-default btn-flat">
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
        {!! Form::input('password', 'contrasenia', old('credencial',$credencial->contrasenia) , ['id' => 'contrasenia','class' => 'form-control','autocomplete' => 'off','title' => 'Contraseña','placeholder' =>'Escribe aqui la contraseña','autocomplete' => 'new-password','required' => true]); !!}
        <span class="input-group-append">
            <button id="btn-contrasenia-clipboard" type="button" class="btn btn-default btn-flat">
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
    {!! Form::url('url',null, ['class' => 'form-control','autocomplete' => 'off','title','placeholder' => 'Escribe la URL','required' => true]) !!}

    <div class="help-block with-errors">
        @error('url')
            <span class="text-danger">{{ $errors->first('url') }}</span>
        @enderror
    </div>
</div>

<div class="form-group @error('nota') has-error @enderror">
    {!! Form::label('nota', 'Nota:') !!}
    {!! Form::textarea('nota',null, ['class' => 'form-control','autocomplete' => 'off','title','placeholder' => 'Nota','required' => true]) !!}

    <div class="help-block with-errors">
        @error('nota')
            <span class="text-danger">{{ $errors->first('nota') }}</span>
        @enderror
    </div>
</div>

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

        function clipboart({input = null, clipboard = null} = {}){
            clipboard.addEventListener('click',function(e){
                input.focus();
                input.select();
                input.setSelectionRange(0, 99999);

                try {
                    navigator.clipboard.writeText(input.value);
                    window.getSelection().removeAllRanges();

                    Toast.fire({
                        type: 'success',
                        title: 'Copiado correctamente'
                    });
                } catch(err) {
                    console.log(err)
                }
            })
        }

        clipboart(dom.clipboard.usuario);
        clipboart(dom.clipboard.password);

        // dom.btn_clipboard.addEventListener('click',function(e){
        //     dom.input_password.focus();
        //     dom.input_password.select();

        //     try {
        //         let successful = document.execCommand('copy');
        //         let msg = successful ? 'successful' : 'unsuccessful';
        //         window.getSelection().removeAllRanges();

        //         Toast.fire({
        //             type: 'success',
        //             title: 'Copiado correctamente'
        //         });
        //     } catch(err) {
        //         console.log(err)
        //     }
        // })
    });
</script>



