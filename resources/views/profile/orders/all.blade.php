@extends('layouts.default')

@section('title', 'Ordenes')

@section('content')

<div class="page-section title-area skyblue">
    <h1>Pedidos {{ $ordersType }}s</h1>
</div>

<div class="page-section gray-bg">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 white-bg">
                <a href="/">Inicio</a> >
                <a href="{{route('profile')}}">Perfil</a> >
                Pedidos: {{ $ordersType }}s
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 white-bg"> 
                
                @if($orders->count() > 0)
                <ul class="list-button">
                @foreach($orders as $order)
                
                    <li>
                        <a href="{{ route('order', ['order' => $order->id]) }}">
                            <div class="container-fluid">
                                <div class="row">
                                    <h4><strong>ID del pedido:</strong> #{{ $order->id + 1000 }}</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <strong>Estado:</strong> {{ $order->statusCode->description }} <br/>
                                        <strong>Fecha emitida: </strong> {{ date_format($order->created_at,"d/m/y")  }}
                                    </div>
                                    <div class="col-md-5">
                                        <strong>Productos:</strong> {{ $order->products->count() }} <br/>
                                        <strong>Total:</strong> {{ number_format($order->invoice->payment->payment_amount, 2, '.', ',') }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                
                @endforeach
                </ul>

                @else
                <div class="col-md-12">
                    <hr/>
                    No hay ning&uacute;n pedido {{ $ordersType }}.
                    
                    <hr/>
                </div>
                @endif

            </div>
          
        </div> 
    </div>   
</div>
</div>
<div class="page-section"></div>


@endsection
