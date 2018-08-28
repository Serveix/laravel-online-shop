<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderStatusCode;
use App\StoreSetting;
use Illuminate\Support\Facades\Auth;
use Openpay;


class OrderController extends Controller
{

    function showActive() {
    	
    	$user = Auth::user();

    	$orders = $user->orders()->active()->get();


    	return view('profile.orders.all')
    			->with('orders', $orders)
    			->with('ordersType', 'activo');
    }

    function showCompleted() {
        $user = Auth::user();
        
        $orders = $user->orders()->completed()->get();

		return view('profile.orders.all')
                ->with('orders', $orders)
                ->with('ordersType', 'completado');
    }

    function showOrder(Order $order) {
        $user = Auth::user();

        $orderBelongsToUser = false;
        foreach($user->orders as $currentOrder)
        {
            if($order->id == $currentOrder->id)
            {
                $orderBelongsToUser = true;
                break;
            }
        }

        if( ! $orderBelongsToUser) {
            return redirect()->route('profile');
        }


        $orderStatusCodes = OrderStatusCode::all();

        switch( $order->invoice->payment->method->id ) {

            case 1: // pago con tarjeta
                return view('profile.orders.show')
                    ->with('order', $order)
                    ->with('orderStatusCodes', $orderStatusCodes) ;
                break;

            case 2: //pago en banco
                return view('profile.orders.show')
                        ->with('order', $order)
                        ->with('orderStatusCodes', $orderStatusCodes)
                        ->with('bankInfo', ['bank'     => StoreSetting::find('bank')->value,
                                        'titular'  => StoreSetting::find('titular')->value,
                                        'clabe'    => StoreSetting::find('clabe')->value,
                                        'sucursal' => StoreSetting::find('sucursal')->value,
                                        'cuenta'   => StoreSetting::find('cuenta')->value ] );
                break;

            case 3: // pagos en tiendas
                
                try {
            
                    // HARDCODE: merchant-id and private ke
                    $openpay = Openpay::getInstance('..merchant-id..', '.. privatekey..');
                    
                    $customer = $openpay->customers->get( $user->external_id );
                    $charge = $customer->charges->get($order->invoice->payment->transaction_info);
                    
                    $paymentPdfURL = StoreSetting::find('openpay_dashboard_path')->value . '/paynet-pdf/' . 
                                    StoreSetting::find('merchant_id')->value. '/' .
                                    $charge->payment_method->reference ;

                    return view('profile.orders.show')
                            ->with('order', $order)
                            ->with('orderStatusCodes', $orderStatusCodes)
                            ->with('paymentPdfURL', $paymentPdfURL);

                } catch (\Exception $e) {
                    Log::info('Excepcion en OrderController.php:80 - ' . $e);
                    return 'Se produjo un error desconocido al abrir la orden. Si es posible, contacte a soporte para 
                    arreglar este inconveniente.';
                }
                
            break;

            case 4: // aun no hay pagos contra entrega
                break;

            case 5: //pagos con paypal
                return view('profile.orders.show')
                    ->with('order', $order)
                    ->with('orderStatusCodes', $orderStatusCodes) ;
            break;
        }
         

    }
}
