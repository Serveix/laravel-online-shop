<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payment_date', 'payment_amount', 'transaction_info'];
    public $timestamps = false;
    
    function invoice() {
    	return $this->belongsTo('App\Invoice', 'invoice_id');
    }

    function method() {
    	return $this->belongsTo('App\PaymentMethod', 'payment_method_id');
    }
}
