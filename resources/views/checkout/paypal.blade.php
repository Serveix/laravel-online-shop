@extends('layouts.default')

@section('title', 'Pago con banco')

@section('content')

<div class="page-section title-area skyblue">
  <h1>Pago con Paypal <i class="fa fa-paypal" aria-hidden="true"></i></h1>
</div>

<div class="page-section">
    <div class="container-fluid">
        <div class="col-md-8 col-md-offset-2">
        	<h3>Iniciar proceso</h3>
        	<p>Da click en el bot&oacute;n para comenzar tu proceso de pago directamente con Paypal:</p>
        	
        	<div id="paypal-button" class="text-center"></div>
        
        </div>
    </div>
</div> <!--/ page-section -->

<div class="not-printable">
    <!-- for separation purposes between content and footer -->
    <div class="page-section"></div>
</div>


@endsection
@section('script')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    //rest of the code here


	function createOrder(payment) {
	    return $.ajax({
	        url: "/checkout/paypal/success",
	        type: "post",
	        data: {
	        	paypalPaymentId: payment.id,
	        }
	    });
	}


    paypal.Button.render({

        env: 'production', // 'production' or 'sandbox',

        style: {
            size: 'medium',
            color: 'blue',
            shape: 'pill',
            label: 'checkout'
        },

        client: {
            sandbox:    'ATgGTu4vvKBH1-sF5QcFfgbQDsyw6RBfukkiRMSxdhK3_R5PMaeDnhkaOD_zhfymvMa37mV2QRwxBaqV',
            production: 'AdXulw10vktEIYGdnS4DgVZVpxPyzgkKjfppzRrvXwnHOWcg_Db4H79FPoOficVNJeO8L61R3c7HCRH6'
        },

        commit: true, // Show a 'Pay Now' button

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '{{ $orderInfo["totalPrice"] + $orderInfo["shippmentPrice"] }}', currency: 'MXN' }
                        }
                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {
            	createOrder(payment).done(function(response) {
            		window.location.href = response;
            	});
            });
        }

    }, '#paypal-button');

}));
</script>
@endsection