<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
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
