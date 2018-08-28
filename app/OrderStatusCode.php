<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusCode extends Model
{
	// 1 = procesando: se esta esperando a que alguien confirme de recibido el pago
	// 2 = confirmada: ya se confirmo de recibido el pago y se esta llevando a cabo el envio
	// 3 = en entrega
	// 4 = completada
    public function orders() {
        return $this->hasMany('App\Order', 'order_status_code');
    }

    


}
