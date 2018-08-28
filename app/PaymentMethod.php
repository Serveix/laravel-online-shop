<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    function payments() {
    	return $this->hasMany('App\Payement', 'payment_method_id');
    }
}
