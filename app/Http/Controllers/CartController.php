<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Inserts item IDs in the cartItems session and returns the number of items in it
     * 
     * @param Request
     * @return int
     */
    function newItem(Request $request) {
        $itemId = $request->input('itemId');
        
        if($itemId == null)
            return '<strong>&iquest;Error desconocido!</strong> El producto intentando agregar es invalido.';
            
        if( ! $request->session()->exists('cartItems') )
            return '<strong>Error al agregar el producto: </strong> La sesion no existe. Por favor, actualice la pagina. (F5)';
        
        $allItemIds = $request->session()->get('cartItems');
        $item = Product::find($itemId);
        
        if( $item == null )
            return '<strong>Error al agregar el producto: </strong> El producto ya no existe. Por favor, reinicie la pagina. (F5)';
        
        if( in_array($itemId, $allItemIds) )
            $quantity = array_count_values($allItemIds)[$itemId];
        else
            $quantity = 0;
            
        if($quantity < $item->in_stock )
        {
            $request->session()->push('cartItems', $itemId);
            return count($request->session()->get('cartItems'));
        }
        else
            return 'Solo hay ' . $item->in_stock . ' de este producto en disponibilidad';
        
    }
    
    /**
     * Returns view with rendered cart items and items quantity 
     * @param Request
     * @return object[] [String $view, int $itemsQuantity]
     */
    function showItems(Request $request) {
        $returnable;
        
        if( ! $request->session()->exists('cartItems') )
            $returnable = 'Ocurrio un error al cargar los productos en el carrito. Por favor, reinicia la pagina. (f5)';
        
        
        
        /* Foreach loop goes through cartItemIds array and uses it to create
        a new multidimensional array containing 2 things per index, the product
        model and the quantity added to cart. Ej:
        $cartItems = 
        [ 0 => ['product'  => Product::find(1),
                'quantity' => 2 ],
          1 => ['product'  => Product::find(2),
                'quantity  => 3'] ] 
        */
        foreach($request->session()->get('cartItems') as $key=>$cartItemId)
        {
            $itemQuantity = array_count_values($request->session()->get('cartItems'));

            if($currentItem = Product::cartItemDetailsOnly($cartItemId) )
            {
                if( $currentItem->in_stock >= $itemQuantity[$cartItemId] )
                    $quantity = $itemQuantity[$cartItemId];
                else {
                    $quantity = $currentItem->in_stock;
                    
                    $toForgetItems = $itemQuantity[$cartItemId] - $currentItem->in_stock;
                    for($i = 0; $i < $toForgetItems ; $i++)
                    {
                        foreach($request->session()->get('cartItems') as $key=>$cartItem)
                        {
                            if($cartItem == $currentItem->id) {
                                $request->session()->forget('cartItems.' . $key);
                                break;
                            }
                        }
                    }
                    
                }
                
                
                if($quantity > 0)
                {
                    /// using "$currentItem->cartItemDetailsOnly" we get only the id, name, price
                    /// cause those are the only details we need in the cart
                    $itemAndQuantity = ['product'     => $currentItem, 
                                        'quantity' =>  $quantity];
                
                    if(empty($cartItems))
                        $cartItems[0] = $itemAndQuantity;
                    else 
                    {
                        $containsItemAlready = false;
                        
                        for($i = 0; $i < count($cartItems) ; $i++ )
                        {
                            if( $cartItems[$i]['product']->id == $currentItem->id ) {
                                // Log::info('El producto ya existe en el array');
                                $containsItemAlready = true;
                                break;
                            }
                        }
                        
                        if( ! $containsItemAlready ) // if doesnt
                            $cartItems[ count($cartItems) ] = $itemAndQuantity; // like pushing an array into the array
                    } 
                }
            }
            else
                $request->session()->forget('cartItems.' . $key);
            
        }
        
        
        if(empty($cartItems))
            $view = '[EMPTY-CART] Ocurrio un error al cargar los productos en el carrito. Por favor, reinicia la pagina. (f5)';
        else
            $view = view('cart-items')->with('cartItems', $cartItems)->render();
        
        
        $returnable = [ 'view'          => $view,
                        'itemsQuantity' => count( $request->session()->get('cartItems') )  ];
        
        return $returnable;
    }
    
    
    /**
     * Deletes item from cart
     * @param Request
     * @return int
     */
    function deleteItem(Request $request) {
        $itemId = $request->input('itemId');
        if( ! $request->session()->exists('cartItems') ) 
            return 'Error al borrar el producto. No existe la sesion. Por favor, presiona actualizar y reinicia la pagina. (f5)';
        
        
        $productIds = $request->session()->get('cartItems');
        
        if( ! in_array($itemId, $productIds) )
            return 'Error al borrar el producto. Ya fue borrado. Por favor, presiona actualizar y reinicia la pagina. (f5)';
        
        foreach($productIds as $key=>$productId)
        {
            if($productId == $itemId) {
                $request->session()->forget('cartItems.' . $key);
            }
        }
        
        return count($request->session()->get('cartItems'));
    }
    
    /**
     * Updates the quantity of items in cart
     * @param Request
     * @return int
     */
    function updateQuantityOfItems(Request $request)
    {
        $itemId      = $request->input('itemId');
        $newQuantity = $request->input('newQuantity');
        
        if( ! $request->session()->exists('cartItems') ) 
            return 'Error al borrar el producto. No existe la sesion. Por favor, presiona actualizar y reinicia la pagina. (f5)';
        
        $productIds = $request->session()->get('cartItems');
        $everyItemQuantity = array_count_values($productIds);
        
        if( ! in_array($itemId, $productIds) ) 
            return 'Error al borrar el producto. Ya fue borrado. Por favor, presiona actualizar y reinicia la pagina. (f5)';
        
        $currentQuantity = $everyItemQuantity[$itemId];
        $quantityDifference = abs($currentQuantity - $newQuantity);
        
        for($i = 0; $i < $quantityDifference; $i++)
        {
            foreach($request->session()->get('cartItems') as $key=>$productId)
            {
                if($itemId == $productId)
                {
                    if($currentQuantity < $newQuantity) // needs more
                        $request->session()->push('cartItems', $itemId);
                    else // needs less, cant really be equal cause then for() wouldnt run
                        $request->session()->forget('cartItems.' . $key);
                        
                    break; //this ensures only one ID is added/deleted by breaking out of foreach()
                }
            }
            
        }
        
        return count($request->session()->get('cartItems')); 
    }
    
    
    
    
}
