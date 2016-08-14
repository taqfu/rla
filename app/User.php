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
    
    public static function fetch_achievement_data($achievement_id){
        $subscribed =0;
        $user_claim = null;
        $user_goal = null;
        $user_proof = null;
        if (Auth::user()){
            $user_claim = Claim::where('user_id', Auth::user()->id)->whereNull('canceled_at')
              ->where('achievement_id', $achievement_id)->first();
            $user_goal = Goal::where('user_id', Auth::user()->id)->whereNull('canceled_at')
              ->where('achievement_id', $achievement_id)->first();
            $user_proof = Proof::where('user_id', Auth::user()->id)->where('status', '1')
              ->where('achievement_id', $achievement_id)->first();
            $subscribed=count(Follow::where('user_id', Auth::user()->id)
              ->where('achievement_id', $achievement_id)->get())>0;
        }
        return ["claim"=>$user_claim, "goal"=>$user_goal, "proof"=>$user_proof, 
          "subscribed"=>$subscribed];

    }

    public static function local_time($timezone, $timestamp){
      date_default_timezone_set($timezone);
      $timezone = date("Z");
      date_default_timezone_set(Config::get('app.timezone'));
      return $timestamp + $timezone;

    }
}
