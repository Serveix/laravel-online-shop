<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Log;
use Openpay;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:190',
            'email' => 'required|string|email|max:190|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'external_id' => NULL,
        ]);


        // create also a user in openPay
        try {
            // HARDCODE: merchant-id and private ke
            $openpay = Openpay::getInstance('..merchant-id..', '.. privatekey..');
            
            $customerData = array(
                'external_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'requires_account' => false,
                'phone_number' => NULL,
                'address' => NULL,
            );

            $customer = $openpay->customers->add($customerData);

            //quick edit to local users external_id from null to OPENPAY'S id
            $user->external_id = $customer->id;
            $user->save();

        } catch (\Exception $e) { 
            Log::info($e);
        }

        return $user;
    }
}
