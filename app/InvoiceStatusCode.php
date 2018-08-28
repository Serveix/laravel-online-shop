<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatusCode extends Model
{
    public function invoices() {
        return $this->hasMany('App\Invoice', 'invoice_status_code');
    }
}
