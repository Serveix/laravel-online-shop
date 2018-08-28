@if( ! session()->exists('cartItems') )
    @php( session(['cartItems' => array() ]) )
@endif

<div class="cart-container">
    <div class="cart-articles-no">
        {{ count( session()->get('cartItems') ) }}
    </div>
    
    <div class="cart-circle">
        Carrito
    </div>
    
    <div class="cart">
        <div class="cart-wrapper">
            <header>
                <h2> Carrito de Compras - <small>Precios con IVA</small></h2>
            </header>
            <div class="item-list"><br/><br/>
                <center>
                    Cargando catalogo... <br/>
                    <img height=100 src="{{asset('assets/img/loading.gif')}}">
                </center>
                <!-- items and footer button inserted in here-->
            </div>
        </div>
    </div>
    
</div>

<script>
    // good jquery practices on dom ready
    // IIFE - Immediately Invoked Function Expression
    (function(yourcode) {
        yourcode(window.jQuery, window, document);
    } (function($, window, document) {
        $(function() {
        // The DOM is ready!
        });
        
        var cart = $('.cart-container');
        var cartTrigger = $('.cart-circle');
        var cartItemNumber = $('.cart-articles-no');
        var cartItemsContainer = $('.item-list');
        var deleteBtn = $('a.delete');
        
        function showCartItems() {
            return $.ajax({
                url: "/cart/show",
                type: "get",
                success: function(data) {
                    
                    cartItemsContainer.html(data.view);
                    /// do this in case a product is deleted while the user has it on his cart
                    
                    if(data.itemsQuantity == 0)
                    {
                        cartItemNumber.html(0); 
                        cart.removeClass('open-cart').delay(500).queue(function(){
                            $(this).addClass('empty-cart').dequeue();
                        });
                    }
                    else
                        cartItemNumber.html(data.itemsQuantity); 
                }
            });
        }
        
        // btw: This is a laravel if(), not a javascript if()
        @if( count( session()->get('cartItems') ) == 0 )
        cart.addClass('empty-cart');
        @endif
        
        cartTrigger.click(function() {
            cart.toggleClass('open-cart');
            showCartItems();
        });
        
        
        
    }
    ));
  
</script>

