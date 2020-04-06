@extends('layouts.form')

@section('title', 'Inicio de sesión')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>Help Desk</b> Covemex</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif

            @if(Session::has('message'))
                <div class="alert alert-info" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <p class="login-box-msg">Ingresa al sistema</p>

            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
                @method('POST')
                <div class="input-group mb-3">
                    <input class="form-control @error('usuario') is-invalid @enderror"
                        placeholder="Usuario" type="text" name="usuario"
                        aria-describedby="usuario-help"
                        value="{{ old('usuario') }}"
                        autocomplete="off" autofocus required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                    <div id="usuario-help" class="error invalid-feedback">
                        @error('usuario') {{ $message }} @enderror
                    </div>

                </div>
                <div class="input-group mb-3">
                    <input class="form-control @error('password') is-invalid @enderror"
                        placeholder="Contraseña" type="password" name="password"
                        aria-describedby="password-help" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div id="password-help" class="error invalid-feedback">
                        @error('passowrd') {{ $message }} @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                          <input type="checkbox" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                          <label for="remember">
                            Recordarme
                          </label>
                        </div>
                      </div>

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>

                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-1">
                <a href="{{ route('password.request') }}">Olvide mi contraseña</a>
            </p>
        </div>
        <!-- /.login-card-body -->
        <div class="card-footer m-0 text-center">
            <p class="text-muted m-0" >&copy; {{ config('helpdesk.global.company') }} 2019-2020</p>
        </div>
    </div>
</div>
@endsection
