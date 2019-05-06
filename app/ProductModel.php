<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table='product';

    public function cat(){
        return $this->belongsTo('App\ProductUseForModel','cat_id','id');
    }

    public function stock(){
        return $this->belongsTo('App\StockModel','id','pro_id');
    }

    public function model(){
        return $this->belongsTo('App\ProductModelModel','model_id','id');
    }

    public function detail(){
        return $this->hasMany('App\ProductDetailModel','pro_id','id');
    }
}
