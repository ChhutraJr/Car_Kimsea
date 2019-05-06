<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table='vehicle';

    public function model(){
        return $this->belongsTo('App\VehicleModelModel','model_id','id');
    }

    public function color(){
        return $this->belongsTo('App\VehicleColorModel','color_id','id');
    }

}
