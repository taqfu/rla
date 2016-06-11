<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;
use DateInterval;
use DateTime;
class Proof extends Model
{
    public function achievement(){
        return $this->belongsTo("\App\Achievement");
    }
    public static function can_user_comment($id){
        if (Auth::guest()){
            return false;
        }
        $proof = Proof::where('id', $id)->first();
        $achievement = Achievement::where('id', $proof->achievement->id)->first();
        $num_of_approved_proofs = count(Proof::where('user_id', Auth::user()->id)->where('status', 1)->get());
        if ($proof->user_id == Auth::user()->id || $achievement->user_id==$proof->user_id || $num_of_approved_proofs>0){
            return true;
        }
        return false;
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
    public static function changeStatus($id, $status){
        $achievement = Achievement::find($proof->achievement_id);
        $proof = Proof::find($id);
        if ($status){
            if ($proof->user_id!=$achievement->user_id){
                $user = User::find($achievement->user_id); 
                $user->score++;
                $user->save();
            }
            $user = User::find($proof->user_id);
            $user->score = $user->score + $achievement->score;
            $user->save();
        }   
        $proof->status = $status;
        $proof->save();
        $followers_of_achievement = Achievement::fetch_followers($proof->achievement_id);
        foreach ($followers_of_achievement as $follower){
            $timeline = new Timeline;
            $timeline->user_id = $follower;
            $timeline->event = "change proof status " . $proof->status . " to " . (int)$status;
            $timeline->id = $proof->id;
            $timeline->save();
        }

        if ($achievement->status==2){
            $timeline = new Timeline;
            $timeline->user_id = $achievement->user_id;
            $timeline->event = "change achievement status " . $achievement->status . " to " . (int)$status;
            $timeline->achievement_id = $achievement->id;
            $timeline->save();
            $achievement->status = $status;
            $achievement->save();
        }
    }
    public static function check(){
        $proofs_needing_to_be_checked = Proof::where("status", 2)->orderBy("created_at", "asc")->get();
        foreach($proofs_needing_to_be_checked as $proof){
            $last_no_vote = Vote::where('proof_id', $proof->id)->where('vote_for', false)->orderBy('created_at', 'desc')->first();
            if (($last_no_vote==null && time()-strtotime($proof->created_at)>=Config::get('rla.max_time_to_not_vote'))
              || ($last_no_vote!=null && time()-strtotime($last_no_vote->created_at)>=Config::get('rla.max_time_to_not_vote'))
              || time()-strtotime($proof->created_at)>=Config::get('rla.max_time_to_vote')){
                Proof::changeStatus($proof->id, Proof::passing_approval($proof->id));
            }
        }
    }
    public function comments(){
        return $this->hasMany('\App\Comment');
    }
    public static function max_time_to_vote($id){
        $proof = Proof::where ("id", $id)->first();
        $begin = new DateTime($proof->created_at);
        $end = clone $begin;
        $end->add(new DateInterval('P1W'));
        $now = new DateTime(date('y-m-d H:i:s'));
        $interval = $now->diff($end);
        return format_interval($interval);

    }
    public static function min_time_to_vote($id){
        $string = "";
        $proof = Proof::where('id', $id)->first();
        $last_no_vote = Vote::where ("proof_id", $id)->where('vote_for', false)->orderBy('created_at', 'desc')->first();
        $begin = $last_no_vote!=null
          ? $begin = new DateTime($last_no_vote->created_at)
          : $begin = new DateTime($proof->created_at);
        $end = clone $begin;
        $end->add(new DateInterval('P1D'));
        $now = new DateTime(date('y-m-d H:i:s'));
        $interval = $now->diff($end);
        return format_interval($interval);
    }
    public static function passing_approval($id){
        $votes_for = count(Vote::where('proof_id', $id)->where('vote_for', true)->get());
        $votes_against = count(Vote::where('proof_id', $id)->where('vote_for', false)->get());
        if ($votes_for - $votes_against <= 0){
            return false;
        } else if ($votes_for - $votes_against > 0){
            return true;
        }
        return false;
    }
    public function user(){
        return $this->belongsTo("\App\User");
    }

    public function vote(){
        return $this->hasOne("\App\Vote");
    }
    //
}
