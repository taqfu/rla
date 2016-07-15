<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class AchievementVote extends Model
{
    public static function new_db_entry($achievement_id){
        $achievement_vote = new AchievementVote;
        $achievement_vote->user_id = Auth::user()->id;
        $achievement_vote->achievement_id = $achievement_id;
        $achievement_vote->save();
    }
}
