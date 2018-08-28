@extends('layouts.housekeeping')

@section('title', 'Orden')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 white-bg">

			<a href="{{ route('hkorders') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				Regresar
			</a>
			<h3>Pedido #{{ $order->id + 1000 }}</h3>
			<table class="table table-bordered">
                <thead>
                	<tr class="info">
                        <th>
                            Estado del pedido
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if($order->statusCode->id == 5) {{-- 5 = Orden cancelada --}}
                                <div class="col-md-3">
                                    <h4> 
                                        Orden cancelada
                                    </h4>
                                </div>
                            @else
                                @for($i = 0; $i < $order->statusCode->id; $i++)
                                    
                                    @php
                                    switch( ($i+1) )
                                    {
                                        case 1: // procesando
                                            $date = date_format($order->created_at, "d/m/y");
                                        break;

                                        case 2: // confirmado
                                            $date = date_format(new DateTime($order->invoice->invoice_date), "d/m/y");
                                        break;

                                        case 3: // entregando
                                            $date = date_format(new DateTime($order->shippment->date), "d/m/y");
                                        break;

                                        case 4: // completado
                                            $date = date_format(new DateTime($order->shippment->date), "d/m/y");
                                        break;

                                    }
                                    @endphp

                                    <div class="col-md-3">
                                        <h4> 
                                            {{ ucfirst($orderStatusCodes->get($i)->description) }} <small>[{{ $date }}]</small>
                                        </h4>
                                    </div>
                                @endfor

                            @endif


                            <div class="col-md-12">
                                <div class="progress">
                                  <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                  aria-valuemin="0" aria-valuemax="100" style="width: {{ $order->statusCode->id * 25 }}% ">
                                    <label class="sr-only"> {{ $order->statusCode->id * 25 }}%</label>
                                  </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr class="info">
                        <th colspan="2">Detalles del pedido </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <strong>ID del pedido: </strong> {{ $order->id + 1000 }}<br>
                            <strong>Fecha emitida:</strong> {{ date_format($order->created_at,"d/m/y")  }}</td>
                        <td  style="width: 50%;"> 
                            <strong>Forma de Pago:</strong> {!! $order->invoice->payment->method->description !!}
                                                            
			                                                @if( !empty($paymentPdfURL) && $order->statusCode->id == 1)
			                                                (<a href="#payPdf">Ver ficha de pago abajo</a>)<br>
			                                                @endif
							<br/>
                            <strong>Forma de Envío:</strong> {{ $order->shippment->method->description }} </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
	            <thead>
	                <tr class="info">
	                    <th>Dirección de Facturación</th>
	                    <th>Dirección de Envío</th>
	                </tr>
	            </thead>
	            <tbody>
	                <tr >
	                    <td>
	                        {{ json_decode($order->invoice->address)->street_address1 }}, 
	                        {{ json_decode($order->invoice->address)->street_address2 }} <br/>
	                        {{ json_decode($order->invoice->address)->city }},
	                        {{ json_decode($order->invoice->address)->state }} <br/>
	                        {{ json_decode($order->invoice->address)->postal_code }} <br/>
	                        {{ json_decode($order->invoice->address)->indications }} <br/>
	                    </td>
	                    <td>
	                        {{ json_decode($order->shippment->address)->street_address1 }}, 
	                        {{ json_decode($order->shippment->address)->street_address2 }} <br/>
	                        {{ json_decode($order->shippment->address)->city }},
	                        {{ json_decode($order->shippment->address)->state }} <br/>
	                        {{ json_decode($order->shippment->address)->postal_code }} <br/>
	                        {{ json_decode($order->shippment->address)->indications }} <br/>
	                    </td>
	                </tr>
	            </tbody>
	        </table>

	        <table class="table table-bordered">
	            <thead>
	                <tr class="info">
	                    <th class="left">SKU</th>
	                    <th class="left">Nombre</th>
	                    <th class="right">Cantidad</th>
	                    <th class="right">Precio</th>
	                </tr>
	            </thead>

	            <tbody>
	                @php ($subtotal = 0)
	                @foreach($order->products as $product)
	                @php ($subtotal += $product->pivot->product_price)
	                <tr>
	                    <td class="text-center">{{ $product->id + 1000 }}</td>
	                    <td>{{ $product->name }} </td>
	                    <td class="text-center">{{ $product->pivot->product_quantity }}</td>
	                    <td>$ {{ number_format($product->pivot->product_price, 2, '.', ',') }}</td>
	                </tr>
	                @endforeach

	            </tbody>

	            <tfoot >
	                <tr>
	                    <th colspan="3" class="text-right">Sub-Total:</th>
	                    <td class="right">$ {{number_format($subtotal, 2, '.', ',')}}</td>
	                </tr>
	                <tr>
	                    <th colspan="3" class="text-right">IVA (16%):</th>
	                    <td class="right">$ {{number_format($subtotal * (App\StoreSetting::find('iva_value')->value/100), 2, '.', ',')}}</td>
	                </tr>
	                <tr>
	                    <th colspan="3" class="text-right">{{$order->shippment->method->description}}: </b></td>
	                    <td class="right">$ {{number_format($order->shippment->price, 2, '.', ',')}}</td>
	                </tr>
	                <tr>
	                    <th colspan="3" class="text-right">Total:</th>
	                    <td class="right">$ {{number_format($order->invoice->payment->payment_amount, 2, '.', ',')}}</td>
	                </tr>
	            </tfoot>
	        </table>
			
		</div>
	</div>
</div>

@endsection