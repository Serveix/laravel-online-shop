@extends('layouts.default')
@section('title', '| Login')
@section('content')
<div class="page-section title-area skyblue">
    <h1>INICIAR SESI&Oacute;N</h1>
</div>
<div class="page-section skyblue2-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Correo electronico</label>
                        <input id="email" type="email" class="form-control" name="email"  placeholder="john.doe@example.com" value="{{ old('email') }}" required autofocus>
                        
                        @if ($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="password" placeholder="********" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    
                    
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                        </label>
                    </div>
                    
                    <button type="submit" class="btn button button-default">Iniciar sesi&oacute;n</button>
                    
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        &iquest;Olvidaste tu contrase&ntilde;a?
                    </a>
                    
                    <a class="btn btn-link" href="/register">
                        &iquest;No tienes una cuenta? ¡Registrate ahora mismo!
                    </a>
                </form>
                
            </div>
        </div>
    </div>
</div>
<div class="page-section"></div>
@endsection
