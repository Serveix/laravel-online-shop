<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserAddress;
use Illuminate\Support\Facades\Log;
use Validator;

class UserController extends Controller
{
    function showProfile() {
        
        $user = Auth::user();
        return view('profile.profile')->with( 'user_info', $user ); 
    }
    
    function showShippingAddress(Request $request) {
        $user = Auth::user();
        
        if($request->session()->get('comingFromCheckout')) {
            Log::info('comingFromcheckout set, setting checkoutprocess');
            $request->session()->put('checkoutProcess', true);
        }
        return view('profile.shippingAddress')->with( 's_address', $user->addresses()->shipping()->first() ); 
    }
    
    function editShippingAddress(Request $request) {
        $validator = Validator::make($request->all(), [
            'direccion1' => 'required|max:150',
            'direccion2' => 'max:150',
            'estado' => 'required|max:150',
            'municipio' => 'required|max:150',
            'codigoPostal' => 'required|max:150',
            'indicaciones' => 'max:150'
        ]);
        
         if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        
        $currentUser = Auth::user();
        
        
        if($currentUser->addresses()->shipping()->first() == null) {
            $newAddress = new UserAddress(['address_type'   => 1,
                                        'street_address1'   => $request->input('direccion1'),
                                        'street_address2'   => $request->input('direccion2'),
                                        'state'             => $request->input('estado'),
                                        'city'              => $request->input('municipio'),
                                        'postal_code'       => $request->input('codigoPostal'),
                                        'indications'       => $request->input('indicaciones') ]);
            $currentUser->addresses()->save($newAddress);
        }
        else
            $currentUser->addresses()->shipping()->update([
                                'street_address1'   => $request->input('direccion1'),
                                'street_address2'   => $request->input('direccion2'),
                                'state'             => $request->input('estado'),
                                'city'              => $request->input('municipio'),
                                'postal_code'       => $request->input('codigoPostal'),
                                'indications'       => $request->input('indicaciones') ]);
        
        
        if($request->session()->has('checkoutProcess'))
        {
            Log::info('session checkoutprocess has' . $request->session()->get('checkoutProcess'));
            $request->session()->forget('checkoutProcess');
            return redirect()->route('checkout');
        }
        
        return back()->with('addressUpdated', true);
        
    }
    
    function showBillingAddress() {
        $user = Auth::user();
        return view('profile.billingAddress')->with( 'b_address', $user->addresses()->billing()->first() ); 
    }
    
    function editBillingAddress(Request $request) {
        $validator = Validator::make($request->all(), [
            'direccion1' => 'required|max:150',
            'direccion2' => 'max:150',
            'estado' => 'required|max:150',
            'municipio' => 'required|max:150',
            'codigoPostal' => 'required|max:150',
            'indicaciones' => 'max:150'
        ]);
        
        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        
        $currentUser = Auth::user();
        
        
        if($currentUser->addresses()->billing()->first() == null) {
            $newAddress = new UserAddress(['address_type'   => 2,
                                        'street_address1'   => $request->input('direccion1'),
                                        'street_address2'   => $request->input('direccion2'),
                                        'state'             => $request->input('estado'),
                                        'city'              => $request->input('municipio'),
                                        'postal_code'       => $request->input('codigoPostal'),
                                        'indications'       => $request->input('indicaciones') ]);
            $currentUser->addresses()->save($newAddress);
        }
        else
            $currentUser->addresses()->billing()->update([
                                'street_address1'   => $request->input('direccion1'),
                                'street_address2'   => $request->input('direccion2'),
                                'state'             => $request->input('estado'),
                                'city'              => $request->input('municipio'),
                                'postal_code'       => $request->input('codigoPostal'),
                                'indications'       => $request->input('indicaciones') ]);
        
        
        return back()->with('addressUpdated', true);
        
    }
    
    
}
