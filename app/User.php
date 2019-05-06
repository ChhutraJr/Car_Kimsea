<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\RoleModel','role_id','id');
    }

   /* public function unreadNotificationsByType()
    {
        // Return sorted notifications
        return $this -> morphMany(DatabaseNotification::class, "notifiable")
            -> whereNull("read_at")
            -> orderBy("type", "asc")
            -> orderBy("created_at", "desc");
    }*/
}
