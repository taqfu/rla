<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function achievement(){
        return $this->belongsTo('\App\Achievement');
    }
    public static function new_db_entry($achievement_id){
        $follow = new Follow;
        $follow->user_id = Auth::user()->id;
        $follow->achievement_id = $achievement_id;
        $follow->save();
    }
}
