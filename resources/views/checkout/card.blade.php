@extends('layouts.default')

@section('title', 'Pago con tarjeta')

@section('content')

<div class="page-section title-area skyblue">
  <h1><i class="fa fa-credit-card" aria-hidden="true"></i> Pago</h1>
</div>

<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-md-offset-1 payment-form-container gray-bg">
                <header>
                    @if (session('card-errors'))
                    <div class="alert alert-danger">
                        <ul>
                            {{ session()->get('card-errors') }}
                        </ul>
                    </div>
                    @endif

                    <h2>Tarjetas</h2>
                    
                    <div class="row">
                        <div class="col-md-3">
                            Tarjetas de cr&eacute;dito</span>
                        </div>
                        <div class="col-md-9">
                            <img class="credit-card image-responsive" src="{{asset('assets/img/openpay/cards1.png')}}">
                        </div>
                        
                        <div class="col-md-3">
                            Tarjetas de d&eacute;bito
                        </div>

                        <div class="col-md-9">
                            <img class="debit-card image-responsive" src="{{asset('assets/img/openpay/cards2.png')}}">
                        </div>
                    </div>
                </header>
                
            
                <form action="#" method="POST" id="payment-form">
                    <input type="hidden" name="token_id" id="token_id">
                    <input type="hidden" name="deviceIdHiddenFieldName">
                    {{csrf_field()}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre del titular</label>
                            <input class="form-control" type="text" maxlength="150" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                        </div> 

                        <div class="form-group">  
                            <div class="row">
                                <div class="col-md-12">  
                                    <label>Fecha de expiración</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" type="text" placeholder="Mes" data-openpay-card="expiration_month" maxlength="2">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" type="text" placeholder="Año" data-openpay-card="expiration_year" maxlength="2">
                                </div>
                            </div>
                        </div>
                          
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">        
                                <label>Número de tarjeta</label>
                                <input class="form-control" type="text" autocomplete="off" data-openpay-card="card_number" maxlength="19">
                            </div> 
                            

                            <div class="form-group">
                                <div class="col-md-12"><label>Código de seguridad</label></div>
                                <div class="col-md-6 col-xs-4">
                                    <input class="form-control" type="text" placeholder="3 dígitos" maxlength="4" autocomplete="off" data-openpay-card="cvv2">
                                </div>
                                <div class="col-md-6 col-xs-8">
                                    <div class="sec-code"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4 submit-text">
                            <div class="col-md-6 col-xs-6">
                            Transacciones realizadas vía:
                                <div class="openpay-logo"></div>
                            </div>
                            
                            <div class="col-md-6 col-xs-6 security text-center">
                                <div class="col-md-2 col-xs-12">
                                    <div class="security-img"></div>
                                </div>
                                <div class="col-md-10 col-xs-12">
                                    Tus pagos se realizan de forma segura con encriptación de 256 bits
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-md-offset-6">
                                <button class="btn button button-blue" id="pay-button">Confirmar y pagar</button>
                            </div>
                        </div>
                    </div>
                </form>
                    
                {{-- / OPEN PAY STYLES --}}
            </div>
            <div class="col-md-3 checkout-summary">
                <h4><strong><i class="fa fa-list-ul" aria-hidden="true"></i> Resumen del pedido</strong></h4>
                <hr>
                @php($finalPrice = 0.0)
                
                @foreach($orderInfo['products'] as $product)
                    @php($finalPrice += str_replace(',', '', $product['price']) * $product['quantity'] )
                    
                    <p class="product-name">
                        <em>{{ $product['quantity'] }} x {{ $product['name'] }}</em>
                        
                            $ {{ str_replace(',', '', $product['price']) * $product['quantity'] }}
                        
                    </p>
                    
                @endforeach
                <hr>
                <p class="product-name">
                    <em>Subtotal:</em>
                    
                        $ {{ number_format($finalPrice, 2, '.', ',') }}
                    
                </p>
                <p class="product-name">
                    <em>IVA:</em>
                    
                        $ {{ number_format($finalPrice * (App\StoreSetting::find('iva_value')->value / 100), 2, '.', ',') }}
                    
                </p>
                
                
                <hr>
                <p class="products-total">
                    Total: 
                    <span>
                        $ {{ number_format($finalPrice + $finalPrice * (App\StoreSetting::find('iva_value')->value / 100), 2, '.', ',') }}
                    </span>
                    <!-- <input type="hidden" name="total-price" value="{{ $finalPrice + $finalPrice * (App\StoreSetting::find('iva_value')->value / 100) }}"> -->
                </p>

                
                <p class="product-name" id="shippment-price">
                    <em>+ Envio:</em>
                    
                    <span>$ {{ $orderInfo['shippmentMethod']->price }}</span>
                    
                </p>
                
            </div>
        </div> <!--/ row -->
    </div> <!--/ container-fluid -->
</div> <!--/ page-section -->

<!-- for separation purposes between content and footer -->
<div class="page-section"></div>
<div class="page-section"></div>
@endsection


@section('script')
<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<script type="text/javascript">
(function(yourcode) {
    yourcode(window.jQuery, window, document);
} (function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    //rest of code 
    
    // HARDCODE: merchant-id and public key
    OpenPay.setId('..merchant-id..');
    OpenPay.setApiKey('..publickey..');
    
    OpenPay.setSandboxMode(true);
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
    
    $('#pay-button').click(function(event) {
       event.preventDefault();
       $('#pay-button').prop('disabled', true);
       OpenPay.token.extractFormAndCreate('payment-form', success_callback, error_callback);                
    });


    var success_callback = function(response) {
        var token_id = response.data.id;
        $('#token_id').val(token_id);
        $('#payment-form').submit();
    };


    var error_callback = function(response) {
        var desc = response.data.description != undefined ? 
                    response.data.description : response.message;
        
        alert("ERROR [" + response.status + "]: " + desc);
        
        $("#pay-button").prop('disabled', false);
    };


}));
</script>
@endsection