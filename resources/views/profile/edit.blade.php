@extends('layouts.panel')

@section('title','Perfil')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Perfil</li>
</ol>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del usuario</h3>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('perfil.store') }}" method="POST" id="profile-form"
                    enctype="multipart/form-data"
                    oninput='password_confirmation.setCustomValidity(password_confirmation.value != password.value ? "Las contraseñas no coinciden." : "")'>
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="text-center">
                                <img id="profile-image" src="{{ $user->avatar }}"
                                    class="avatar img-circle img-thumbnail" alt="foto de perfil"
                                    style="width:100px; height:100px;">

                                <h6>Cargar una foto diferente...</h6>
                                <div class="btn-group">
                                    <span class="btn btn-primary btn-file"><i class="psi-upload"></i> Seleccionar
                                        Archivo
                                        <input type="file" id="profile-input-image" name="archivo"></span>

                                    <button id="profile-image-remove" class="btn btn-danger cancel" type="button">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="input-nombre">Nombre</label>
                                        <input type="text"
                                            class="form-control"
                                            name="nombre"
                                            id="input-nombre"
                                            placeholder="Nombre"
                                            title="Ingrese su nombre"
                                            autocomplete="off"
                                            value="{{ old('nombre', $user->nombre) }}"
                                            readonly>
                                        <div id="login-help" class="error invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="input-login">Usuario</label>
                                        <input type="text"
                                            class="form-control"
                                            name="usuario"
                                            id="input-usuario"
                                            placeholder="Ejemplo: Usuario09"
                                            title="Usuario"
                                            autocomplete="off"
                                            aria-describedby="usuario-help"
                                            value="{{ old('usuario', $user->usuario) }}"
                                            readonly>

                                        <div id="usuario-help" class="error invalid-feedback">
                                            @error('usuario') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="password">Contraseña</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            id="input-password"
                                            placeholder="Contraseña"
                                            aria-describedby="password-help" title="Ingresa tu contraseña."
                                            autocomplete="off"
                                            required>
                                        <div id="password-help" class="error invalid-feedback">
                                            @error('password') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="input-password_confirmation">Confirmar Contraseña</label>
                                        <input type="password"
                                            class="form-control  @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation"
                                            id="input-password_confirmation"
                                            placeholder="Confirmar Contraseña"
                                            aria-describedby="password_confirmation-help"
                                            title="Confirma tu contraseña."
                                            autocomplete="off"
                                            required>
                                        <div id="password_confirmation-help" class="error invalid-feedback">
                                            @error('password_confirmation') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <a href="{{ app('router')->has('home') ? route('home') : url('/') }}" class="btn btn-dark">
                    <i class="fas fa-arrow-left"></i> {{ __('Regresar') }}
                </a>
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-primary" form="profile-form"> <i class="fas fa-save"></i>
                        Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    const imagePreview = (function(){

        const dom = {
            'image': document.getElementById('profile-image'),
            'input': document.getElementById('profile-input-image'),
            'form': document.getElementById('profile-form'),
            'remove_btn': document.getElementById('profile-image-remove'),
            'image_navbar': document.getElementById('avatar-image')
        };
        const DEFAULT_IMAGE = "{{ asset('img/theme/avatar.png') }}";
        const API_AUTH_ROUTE = "{{ route('api.user.auth-user') }}"
        const USER_ID = "{{ auth()->id() }}"

        let removedImage = false

        // EVENTS
        dom.input.addEventListener('change', loadImage);
        dom.remove_btn.addEventListener('click',removeImage);
        dom.form.addEventListener('submit',submit);

        function loadImage(e)
        {
            let firstFile = this.files[0];

            if(!firstFile){
                return;
            }

            if(!firstFile.type.match('image.*')){
                return alert('Solo imagenes válidas');
            }

            let reader = new FileReader();

            reader.onload = function(readerEvent) {
                dom.image.src = readerEvent.target.result;
                dom.image_navbar.src = readerEvent.target.result;
            }

            reader.readAsDataURL(firstFile);
        }

        function removeImage(e){
            const btn = event.target.closest("button");

            if (btn) {
                dom.image.src = DEFAULT_IMAGE;
                dom.image_navbar.src = DEFAULT_IMAGE;
                dom.input.value = null
            }

            removedImage = true;
        }

        function submit(e){
            e.preventDefault();

            var input = document.createElement('input');

            Swal.fire({
                title: 'Ingresa tu contraseña actual',
                input: 'password',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                showLoaderOnConfirm: true,
                inputAttributes: {
                    maxlength: 10,
                    autocapitalize: 'off',
                    autocorrect: 'off',
                    id:'input-auth-password'
                },
                preConfirm: (password) => {
                    return axios.post(API_AUTH_ROUTE,{
                        user_id: USER_ID,
                        password:password
                    }).then(function(response){
                        return response.data.success;
                    }).catch(function(error){
                        let inputPasswd = document.getElementById('input-auth-password');
                        inputPasswd.value = null

                        if(error.response) {
                            Swal.showValidationMessage(error.response.data.message)
                        }else{
                            Swal.showValidationMessage(`Error en la peticion: ${error}`)
                        }
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()

                }).then((result) => {
                    if (result.value) {
                        input.type = 'hidden';
                        input.name = 'deleted_image';
                        input.value = removedImage;

                        Swal.fire({
                            title: 'Procesando',
                            html: 'Espere un momento por favor.',
                            allowEscapeKey:false,
                            allowOutsideClick:false,
                            allowEnterKey:false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })

                        dom.form.appendChild(input);
                        dom.form.submit();
                    }
                })
        }
    })();
</script>
@endsection
