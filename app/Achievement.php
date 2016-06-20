<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Achievement extends Model
{
    public static function can_user_comment($id){
        if (Auth::guest()){
            return false;
        }
    }
    public static function can_user_submit_proof($id){
        if (Auth::guest()){
            return false;
        }
        $num_of_pending_proofs_by_user = count(Proof::where('user_id', Auth::user()->id)->where('status', 2)->where('achievement_id', $id)->get());
        $total_num_of_pending_proofs = count(Proof::where('status', 2)->where('achievement_id', $id)->get());
        $achievement = Achievement::where('id', $id)->first();
        if ($num_of_pending_proofs_by_user>0){
            return false;
            //ERROR - if more than 1
        }
        if ($achievement->status!=1){
            return $total_num_of_pending_proofs==0;
        }
        return true;
    }
    public static function can_user_vote($id){
        if (Auth::guest()){
            return false;
        }
        return  count(AchievementVote::where('user_id', Auth::user()->id)->where('achievement_id', $id)->get())==0;
    }
    public static function can_user_vote_on_proof($id){
        if (Auth::guest()){
            return false;
        }
        $achievement = Achievement::where('id', $id)->first();
        if ($achievement->status!=2){
            $num_of_proofs = count(Proof::where('achievement_id', $id)->where('status', 1)->where('user_id', Auth::user()->id)->get());
            if ($num_of_proofs>0){
                foreach (Proof::where('achievement_id', $id)->where('status', 2)->get() as $proof){
                    if (Proof::can_user_vote($proof->id)){
                        return true;
                    }
                }
                if($num_of_proofs>1){
                    //ERROR - the user has more than one approved ad per achievement.
                }
            }
        } else if ($achievement->status==2){
                $proof = Proof::where('achievement_id', $id)->where('status', 2)->first();
                return Proof::can_user_vote($proof->id);
        }
        return false;
    }
    public function comments(){
        return $this->hasMany('\App\Comment');
    }
    public static function fetch_followers($id){
        $followers = array();
        $follows  = Follow :: where ('achievement_id', $id)->get();
        foreach ($follows as $follow){
            $followers [] = $follow->user_id;
        }
        return $followers;
    }
    public static function fetch_owners($id){
        $owners = array();
        $proofs = Proof :: where ('achievement_id', $id)->where('status', 1)->get();
        foreach ($proofs as $proof){
            $owners [] = $proof->user_id;
        }
        return $owners;
    }
    public static function sort($achievements, $sort){
        switch($sort){
            case "date asc":
                return $achievements->sortBy('created_at');
                break;
            case "date desc":
                return $achievements->sortByDesc('created_at');
                break;
            case "name asc":
                return $achievements->sortBy('name');
                break;
            case "name desc":
                return $achievements->sortByDesc('name');
                break;        
            case "points asc":
                return $achievements->sortBy('score');
                break;
            case "points desc":
                return $achievements->sortByDesc('score');
                break;
            default:
                return $achievements->sortByDesc('score');
                break;
        }

    }
    public static function has_user_completed_achievement($id){
        if (Auth::guest()){
            return false;
        }
        $num_of_proofs = count(Proof::where ('achievement_id', $id)->where('status', 1)->where('user_id', Auth::user()->id)->get());
        if ($num_of_proofs>0){
            if ($num_of_proofs>1){
                //ERROR - user should not have more than one proof
            }
            return true;
        }
        return false;
    }
    public function user(){
        return $this->belongsTo("\App\User", 'user_id');
    }
    public function proofs(){
        return $this->hasMany("\App\Proof");
    }
    //
}
