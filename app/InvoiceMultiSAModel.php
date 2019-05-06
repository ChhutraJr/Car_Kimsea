<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceMultiSAModel extends Model
{
    protected $table='invoice_multi_sa';

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
