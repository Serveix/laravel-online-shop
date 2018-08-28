@extends('layouts.housekeeping')

@section('title', 'Housekeeping')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 ">
			<h4>Seleccione una opci&oacute;n</h4>
			
			<table class="table table-hover white-bg">
				<tbody>
			    	<tr>
			    		<td><a href="{{ route('hkorder-search') }}"><i class="fa fa-search" aria-hidden="true"></i> Buscar orden</a></td>
			    		<td class="text-right"><i class="fa fa-arrow-right" aria-hidden="true"></i></td>
			    	</tr>
			    	<tr>
			    		<td><a href="{{ route('hkorders-active') }}"><i class="fa fa-clock-o" aria-hidden="true"></i> Ver ordenes activas</a></td>
			    		<td class="text-right"><i class="fa fa-arrow-right" aria-hidden="true"></i></td>
			    	</tr>
			    	<tr>
			    		<td><a href="{{ route('hkorders-completed') }}"><i class="fa fa-lock" aria-hidden="true"></i> Ver ordenes terminadas</a></td>
			    		<td class="text-right"><i class="fa fa-arrow-right" aria-hidden="true"></i></td>
			    	</tr>
			    </tbody>
			</table>
			
		</div>
	</div>
</div>

@endsection