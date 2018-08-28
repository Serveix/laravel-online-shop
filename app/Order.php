<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['order_status_code', 'details'];
	// ORDER STATUS CODES
	// 1 = procesando: se esta esperando a que alguien confirme de recibido el pago
    // 2 = confirmada: ya se confirmo de recibido el pago y se esta llevando a cabo el envio
    // 3 = en entrega
    // 4 = completada
    


    public function fromUser() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function products() {
        return $this->belongsToMany('App\Product', 'order_product')
                    ->withPivot('product_quantity','product_price');
    }

    public function statusCode() {
        return $this->belongsTo('App\OrderStatusCode', 'order_status_code');
    }

    public function invoice() {
        return $this->hasOne('App\Invoice', 'order_id');
    }

    public function shippment() {
        return $this->hasOne('App\Shippment', 'order_id');
    }


    public function scopeActive($query) {
        return $query->where('order_status_code', '<', 4);
    }

    public function scopeCompleted($query) {
        return $query->where('order_status_code', '>', 3);
    }


}
