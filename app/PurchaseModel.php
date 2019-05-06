<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    protected $table="purchase";

    public function sup(){
        return $this->belongsTo('App\SupplierModel','supplier_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function detail(){
        return $this->hasMany('App\PurchaseDetailModel','purchase_id','id');
    }
}
