<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceMultiMechanicModel extends Model
{
    protected $table='invoice_multi_mechanic';

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
