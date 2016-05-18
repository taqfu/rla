<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DateInterval;
use DateTime;
class Proof extends Model
{
    public function achievement(){
        return $this->belongsTo("\App\Achievement");
    }
    public static function can_user_vote($id){
        if (Auth::guest()){
            return false;
        }
        $num_of_votes = count(Vote::where ('proof_id', $id)->where('user_id', Auth::user()->id)->get());
        if ($num_of_votes>0){
            if ($num_of_votes>1){
                //ERROR - user should not have more than one vote.
            }
            return false;
        }
        return true;
        
    }
    public static function max_time_to_vote($id){
        $proof = Proof::where ("id", $id)->first();
        $begin = new DateTime($proof->created_at);
        $end = clone $begin;
        $end->add(new DateInterval('P1W'));
        $now = new DateTime(date('y-m-d H:i:s'));
        $interval = $now->diff($end);
        $end_date = $end->format('y-m-d H:i:s');
        
        if ($interval->d>0){
            $caption = $interval->d>1 ? " days" : " day";
            return $interval->d . $caption;
        }
        if ($interval->h>0){
            $caption = $interval->h>1 ? " hours" : " hour";
            return $interval->h .  $caption;

        }
        if ($interval->i>0){
            $caption = $interval->i>1 ? " minutes" : " minute";
            return $interval->i .  $caption;

        }
        $caption = $interval->s>1 ? " seconds" : " second";
        return $interval->s .  $caption;
        
    }
    public static function min_time_to_vote($id){
        $string = "";
        $last_vote = Vote::where ("proof_id", $id)->orderBy('created_at', 'desc')->first();
        $begin = new DateTime($last_vote->created_at);
        $end = clone $begin;
        $end->add(new DateInterval('P1D'));
        $now = new DateTime(date('y-m-d H:i:s'));
        $interval = $now->diff($end);
        if ($interval->d>0){
            $caption = $interval->d>1 ? " days" : " day";
            return $interval->d . $caption;
        }
        if ($interval->h>0){
            $caption = $interval->h>1 ? " hours" : " hour";
            return $interval->h .  $caption;

        }
        if ($interval->i>0){
            $caption = $interval->i>1 ? " minutes" : " minute";
            return $interval->i .  $caption;

        }
        $caption = $interval->s>1 ? " seconds" : " second";
        return $interval->s .  $caption;

        
    }
    public static function passing_approval($id){
            $votes_for = count(Vote::where('proof_id', $id)->where('vote_for', true)->get());
            $votes_against = count(Vote::where('proof_id', $id)->where('vote_for', false)->get());
            if ($votes_for - $votes_against <= 0){
                return false;
            } else if ($votes_for - $votes_against > 0){
                return true;
            }
    }
    public function user(){
        return $this->belongsTo("\App\User");
    }

    public function vote(){
        return $this->hasOne("\App\Vote");
    }
    //
}
