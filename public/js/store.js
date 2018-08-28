/// updateCart() adds item to cart-items session by using ajax post
/// returns number of items in cart or a string with an error
/* global jQuery*/
function updateCart( itemId )
{
    return jQuery.ajax({
        url: "/cart/new",
        type: "post",
        data: { 
            itemId: itemId,
        }
    });
}

function deleteItem(itemId) 
{
    return jQuery.ajax({
        url: '/cart/delete',
        type: 'post',
        data: {
            itemId: itemId,
        }
    });
}

function updateQuantityOfItems(itemId, newQuantity) 
{
    return jQuery.ajax({
        url: '/cart/quantity',
        type: 'post',
        data: {
            itemId: itemId,
            newQuantity: newQuantity,
        }
    });
}
