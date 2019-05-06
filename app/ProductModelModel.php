<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModelModel extends Model
{
    protected $table='product_model';

    public function product(){
        return $this->hasMany('App\ProductModel','model_id','id');
    }
}
