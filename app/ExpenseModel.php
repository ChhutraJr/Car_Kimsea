<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    protected $table='expense';

    public function cat(){
        return $this->belongsTo('App\ExpenseCategoryModel','cat_id','id');
    }
}
