<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function achievement(){
        return $this->belongsTo('App\Achievement');
    }
    public static function can_user_comment($id){
        if (Auth::guest()){
            return false;
        }
        return true;
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }

}
