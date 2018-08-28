<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippmentMethod extends Model
{

    function shippments() {
    	return $this->hasMany('App\Shippment', 'shippment_method_id');
    }
}
