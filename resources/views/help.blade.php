@extends('layouts.default')

@section('title', 'Ayuda')

@section('content')
<div class="page-section title-area skyblue">
  <h1>@if(!empty($user)) Hola, {{ $user->name }} @else Hola. @endif &iquest;En qu&eacute; podemos ayudarte?</h1>
</div>

<div class="page-section"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">

                <h2>Correo electronico</h2>
                <p><a href="mailto:soporte@karloservices.com"><strong>soporte@karloservices.com</strong></a></p>
            	
            	<h2>Telefono</h2>
            	<p>Para Nuevo Leon:
            	    <a href="tel:83317659"><strong>8331 7659</strong></a><br/>
            	</p>
            	
            	<p>Para la republica: 
            	    <a href="tel:018183317659"><strong>01 81 8331 7659</strong></a>
            	</p>
            	
            	
            </div>
            <div class="col-md-4">
            	<h2>Mensaje directo</h2>
            	<form>
            	    {{ csrf_field() }}
            	    <div class="form-group">
            	        <label>Nombre:</label>
            	    	<input type="text" class="form-control" name="name" value="{{ $user->name or '' }}" placeholder="Ej. John Doe">
            	    </div>

            	    <div class="form-group">
            	        <label>Correo electronico:</label>
            	    	<input type="text" class="form-control" name="email" value="{{ $user->email or '' }}" placeholder="Ej. john.doe@example.com">
            	    </div>

            	    <div class="form-group">
            	        <label>Mensaje:</label>
            	    	<textarea style="resize: none;" class="form-control" name="message"></textarea>
            	    </div>

            	    <div class="form-group">
            	        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
            	    </div>

            	    <input type="submit" value="Enviar" class="btn button button-blue">

            	</form>
            </div>
        </div>
    </div>
</div>
<div class="page-section"></div>
@endsection

@section('script')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection