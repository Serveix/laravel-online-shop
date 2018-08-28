<div class="cart-items">
    <ul>
        @foreach($cartItems as $cartItem)
            @php
            $product = $cartItem['product'];
            $quantity = $cartItem['quantity'];
            @endphp
        
        <li class="product product-id-{{$product->id}}">
            <div class="product-img">
                <img height="70" src="{{ asset('assets/img/product_img/' . $product->img_name) }}" />
            </div>
            
            <div class="product-details">
                <h3><a href="{{route('product-page', ['product' => $product->id])}}">{{ ucfirst( $product->name ) }}</a></h3>
                
                {{-- This final price is already modified for finalPrice, no need of calling finalPrice() --}}
                <span class="price"><small>$</small> {{ $product->price }} <small>c/u</small></span>
                
                <div class="actions">
                    <button class="btn-link delete" value="{{ $product->id }}">
                        <i class="fa fa-times" aria-hidden="true"></i> Borrar
                    </button> 
                    
                    <label for="quantity">Cantidad: </label>
                    <select id="quantity" class="quantityBtn" name="quantity" height="100">
                        @for($i = 0 ; $i < $product->in_stock ; $i++)
                        <option {{ $quantity == ($i+1) ? 'selected' : '' }} value="{{ $product->id }}">{{$i+1}}</option>
                        @endfor
                    </select>
                </div>
                
            </div>
        </li>
        @endforeach
        
        
    </ul>
</div>

<footer>
    <a href="{{route('checkout')}}" class="checkout btn">
        <em>
            <!-- precio final actualizado con js -->
        </em>
    </a>
</footer>

<script>
(function(yourcode) {
    yourcode(window.jQuery, window, document);
} (function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    
    var deleteBtn = $('.delete');
    var quantityBtn = $('.quantityBtn');
    var cart = $('.cart-container');
    var itemsNumber = $('.cart-articles-no');
    var cartItems = {!! json_encode($cartItems) !!};
    
    var checkoutBtn = $('.checkout em');
    
    function updateFinalPrice()
    {
        var finalPrice, item, quantity, itemElem;
        
        for(var i = 0 ; i < cartItems.length ; i++){
            item = cartItems[i].product;
            itemElem = $('.product-id-' + item.id);
            quantity = itemElem.find(quantityBtn).find(":selected").text();
            
            if( ! itemElem.hasClass('deleted-item') ) {
                if(finalPrice == null)
                    finalPrice = item.price * quantity;
                else
                    finalPrice += item.price * quantity;
            }
            
        }
        
        checkoutBtn.html('Pagar: $ ' + finalPrice);
        
    }
    
    updateFinalPrice();
    
    deleteBtn.click(function() {
        var itemId = $(this).val();
        console.log('deleting itemid: ' + itemId);
        
        /*global deleteItem*/
        deleteItem(itemId).done(function(response) {
            var item = $('.product-id-'+itemId);
            if( ! isNaN(response) ) // if numeric
            {
                if(response == 0)
                {
                    itemsNumber.html(0);
                    
                    // this closes the cart, delays 500ms, hides the cart trigger
                    cart.removeClass('open-cart').delay(500).queue(function(){
                        $(this).addClass('empty-cart').dequeue();
                    });
                    
                }
                else
                {
                    itemsNumber.html( response ); //update number in cart
                    item.addClass('deleted-item'); //hide item
                    updateFinalPrice(); //update final price
                }
            }
            else
                console.log( response );
            
        });
    }); //delete function ends
    
    quantityBtn.on('change', function(){
        
        var itemId = $(this).val();
        var newQuantity =  $(this).find('option:selected').text();
        
        /*global updateQuantityOfItems */
        updateQuantityOfItems(itemId, newQuantity).done(function(response) {
            if( ! isNaN(response) ) // if numeric
                itemsNumber.html( response ); 
            else
                alert( response );
        });
        
        
        updateFinalPrice();
        
    });
    

}));
</script>