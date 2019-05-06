<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategoryModel extends Model
{
    protected $table='expense_category';

    public function expense(){
        return $this->hasMany('App\ExpenseModel','cat_id','id');
    }
}
