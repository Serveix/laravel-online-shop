<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $primaryKey = 'setting';
    public $incrementing = false;
    
    static function dailyUsdMxn() {
        $get = file_get_contents("https://www.google.com/finance/converter?a=1&from=USD&to=MXN");
    	$get = explode("<span class=bld>",$get);
    	$get = explode("</span>",$get[1]);  
    	return preg_replace("/[^0-9\.]/", null, $get[0]);
    }
}
