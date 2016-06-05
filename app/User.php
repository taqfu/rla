<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Config;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function does_user_have_unread_msgs(){
        if (Auth::guest()){
            return false;
        }
        $num_of_unread_msgs = count(Message::where('to_user_id', Auth::user()->id)->where('read', false)->get());
        return $num_of_unread_msgs>0;
    }

    public static function local_time($timezone, $timestamp){
      date_default_timezone_set($timezone);
      $timezone = date("Z");
      date_default_timezone_set(Config::get('app.timezone'));
      return $timestamp + $timezone;

    }
}
