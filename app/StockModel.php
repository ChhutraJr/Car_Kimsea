<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table='stock';

    function products(){
        return $this->belongsTo('ProductModel','pro_id','id');
    }
}
