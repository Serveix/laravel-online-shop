@extends('layouts.default')

@section('title', '| Detalles del Producto')

@section('content')
<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a href="/">Inicio</a> >
                Hardware > 
                <a href="/store/{{$product->type->slug}}">{{ ucfirst($product->type->name) }}</a> >
                {{ $product->name }}
                <hr/>
            </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h2><strong>{{ $product->name }}</strong></h2>
          </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
              
                  <img class="img-thumbnail" width="100%" src="{{ asset('assets/img/product_img/' . $product->img_name) }}" alt="Imagen del producto {{ $product->name }}"/>
                  <p class="text-muted">Las im&aacute;genes son ilustrativas y puede variar seg&uacute;n el modelo.</p>
            </div>
            
            <div class="col-md-4">
                
                <div class="details-box text-center">
                    <div class="col-md-6 product-info-box ">
                        <strong>SKU: </strong>{{ $product->id + 1000 }}<br/>
                        @if(!empty($product->guarantee))
                        <strong>Garantia:</strong> {{ $product->guarantee }}<br/>
                        @endif
                        <strong>Envio: </strong>24 horas<br/><br/>
                        <br/>
                        <br/>
                    </div>
                    
                    <div class="col-md-6 ">
                        <p class="text-muted">Precio con IVA:</p>
                        <p class="price">$ {{ $product->finalPrice() }}</p>
                    </div>
                    
                    <button value="{{$product->id}}" class="btn button button-blue add-to-cart">Agregar <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                    <div class="alert alert-danger hidden item-error-{{ $product->id }} "> </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="details-box white">
                    <h4>Descripci&oacute;n</h4>
                    {!! $product->description !!}
                    
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="details-box">
                    Calificacion promedio: </a>
                    {{-- Estrellas --}}
                    
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="details-box white details-table">
                    {!! $product->details !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-section"></div>

@endsection
@section('script')
<script>
// IIFE - Immediately Invoked Function Expression
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    
    //gives table from details section some style
    $('.details-table table').addClass('table').addClass('table-bordered');
    
    //the rest of the code goes here
    $('.add-to-cart').click(function() {
        var itemId = $(this).val();
        var cart = $('.cart-container');
        
        cart.removeClass('open-cart');
        
        // updateCart() adds item to cart-items session by using ajax post
        // returns number of items in cart or a string with an error
        /*global updateCart*/
        updateCart(itemId).done(function(response) {
            var errorBox = $('.item-error-'+itemId);
            var cartArticlesNumber = $('.cart-articles-no');
            
            if( ! isNaN(response) ) //if its numeric
            {
                errorBox.addClass('hidden');
                
                if(cartArticlesNumber.html() == 0 && response != 0)
                {
                    $('.cart-container').removeClass('empty-cart');
                    cartArticlesNumber.html( response );
                } 
                else if(cartArticlesNumber.html != 0 && response != 0)
                    cartArticlesNumber.html(response);
            }
            else
                errorBox.removeClass('hidden').html(response);
                
        });
        
        loadingImg.addClass('hidden');
        
    });
    
}));
</script>
@endsection