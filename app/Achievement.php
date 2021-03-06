<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;
class Achievement extends Model
{
    public function approved_proofs(){
        return $this->hasMany("\App\Proof")->where('status', 1);
    }

    public static function can_user_comment($id){
        if (Auth::guest()){
            return false;
        }
    }

    public static function can_user_claim($id){
        if (Auth::guest()){
            return false;
        }
        $have_they_already_submitted_proof = 
          count(Proof::where('achievement_id', $id)->where('user_id', Auth::user()->id)->
          where('status', '1')->where('status', '2')->get())>0;
        $have_they_already_claimed = 
          count(Claim::where('achievement_id', $id)->where('user_id', Auth::user()->id)->whereNull('canceled_at')->get())>0;
        return (!$have_they_already_submitted_proof && !$have_they_already_claimed);

    }

    public static function new_db_entry($name, $url){
        $achievement = new Achievement;
        $achievement->name = $name;
        $achievement->user_id = Auth::user()->id;
        $achievement->url = $url;
        $achievement->save();
        return $achievement->id;
    }
    public static function did_they_just_create_an_achievement(){
        $last_achievement = Achievement::where('user_id', Auth::user()->id)
          ->orderBy('created_at', 'desc')->first();
        if($last_achievement!=null 
          && time()-strtotime($last_achievement->created_at) 
          < Config::get('rla.min_time_to_post')){
            $num_of_seconds = Config::get('rla.min_time_to_post') 
              - (time()-strtotime($last_achievement->created_at));
            $num_of_minutes = floor($num_of_seconds/60);
            $num_of_seconds = $num_of_seconds % 60;
            $error_msg = "You are doing this too often. Please wait ";
            if ($num_of_minutes>0){
                $error_msg = $error_msg . $num_of_minutes . " minutes";
            }
            if ($num_of_minutes>0 && $num_of_seconds>0){
                $error_msg = $error_msg . " and ";
            }
            if ($num_of_seconds>0){
                $error_msg = $error_msg . $num_of_seconds . " seconds";
            }
            $error_msg = $error_msg . " before trying again.";
            return $error_msg;
        }
        return false;
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

    public static function can_user_vote_achievement_up_or_down($id){
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
    public function claims(){
        return $this->hasMany('\App\Claim');
    }

    public function comments(){
        return $this->hasMany('\App\Comment');
    }

    public function denied_proofs(){
        return $this->hasMany("\App\Proof")->where('status', 0);
    }

    public static function fetch_claim($id){
        if (!Achievement::has_user_claimed_achievement($id) || Auth::guest()){
            //ERROR this should not be happening.
            return null;
        }
        return Claim::where('achievement_id', $id)->whereNull('canceled_at')->where('user_id', Auth::user()->id)->first()->id;
    }
    public static function fetch_sort($sort){
        switch ($sort){
            case "created_at asc":
                $column="created_at";
                $direction="asc";
                break;
            case "created_at desc":
                $column="created_at";
                $direction="desc";
                break;
            case "id asc":
                $column="id";
                $direction="asc";
                break;
            case "id desc":
                $column="id";
                $direction="desc";
                break;
            case "url asc":
                $column="url";
                $direction="asc";
                break;
            case "url desc":
                $column="url";
                $direction="desc";
                break;
            case "status asc":
                $column="status";
                $direction="asc";
                break;
            case "status desc":
                $column="status";
                $direction="desc";
                break;
            default:
                $column="created_at";
                $direction="desc";
                break;
        }
        return ['column'=>$column, 'direction'=>$direction];
    }
    public static function fetch_followers($id){
        $followers = array();
        $follows  = Follow :: where ('achievement_id', $id)->get();
        foreach ($follows as $follow){
            $followers [] = $follow->user_id;
        }
        return $followers;
    }
    public static function fetch_goal($id){
        if (!Achievement::is_this_on_their_bucket_list($id) || Auth::guest()){
            //ERROR this should not be happening.
            return null;
        }
        return Goal::where('achievement_id', $id)->whereNull('canceled_at')->where('user_id', Auth::user()->id)->first()->id;
    }

    public static function fetch_num_of_users_who_completed($id){
        return count(Proof :: distinct()->where('achievement_id', $id)->where('status', 1)->groupBy('useR_id')->get());
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
    public static function has_user_claimed_achievement($id){
        if (Auth::guest()){
            return false;
        }
        return count(Claim::where('achievement_id', $id)->whereNull('canceled_at')->where('user_id', Auth::user()->id)->get())>0;
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
    public static function has_user_followed_achievement($id){
        return count(Follow::where('achievement_id', $id)->where('user_id', Auth::user()->id)->get())>0;
    }
    public static function is_this_on_their_bucket_list($id){
        if (Auth::guest()){
            return false;
        }
        return count(Goal::where('achievement_id', $id)->whereNull('canceled_at')
          ->where('user_id', Auth::user()->id)->get())>0;
    }
    public static function passing_approval($id){
        $achievement = Achievement::find($id);
        if ($achievement->status!=2){
            return null;
        }
        $pending_proof = Proof::where('achievement_id', $id)->where('status', 2)->orderBy('created_at', 'desc')->first();
        if ($pending_proof==null){
            return null;
        } 
        return Proof::passing_approval($pending_proof->id);
    }
    public static function process_filters($filters){
        $string = "";
        foreach($filters['status'] as $name=>$val){
            if ($val){
                $string = $string . "&$name=on";
            }
        }
        foreach($filters as $name=>$val){
            if ($name!='status' && $val===true){
                $string = $string . "&$name=on";
            }
        }
        return $string;
    }
    
    public function proofs(){
        return $this->hasMany("\App\Proof");
    }

    public function user(){
        return $this->belongsTo("\App\User", 'user_id');
    }
}
