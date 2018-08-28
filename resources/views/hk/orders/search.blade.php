@extends('layouts.housekeeping')

@section('title', 'Housekeeping')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 ">
			<h4>Buscar una orden</h4>
			<table class="table white-bg">
				<tbody>
			    	<tr>
			    		<td>
			    			@if ($errors->any())
							    <div class="alert alert-danger">
							        <ul>
							            @foreach ($errors->all() as $error)
							                <li>{{ $error }}</li>
							            @endforeach
							        </ul>
							    </div>
							@endif

							@if (session('hkorder-null'))
								<div class="alert alert-danger">
							        La orden no existe
							    </div>
							@endif
			    			<form method="post" action="#" class="form-inline">
			    				{{ csrf_field() }}
			    				<div class="form-group">
			    					<label for="search-input">
			    						Inserte numero de orden:
			    					</label>
			    					<input name="search-input" id="search-input" class="form-control" type="text" maxlength="20" placeholder="1230">

			    				</div>

			    				<input type="submit" class="btn button button-blue" value="Buscar">
			    			</form>
			    		</td>
			    	</tr>
			    </tbody>
			</table>
			<a href="{{ route('hkorders') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				Regresar 
			</a>
		</div>
	</div>
</div>

@endsection