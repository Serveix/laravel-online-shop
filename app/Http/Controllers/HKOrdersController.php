<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\OrderStatusCode;
use Carbon\Carbon;

class HKOrdersController extends Controller
{
	//post method
    public function search(Request $request) {
    	$this->validate($request, [
	        'search-input' => 'required',
	    ]);
    	
    	$orderId = $request->input('search-input') - 1000;
    	
    	if(Order::find($orderId) == null) 
    		return back()->with('hkorder-null', true);

    	return redirect()->route('hkorder', ['order' => $orderId]);
    	

    }

    public function showOrder(Order $order) {
    	return view('hk.orders.showOne')
    			->with('order', $order)
    			->with('orderStatusCodes', OrderStatusCode::all());
    }

    public function showActive() {
        $orders = Order::active()->get();
        
        return view('hk.orders.active')
                ->with('orders', $orders)
                ->with('orderStatusCodes', OrderStatusCode::all())
                ->with('today', Carbon::now() )
                ->with('yesterday', Carbon::yesterday() );
    }

    public function showCompleted() {
        $orders = Order::completed()->get();
        
        return view('hk.orders.completed')
                ->with('orders', $orders)
                ->with('orderStatusCodes', OrderStatusCode::all())
                ->with('today', Carbon::now() )
                ->with('yesterday', Carbon::yesterday() );
    }

    public function updateStatus(Request $request) {
        $order      = Order::find($request->input('orderId'));
        $statusCode = $request->input('statusCode');

        if($order == null)
            return '<strong>[Error: 1]</strong> La orden no existe';

        if($order->order_status_code == $statusCode)
            return 'success';

        switch($statusCode) {
            case 1: //procesando 
                $order->order_status_code = 1;
                $order->save();
                break;
            case 2: // confirmado

                $invoice = $order->invoice;

                $order->order_status_code = 2;
                $order->save();

                $invoice->invoice_status_code = 2; // 2 = paid
                $invoice->invoice_date        = Carbon::now();
                $invoice->save();

                foreach($order->products as $product)
                {
                    $newInStock = $product->in_stock - $product->pivot->product_quantity;
                    
                    if($newInStock > 0)
                    {
                        $product->in_stock = $newInStock;
                        $product->save();
                    }
                    else 
                        return '<strong>&iexcl;ALERTA!</strong> &iexcl;Productos fuera de stock!';
                }

                break;
            case 3: // entregando
                $shippment = $order->shippment;

                $order->order_status_code = 3;
                $order->save();
                $shippment->date = Carbon::now();
                $shippment->save();
                break;
            case 4: // completado
                $order->order_status_code = 4;
                $order->save();
                break;
            case 5: // cancelado

                // give back the items in case they were taken from inventory already
                if($order->order_status_code > 1)
                {
                    foreach($order->products as $product) {
                        $product->in_stock = $product->in_stock + $product->pivot->product_quantity;
                        $product->save();
                    }
                }

                $order->order_status_code = 5;
                $order->save();

                return 'cancelled';
                break;

        }

        return 'success';

        
    }

    
}
