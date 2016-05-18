<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Achievement extends Model
{
    public static function can_user_submit_proof($id){
        if (Auth::guest()){
            return false;
        }
        $num_of_approved_or_pending_proofs = count(Proof::where("achievement_id", $id)->where('user_id', Auth::user()->id)->where('status', '>', 0)->get());
        if ($num_of_approved_or_pending_proofs>0){
            return false;
        }
/*
        $achievement = Achievement::where('id', $id)->first();
        if (Auth::user()->id == $achievement->created_by){
            
        } else {
        }
  */      
        return true;
    }
    public static function can_user_vote($id){
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
    public function user(){
        return $this->belongsTo("\App\User", 'created_by');
    }
    public function proofs(){
        return $this->hasMany("\App\Proof");
    }
    //
}