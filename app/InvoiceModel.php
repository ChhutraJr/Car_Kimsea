<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    protected $table='invoice';

    public function pos(){
        return $this->hasMany('App\POSModel','invoice_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function multi_mechanic(){
        return $this->hasMany('App\InvoiceMultiMechanicModel','invoice_id','id');
    }
    public function multi_sa(){
        return $this->hasMany('App\InvoiceMultiSAModel','invoice_id','id');
    }
    public function multi_seller(){
        return $this->hasMany('App\InvoiceMultiSellerModel','invoice_id','id');
    }
    public function detail(){
        return $this->hasMany('App\InvoiceDetailModel','invoice_id','id');
    }

    public function cus(){
        return $this->belongsTo('App\CustomerModel','cus_id','id');
    }
}
