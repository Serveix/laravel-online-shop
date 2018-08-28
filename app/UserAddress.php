<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'address_type', 'street_address1', 'street_address2', 'state', 'city', 'postal_code', 'indiations'
        ];
    
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    //envio
    public function scopeShipping($query) {
        return $query->where('address_type', '=', 1);
    }
    
    // facturacion
    public function scopeBilling($query) {
        return $query->where('address_type', '=', 2);
    }
    
    public function scopeFromMty($query) {
        $city = $query->first()->city;
        
        return  $city == 'Apodaca' ||
                $city == 'Cadereyta Jimenez' ||
                $city == 'Gral. Escobedo' ||
                $city == 'Garcia' ||
                $city == 'Guadalupe' ||
                $city == 'Juarez' ||
                $city == 'Monterrey' ||
                $city == 'Salinas Victoria' ||
                $city == 'San Nicolas de los Garza' ||
                $city == 'San Pedro Garza Garcia' ||
                $city == 'Santa Catarina' ||
                $city == 'Santiago';
            
    } 
    
}
