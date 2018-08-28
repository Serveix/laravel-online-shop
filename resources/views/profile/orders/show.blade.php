@extends('layouts.default')

@section('title', 'Tu pedido')

@section('content')

<div class="page-section title-area skyblue">
    <h1>Pedido #{{ $order->id + 1000 }}</h1>
</div>

<div class="page-section gray-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="not-printable">
                <div class="col-md-8 col-md-offset-2 white-bg">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ ($order->status_code != 4) ? route('active-orders') : route('completed-orders') }}">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Regresar a todas las ordenes
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:window.print()" class="btn button button-default">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Imprimir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 white-bg">
                <div class="not-printable">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="info">
                                <th>
                                    Estado de tu pedido
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if($order->statusCode->id == 5) {{-- 5 = Orden cancelada --}}
                                        <div class="col-md-3">
                                            <h3> 
                                                Orden cancelada
                                            </h3>
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
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr class="info">
                            <th colspan="2">Detalles del pedido</td>
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

                                <strong>Forma de Envío:</strong> {{ $order->shippment->method->description }} </td>
                        </tr>
                    </tbody>
                </table>
                

                @if( !empty($bankInfo) && $order->statusCode->id == 1)
                <table class="table table-bordered">
                    <thead>
                        <tr class="info">
                            <th colspan="2">Transferencia bancaria o pago en ventanilla</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-right" style="width: 30%;"> <strong>Banco</strong></td>
                            <td  style="width: 70%;">{{ $bankInfo['bank'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 30%;"><strong>Titular</strong></td>
                            <td  style="width: 70%;">{{ $bankInfo['titular'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 30%;"><strong>C.L.A.B.E.</strong></td>
                            <td  style="width: 70%;">{{ $bankInfo['clabe'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 30%;"><strong>Referencia</strong></td>
                            <td  style="width: 70%;">{{ $order->id + 1000 }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 30%;"><strong>Sucursal</strong></td>
                            <td  style="width: 70%;">{{ $bankInfo['sucursal'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 30%;"><strong>Cuenta</strong></td>
                            <td  style="width: 70%;">{{ $bankInfo['cuenta'] }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif




                <table class="table table-bordered">
                    <thead>
                        <tr class="info">
                            <th>Dirección de Facturación</th>
                            <th >Dirección de Envío</th>
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
                            <td colspan="3" class="text-right"><b>Sub-Total:</b></td>
                            <td class="right">$ {{number_format($subtotal, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><b>IVA (16%):</b></td>
                            <td class="right">$ {{number_format($subtotal * (App\StoreSetting::find('iva_value')->value/100), 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><b>{{$order->shippment->method->description}}: </b></td>
                            <td class="right">$ {{number_format($order->shippment->price, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><b>Total:</b></td>
                            <td class="right">$ {{number_format($order->invoice->payment->payment_amount, 2, '.', ',')}}</td>
                        </tr>
                    </tfoot>
                </table>
                
                @if( !empty($paymentPdfURL) && $order->statusCode->id == 1)
                <table class="table table-bordered">
                    <thead>
                        <tr class="info">
                            <td><h3>Ficha de pago para tienda de conveniencia</h3></td>
                        </tr>
                    </thead>
                </table>
                    <object class="spei-pdf" id="payPdf" data="{{$paymentPdfURL}}" type="application/pdf">
                        <embed src="{{$paymentPdfURL}}" type="application/pdf" />
                    </object>
                
                @endif


            </div>
        </div>
    </div>   
</div>
<div class="page-section gray-bg"></div>


@endsection
