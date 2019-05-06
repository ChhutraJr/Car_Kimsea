<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetailModel extends Model
{
    protected $table="purchase_detail";

    public function pro(){
        return $this->belongsTo('App\ProductModel','pro_id','id');
    }
}
