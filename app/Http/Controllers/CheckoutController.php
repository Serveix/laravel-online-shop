<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\StoreSetting;
use App\Order;
use App\OrderStatusCode;
use App\Invoice;
use App\InvoiceStatusCode;
use App\Payment;
use App\Shippment;
use App\ShippmentMethod;
use App\PaymentMethod;
use Carbon\Carbon;
use Openpay;
use App\Product;
use Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // GET method route checkout
    public function showCheckout(Request $request) {
        $user = Auth::user();
        
        if( ($request->session()->has('cartItems') && count($request->session()->get('cartItems')) < 1) ||
            !$request->session()->has('cartItems'))
            return redirect('/');
        
        $shippingAddress    = $user->addresses()->shipping()->first();
        $billingAddress     = $user->addresses()->billing()->first();
        
        if( !$shippingAddress )
            return redirect()->route('shipping-address')->with('comingFromCheckout', true);
        
        $products = array();
        foreach( $request->session()->get('cartItems') as $item)
        {
            $product = Product::find($item);
            
            if($product != null)
            {
                if(empty($products)) {
                    $products = [[  'id'       => $product->id,
                                    'name'     => $product->name, 
                                    'price'    => $product->finalPriceNoIva(),
                                    'quantity' => 1 ]];

                    $finalPrice = $product->finalPriceNoIva();
                    
                    
                }
                else
                {
                    $checked = false;
                    foreach($products as $key=>$check)
                    {
                        if($check['id'] == $product->id){
                            $products[$key]['quantity'] = $check['quantity'] + 1;
                            $checked = true;
                            $finalPrice += $product->finalPriceNoIva();
                            break;
                        }
                    }
                    
                    if(!$checked) {
                        array_push($products, [ 'id'       => $product->id,
                                                'name'     => $product->name, 
                                                'price'    => $product->finalPriceNoIva(),
                                                'quantity' => 1 ]);

                        $finalPrice += $product->finalPriceNoIva();
                    }
                } 
                    
            }
        }
        
        $shippmentMethods = ShippmentMethod::all();
        $paymentMethods = PaymentMethod::all();
        
        $request->session()->put('final-order', $products);
        
        return view('checkout.order')
                ->with('shippingAddress', $shippingAddress)
                ->with('billingAddress', $billingAddress)
                ->with('shippmentMethods', $shippmentMethods)
                ->with('paymentMethods', $paymentMethods)
                ->with('orderProducts', $products)
                ->with('finalPrice', $finalPrice)
                ->with('iva', StoreSetting::find('iva_value')->value / 100);
    }
    
    // post method on checkout confirmation
    public function confirmCheckout(Request $request) {
        
        // not sure this could be violated, but just in case
        if(!$request->session()->has('final-order'))
            return redirect()->route('checkout');
        
        $validator = Validator::make($request->all(), [
            'telefono' => 'required|digits:10',
            'detalles' => 'max:100',
            'g-recaptcha-response' => 'required|recaptcha',
            ]);

        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $products = $request->session()->get('final-order');
        
        foreach($products as $product)
        {
            $dbProduct = Product::find($product['id']);
            
            if($dbProduct == null)
                return back()->with('NotExistingProduct')->withInput();
            
            if( $dbProduct->finalPriceNoIva() != $product['price'])
                return back()->with('itemPriceChanged', '<strong>ALERTA!</strong> Mientras verificabas los articulos, el producto ' . $product['name'] . ' cambio de precio a $' . $dbProduct->price)->withInput();
                
            if( $dbProduct->in_stock < $product['quantity'])
                return back()->with('itemOutOfStock', 
                '<strong>ALERTA!</strong> Mientras verificabas los articulos, se vendieron algunos productos. 
                Del producto: ' . $product['name'] . ' solo quedan ' . $dbProduct->in_stock . ' en stock.
                <strong> Corrigelo en tu carrito y vuelve a presionar "Checkout" </strong>')->withInput();
                
        }

        $user = Auth::user();

        $shippmentMethod    = ShippmentMethod::find($request->input('shippment-method')); 
        $paymentMethod      = PaymentMethod::find($request->input('payment-method'));
        $totalPrice         = $request->input('total-price');
        $shippmentPrice     = $shippmentMethod->price;
        $phone              = $request->input('telefono');
        $details            = $request->input('detalles');
        $billingOption      = $request->input('billing-options');


        $orderInfo = [  'products'          => $products,
                        'billingOption'     => $billingOption,
                        'shippmentMethod'   => $shippmentMethod,
                        'paymentMethod'     => $paymentMethod,
                        'totalPrice'        => $totalPrice,
                        'shippmentPrice'    => $shippmentPrice,
                        'phone'             => $phone,
                        'details'           => $details ];


        $request->session()->put('orderInfo', $orderInfo);
        return redirect()->route('checkout-payment');

    }

    //GET METHOD for paying
    public function payOrder(Request $request)
    {
        if(!$request->session()->has('orderInfo'))
            return redirect()->route('checkout');

        $orderInfo = $request->session()->get('orderInfo');
        $paymentMethodId = $orderInfo['paymentMethod']->id;

        switch($paymentMethodId)
        {
            case 1: // card payment
                return view('checkout.card')->with('orderInfo', $orderInfo);
            break;
            
            case 2: // bank payment
                return $this->bankPaymentConfirmation($request, $orderInfo);
            break;
            
            case 3: // tiendas de conveniencia
                return $this->storesPaymentConfirmation($request, $orderInfo);
            break;
            
            case 4: // pago contra entrega
            break;

            case 5: //paypal
            	return view('checkout.paypal')->with('orderInfo', $orderInfo);
            break;
        }
        
    }

    private function getErrorTranslated( $errorId ) {
        switch( $errorId ) {
            case 1000:
                return 'Error en el servidor de Openpay';
                break;
            case 1001:
                return 'El formato JSON no es correcto';
                break;
            case 1002:
                return 'La authenticacion no es correcta.';
                break;
            case 1003:
                return 'Uno o mas de los parametros no es correcto.';
                break;
            case 1004:
                return 'Servicio de procesamiento no se encuentra disponible.';
                break;
            case 1005:
                return 'Uno de los recursos requeridos no existe.';
                break;
            case 1006:
                return 'Ya existe una transaccion con el mismo ID';
                break;
            case 1007:
                return 'La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada.';
                break;
            case 1008:
                return 'Una de las cuentas requeridas en la petición se encuentra desactivada.';
                break;
            case 1009:
                return 'El cuerpo de la petición es demasiado grande.';
                break;
            case 1010:
                return 'Se esta utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se esta usando la llave privada desde JavaScript.';
                break;
            case 3001: 
                return 'La tarjeta ha sido rechazada.';
            break;
            case 3002:
                return 'La tarjeta ha expirado.';
            break;
            case 3003:
                return 'La tarjeta no tiene suficientes fondos.'; 
            break;
            case 3004:
                return 'La tarjeta ha sido identificada como robada.'; 
            break;
            case 3005:
                return 'La tarjeta ha sido identificada como fraudulenta.'; 
            break;
            case 4001:
                return 'La cuenta openpay no tiene fondos suficientes';
                break;
            default:
                return 'Ocurri&oacute; un error desconocido.';
        }
    }

    private function bankPaymentConfirmation($request, $orderInfo)
    {
        if(!$request->session()->has('orderInfo'))
            return redirect()->route('checkout');
        
        $orderInfo = $request->session()->get('orderInfo');
        $user = Auth::user();
        $bankInfo = [ 'bank'     => StoreSetting::find('bank')->value,
                      'titular'  => StoreSetting::find('titular')->value,
                      'clabe'    => StoreSetting::find('clabe')->value,
                      'sucursal' => StoreSetting::find('sucursal')->value,
                      'cuenta'   => StoreSetting::find('cuenta')->value ];

        $billingAddress = ($orderInfo['billingOption'] == 1) ? $user->addresses()->shipping()->first() : $user->addresses()->billing()->first();
        
        $shippingAddress = $user->addresses()->shipping()->first();

        $order = $this->createCompleteOrder($request, $orderInfo, $user, $shippingAddress, $billingAddress, 'Pago en banco');

        return view('checkout.bank')->with('order', $order)
                                    ->with('bankInfo', $bankInfo);
    }

    // post method works with openPay to confirm 
    public function cardPaymentConfirmation(Request $request)
    {
        if(!$request->session()->has('orderInfo'))
            return redirect()->route('checkout');
        
        $orderInfo = $request->session()->get('orderInfo');
        $user = Auth::user();

        $billingAddress = ($orderInfo['billingOption'] == 1) ? $user->addresses()->shipping()->first() : $user->addresses()->billing()->first();
        
        $shippingAddress = $user->addresses()->shipping()->first();
        // OPEN PAY API
        try {
            // HARDCODE: merchant-id and private ke
            $openpay = Openpay::getInstance('..merchant-id..', '.. privatekey..');

            $customerData = array(
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $orderInfo['phone'],
                'address' => array(
                        'line1' => $billingAddress->street_address1,
                        'line2' => $billingAddress->street_address2,
                        'postal_code' => $billingAddress->postal_code,
                        'state' => $billingAddress->state,
                        'city' => $billingAddress->city,
                        'country_code' => 'MX'));
            

            $chargeData = array(
                'method' => 'card',
                'source_id' => $request->input('token_id'),
                'amount' => number_format($orderInfo['totalPrice'] + $orderInfo['shippmentPrice'], 2, '.', ''),
                'description' => 'Compra de articulos',
                // 'use_card_points' => $_POST["use_card_points"], // Opcional, si estamos usando puntos
                'device_session_id' => $request->input('deviceIdHiddenFieldName'),
                'customer' => $customerData
                );
            

            $charge = $openpay->charges->create($chargeData);

        } catch (\OpenpayApiTransactionError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR on the transaction: ' . $e->getMessage() . 
                  ' [error code: ' . $e->getErrorCode() . 
                  ', error category: ' . $e->getCategory() . 
                  ', HTTP code: '. $e->getHttpCode() . 
                  ', request ID: ' . $e->getRequestId() . ']');

            return back()->with('card-errors', $this->getErrorTranslated($e->getErrorCode()) );

        } catch (\OpenpayApiRequestError $e) {
            Log::info('['.$e->getErrorCode().'] Error on the request'. $e->getMessage());
            return back()->with('card-errors', $this->getErrorTranslated($e->getErrorCode()) );

        } catch (\OpenpayApiConnectionError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR while connecting to the API: ' . $e->getMessage());
            
            return back()->with('card-errors', $this->getErrorTranslated($e->getErrorCode()) );

        } catch (\OpenpayApiAuthError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR on the authentication: ' . $e->getMessage());

            return back()->with('card-errors', $this->getErrorTranslated($e->getErrorCode()) );
            
        } catch (\OpenpayApiError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR on the API: ' . $e->getMessage());
            
            return back()->with('card-errors', $this->getErrorTranslated($e->getErrorCode()) );
            
        } catch (\Exception $e) {
            Log::info('['.$e->getErrorCode().'] Error on the script: ' . $e->getMessage());

            return back()->with('card-errors', $this->getErrorTranslated($e->getErrorCode()) );
        }
        
        // At this point, payment was successful

        $order = $this->createCompleteOrder($request, $orderInfo, $user, $shippingAddress, $billingAddress, $charge->id);
        

        return redirect()->route('order', ['order' => $order->id]);
        

    } 

    private function storesPaymentConfirmation($request, $orderInfo) {
        $user = Auth::user();
        $billingAddress = ($orderInfo['billingOption'] == 1) ? $user->addresses()->shipping()->first() : $user->addresses()->billing()->first();
        $shippingAddress = $user->addresses()->shipping()->first();

        try {
            
            // HARDCODE: merchant-id and private ke
            $openpay = Openpay::getInstance('..merchant-id..', '.. privatekey..');
            
            $chargeData = array(
                'method' => 'store',
                'amount' => number_format($orderInfo['totalPrice'] + $orderInfo['shippmentPrice'], 2, '.', ''),
                'description' => 'Cargo en tienda de '.$user->name);
            $customer = $openpay->customers->get( $user->external_id );
            $charge = $customer->charges->create($chargeData);

        } catch (\OpenpayApiTransactionError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR on the transaction: ' . $e->getMessage() . 
                  ' [error code: ' . $e->getErrorCode() . 
                  ', error category: ' . $e->getCategory() . 
                  ', HTTP code: '. $e->getHttpCode() . 
                  ', request ID: ' . $e->getRequestId() . ']');

            return back()->with('stores-errors', $this->getErrorTranslated($e->getErrorCode()) );

        } catch (\OpenpayApiRequestError $e) {
            Log::info('['.$e->getErrorCode().'] Error on the request: '. $e->getMessage());
            return back()->with('stores-errors', $this->getErrorTranslated($e->getErrorCode()) );

        } catch (\OpenpayApiConnectionError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR while connecting to the API: ' . $e->getMessage());
            
            return back()->with('stores-errors', $this->getErrorTranslated($e->getErrorCode()) );

        } catch (\OpenpayApiAuthError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR on the authentication: ' . $e->getMessage());

            return back()->with('stores-errors', $this->getErrorTranslated($e->getErrorCode()) );
            
        } catch (\OpenpayApiError $e) {
            Log::info('['.$e->getErrorCode().'] ERROR on the API: ' . $e->getMessage());
            
            return back()->with('stores-errors', $this->getErrorTranslated($e->getErrorCode()) );
            
        } catch (\Exception $e) {
            Log::info('['.$e->getErrorCode().'] Error on the script: ' . $e->getMessage());

            return back()->with('stores-errors', $this->getErrorTranslated($e->getErrorCode()) );
        }

        $order = $this->createCompleteOrder($request, $orderInfo, $user, $shippingAddress, $billingAddress, $charge->id);
        
        return view('checkout.stores')->with('order', $order)
                                      ->with('reference', $charge->payment_method->reference)
                                      ->with('storeSettings', StoreSetting::all() );

    }

    //post only
    public function paypalSuccess(Request $request)
    {

        if(!$request->session()->has('orderInfo'))
            return redirect()->route('checkout');
        
        $orderInfo = $request->session()->get('orderInfo');
        $user = Auth::user();
        $paypalPaymentId = $request->input('paypalPaymentId');

        $billingAddress = ($orderInfo['billingOption'] == 1) ? $user->addresses()->shipping()->first() : $user->addresses()->billing()->first();
        
        $shippingAddress = $user->addresses()->shipping()->first();

        $order = $this->createCompleteOrder($request, $orderInfo, $user, $shippingAddress, $billingAddress, $paypalPaymentId );

        return route('order', ['order' => $order->id]);
    }


    private function createCompleteOrder($request, $orderInfo, $user, $shippingAddress, $billingAddress, $transactionInfo) {
        $order = new Order(['order_status_code' => 1, 
                            'details'           => $orderInfo['details'] ]);
        $user->orders()->save($order);

        foreach($orderInfo['products'] as $product)
        {
            $dbProduct = Product::find($product['id']);


            $order->products()->attach($dbProduct, ['product_quantity' => $product['quantity'], 
                                                    'product_price'    => (double)(str_replace(',','', $product['price'] ))   ]);



            foreach($request->session()->get('cartItems') as $key=>$item)
            {
                if($item == $product['id'])
                    $request->session()->forget('cartItems.'.$key);
            }
        }
        
        $billingAddressToDB = ['street_address1' => $billingAddress->street_address1,
                                'street_address2' => $billingAddress->street_address2,
                                'city'            => $billingAddress->city,
                                'state'           => $billingAddress->state,
                                'postal_code'     => $billingAddress->postal_code,
                                'indications'     => $billingAddress->indications ];

        $invoice = new Invoice(['invoice_status_code' => 1,
                                'invoice_date'        => NULL, // date defined when invoice is confirmed as paid (ISC=2)
                                'invoice_details'     => $orderInfo['details'],
                                'address'             => json_encode($billingAddressToDB) ]);
        $invoice->order()->associate($order);
        $invoice->save();

        $payment = new Payment(['payment_date'     => Carbon::now(),
                                'payment_amount'   => (double)($orderInfo['totalPrice'] + $orderInfo['shippmentPrice']),
                                'transaction_info' =>  $transactionInfo ]);
        
        $payment->invoice()->associate($invoice);
        $payment->method()->associate($orderInfo['paymentMethod']);
        $payment->save();


        $shippingAddressToDB = ['street_address1' => $shippingAddress->street_address1,
                                'street_address2' => $shippingAddress->street_address2,
                                'city'            => $shippingAddress->city,
                                'state'           => $shippingAddress->state,
                                'postal_code'     => $shippingAddress->postal_code,
                                'indications'     => $shippingAddress->indications ];

        $shippment = new Shippment([ 'details' => $orderInfo['details'],
                                     'address' => json_encode($shippingAddressToDB),
                                     'price'   => (double)$orderInfo['shippmentPrice'] ]);

        $shippment->order()->associate($order);
        $shippment->invoice()->associate($invoice);
        $shippment->method()->associate($orderInfo['shippmentMethod']);
        $shippment->save();

        $request->session()->forget('orderInfo');

        return $order;
    }
    
    

}
