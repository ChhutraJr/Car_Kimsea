<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table='role';

    public function pri(){
        return $this->hasMany('App\PrivilegeModel','role_id','id');
    }
}
