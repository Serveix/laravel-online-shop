<div class="col-md-12"> 
    {{ $currentPage }} de {{ $totalPages }} p&aacute;ginas
</div>
@foreach($products as $product)
<div class="col-md-12"> 
    <div class="container-fluid product-container">
        
        <div class="row">
            <div class="col-md-2 text-center">
                <a href="{{route('product-page', ['product' => $product->id]) }}">
                    <img class="product-img " src="{{ asset('/assets/img/product_img/' . $product->img_name) }}" alt="img"/>
                </a>    
            </div>
            <div class="col-md-1 text-center">
                <img class="manufacturer-logo" src="{{ asset('/assets/img/manufacturer_img/' . $product->manufacturerImgName().'.png' ) }}">
                <p class="product-sku">
                    SKU: {{ $product->id + 1000 }}
                </p>
            </div>
            <div class="col-md-6">
                <h4 >
                    <a href="{{ route('product-page', ['product' => $product->id]) }}">
                        <strong>{{ $product->name }}</strong>
                    </a>
                </h4>
                
                <p class="product-description">{!! $product->description !!}</p>
                
            </div>
            
            <div class="col-md-3 text-center">
                
                <p class="product-price ">
                    $ {{ $product->finalPrice() }} MXN<br/><small>IVA incluido</small>
                </p>
               
                
                <button class="btn button button-default add-to-cart" value="{{ $product->id }}">
                    Agregar! <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </button>
                <img class="cart-add-loading-{{ $product->id }} hidden" src="{{asset('assets/img/loading.gif')}}" />
                
                <div class="alert alert-danger hidden item-error-{{ $product->id }} "> </div>
                
            </div>
        </div>
    </div>
</div>
@endforeach


@for($i = 0 ; $i < $totalPages; $i++) 
    @php ($onePage = $i + 1)
    
    @if($onePage != $currentPage)
        <a class="btn button button-default" alt="Ir a pagina {{ $onePage }}" href="{{ route('store', ['productType' => $productTypeSlug, 'page' => $onePage]) }}">{{$onePage}}</a>
    @else 
        <a class="btn button button-default" alt="Te encuentras en la pagina {{$onePage}}" disabled>{{ $onePage }}</a>
    @endif
    
@endfor

<script>
// IIFE - Immediately Invoked Function Expression
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    //the rest of the code goes here
    
    // event when ADD TO CART button is clicke
    $('.add-to-cart').click(function() {
        var itemId = $(this).val();
        var loadingImg = $('.cart-add-loading-' + itemId);
        var cart = $('.cart-container');
        
        cart.removeClass('open-cart');
        loadingImg.removeClass('hidden');
        
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
                errorBox.removeClass('hidden').html(response).delay(8000).queue(function(){
                    $(this).addClass('hidden').dequeue();
                });;
                 
        });
        
        loadingImg.addClass('hidden');
        
    });
}
));
</script>