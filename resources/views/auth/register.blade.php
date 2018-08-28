@extends('layouts.default')
@section('title', '| Registro')
@section('content')

<div class="page-section title-area skyblue">
  <h1>Registrarse</h1>
</div>
<div class="page-section skyblue2-bg">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Nombre Completo</label>

                            
                                <input id="name" type="text" class="form-control" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" >E-mail</label>

                            
                                <input id="email" type="email" class="form-control" name="email" placeholder="john.doe@example.com" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" >Contraseña</label>

                            
                                <input id="password" type="password" class="form-control" name="password" placeholder="********" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Confirmar contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="********"  required>
                        </div>
                        
                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn button button-default">Registrarse</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="page-section"></div>

@endsection

@section('script')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
