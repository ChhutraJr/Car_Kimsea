<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceMultiSellerModel extends Model
{
    protected $table='invoice_multi_seller';

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
