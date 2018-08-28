@extends('layouts.housekeeping')

@section('title', 'Ordenes activas')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 white-bg">
			<h3>Todas las ordenes activas</h3>
			
			<a href="{{ route('hkorders') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
			<div class="table-responsive">
				<table class="table table-hover table-bordered ">
					<thead>
					    <tr>
					        <th style="width:5%" class="text-center"><i class="fa fa-eye" aria-hidden="true"></i></th>
					        <th style="width:17%">Fecha ({{ Config::get('app.timezone') }})</th>
					        <th style="width:8%">#</th>
					        <th style="width:20%">M&eacute;todo de pago</th>
					        <th style="width:17%">Cliente</th>
					        <th style="width:13%">Detalles</th>
					        <th style="width:20%">Estado</th>
					    </tr>
					</thead>
					<tbody>
					    @if($orders->count() < 1)
					    <tr>
					        <td colspan="6">No hay ordenes activas.</td>
			            </tr>
					    @endif
					    @foreach($orders as $order)
				    	<tr id="order-{{$order->id}}">
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
				    		<td> {{ $order->fromUser->name }} (ID: {{ $order->fromUser->id }}) </td>
				    		<td> {{ $order->details }} </td>
				    		<td> 
				    			<form class="status-form">
				    				<input type="hidden" name="orderId" value="{{$order->id}}">
					    		    <select name="statusCode" class="form-control">
					    		        @foreach($orderStatusCodes as $sc)
					    		        <option value="{{$sc->id}}" @if($sc->id == $order->statusCode->id) selected @endif >{{ ucfirst($sc->description) }}</option>
					    		        @endforeach
					    		    </select>
					    		    <input type="submit" class="btn button button-blue" value="Actualizar"> 
					    		    <i class="fa fa-check" aria-hidden="true"></i>
					    		    <img src="{{ asset('assets/img/loading.gif') }}" class="loading-img hidden" width="35" alt="Loading..."/>
					    			<div class="alert alert-danger hidden"></div>
					    		</form>
					    		
				    		</td>
				    	</tr>
				    	
	    				@endforeach

				    </tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>

@endsection

@section('script')
	<script type="text/javascript">
		(function(yourcode) {
	        yourcode(window.jQuery, window, document);
	    } (function($, window, document) {
	        $(function() {
	        // The DOM is ready!
	        });
	        // rest of the code here

	        var form = $('.status-form');

	        form.submit(function(e) {
	        	e.preventDefault();
	        	
	        	var submitButton = $(this).find('input[type=submit]');
	        	var loadingIcon  = $(this).find('i.fa.fa-check');
	        	var loadingImg   = $(this).find('img.loading-img');
	        	var errorDiv = $(this).find('div.alert.alert-danger');

	        	submitButton.prop('disabled', true).val('Actualizando...');
	        	loadingIcon.addClass('hidden');
	        	loadingImg.removeClass('hidden');


	        	updateOrderStatus( $(this) ).done(function(response) {
	        		console.log(response);
	        		switch(response){
	        		    case 'success':
			        		loadingIcon.removeClass('hidden');
			        		loadingImg.addClass('hidden');
			        		submitButton.val('¡Actualizado!').delay(1000).queue(function(){
			        			$(this).val('Actualizar').prop('disabled', false).dequeue();
			        		}); 
			        		break;
		        		case 'cancelled':
		        			loadingIcon.removeClass('hidden');
			        		loadingImg.addClass('hidden');
			        		submitButton.val('¡Cancelado!');
		        			break;
		        	    default: 
		        		    errorDiv.removeClass('hidden').html(response);
		        	}
	        	});


	        });


	    }));
	</script>
@endsection