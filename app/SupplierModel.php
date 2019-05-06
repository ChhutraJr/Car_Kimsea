<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table='supplier';

    public function product(){
        return $this->hasMany('App\ProductModel','supplier_id','id');
    }
}
