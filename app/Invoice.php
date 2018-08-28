<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $fillable = ['order_id', 'invoice_status_code', 'invoice_date', 'invoice_details', 'address'];
    public $timestamps = false;
    
    public function order() {
    	return $this->belongsTo('App\Order', 'order_id');
    }


	public function statusCode() {
        return $this->belongsTo('App\InvoiceStatusCode', 'invoice_status_code');
    }

    function shippment() {
    	return $this->hasOne('App\Shippment', 'invoice_id');
    }

    function payment() {
    	return $this->hasOne('App\Payment', 'invoice_id');
    }
}
