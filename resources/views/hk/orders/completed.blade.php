@extends('layouts.housekeeping')

@section('title', 'Ordenes terminadas')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 white-bg">
			<h3>Todas las ordenes completadas o canceladas</h3>
			
			<a href="{{ route('hkorders') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>

			<table class="table table-hover table-bordered ">
				<thead>
				    <tr>
				        <th style="width:5%" class="text-center"><i class="fa fa-eye" aria-hidden="true"></i></th>
				        <th style="width:20%">Fecha ({{ Config::get('app.timezone') }})</th>
				        <th style="width:10%">No. de orden</th>
				        <th style="width:20%">M&eacute;todo de pago</th>
				        <th style="width:25%">Usuario</th>
				        <th style="width:20%">Estado</th>
				    </tr>
				</thead>
				<tbody>
				    @if($orders->count() < 1)
				    <tr>
				        <td colspan="6">No hay ordenes terminadas.</td>
		            </tr>
				    @endif
				    @foreach($orders as $order)
			    	<tr>
			    	    <th class="text-center">
			    	        <a href="{{ route('hkorder', ['order'=>$order->id]) }}">Ver</a>
			    	    </th>
			    		<td>
			    		    [
			    		    @if(date_format($today, "d/m/y") == date_format($order->created_at,"d/m/y") )
			    		        Hoy, {{ date_format($order->created_at, "h:i a") }}
			    		    @elseif( date_format($yesterday, "d/m/y") == date_format($order->created_at,"d/m/y"))
			    		        Ayer, {{ date_format($order->created_at, "h:i a") }}
			    		    @else
			    		        {{ date_format($order->created_at,"d/m/y, h:i a") }}
			    		    @endif
			    		    ]
			    		</td>
			    		<td> {{ $order->id + 1000 }} </td>
			    		<td>
			    		    {{ $order->invoice->payment->method->description }}
			    		    (<small>$</small>{{$order->invoice->payment->payment_amount}})
			    		</td>
			    		<td> {{ $order->fromUser->name }} </td>
			    		<td> 
			    		    <select>
			    		        @foreach($orderStatusCodes as $sc)
			    		        <option @if($sc->id == $order->statusCode->id) selected @endif >{{ ucfirst($sc->description) }}</option>
			    		        @endforeach
			    		    </select>
			    		</td>
			    	</tr>
			    	
    				@endforeach

			    </tbody>
			</table>
			
		</div>
	</div>
</div>

@endsection