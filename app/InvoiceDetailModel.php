<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetailModel extends Model
{
    protected $table='invoice_detail';

    public function pro(){
        return $this->belongsTo('App\ProductModel','pro_id','id');
    }

    public function invoice(){
        return $this->belongsTo('App\InvoiceModel','invoice_id','id');
    }

}
