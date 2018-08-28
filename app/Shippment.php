<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shippment extends Model
{
    protected $fillable = ['tracking_number', 'date', 'details', 'address', 'price'];
    public $timestamps = false;
    
    function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    function invoice() {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }

    function method() {
    	return $this->belongsTo('App\ShippmentMethod', 'shippment_method_id');
    }

}
