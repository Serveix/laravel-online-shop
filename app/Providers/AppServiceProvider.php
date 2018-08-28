<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $client = new Client();
    
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                ['verify' => false,
                'form_params'=>
                    [
                        'secret'=>env('GOOGLE_RECAPTCHA_SECRET'),
                        'response'=>$value
                     ]
                ]
            );
        
            $body = json_decode((string)$response->getBody());
            return $body->success;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
