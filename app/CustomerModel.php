<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table='customer';

    public function multi_tel(){
        return $this->hasMany('App\CustomerMultiTelModel','cus_id','id');
    }

    public function invoice(){
        return $this->hasMany('App\InvoiceModel','cus_id','id');
    }

    public function vehicle(){
        return $this->belongsTo('App\VehicleModel','id','cus_id');
    }
}
