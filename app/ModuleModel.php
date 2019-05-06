<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    protected $table='module';

    public function sub(){
        return $this->hasMany('App\SubModuleModel','module_id','id');
    }
}
