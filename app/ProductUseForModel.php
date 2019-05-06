<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUseForModel extends Model
{
    protected $table='product_use_for';

    public function product(){
        return $this->hasMany('App\ProductModel','cat_id','id');
    }
}
